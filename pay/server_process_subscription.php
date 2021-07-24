<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    $secret_key = $p->secret_key();

    //trxref
    if(isset($_GET['reference'])){
        $tnxref = $p->sqlr($con,($_GET['reference']));

        //start process
        $curl = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($curl,CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . rawurlencode($tnxref));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true); 
        //a

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
        }

        /*
            status 
            0 = no link generated
            1 = link generated
            2 = paid successfully && credited
            //not using
            3 = abadoned
            4 = failed
        */

        if('success' == $tranx->data->status){
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value

            //get data from ref
            //$tnxref

            $record = mysqli_query($con,"SELECT * FROM sl_session WHERE ref='$tnxref'");

            if(mysqli_num_rows($record) == 0){
                die('record of account not found. contact admin');
            }else{
                $record_data = mysqli_fetch_assoc($record);

                //check if transaction has been accounted

                if(intval($record_data['main_status'] == 1)){
                    $new_status = 2;
                    $user_id = $record_data['user_id'];
                    $duration = $record_data['duration_month'];
                    $pack_id = $record_data['pack_id'];

                    //get package info and price
                    $package_container = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM pay_package WHERE p_id='$pack_id'"));
                    // $package_price = $package_container['p_price'];
                    // //amount paid to site
                    // $amount = intval($package_price) * intval($duration);

                    //check if user linker record exist
                    $sql1 = mysqli_query($con,"SELECT * FROM subscription_linker WHERE puser_id='$user_id'");
                    if(mysqli_num_rows($sql1) == 0){
                        //create new linker record from now
                        $bind_date = date("Y-m-d", strtotime("today"));

                        //cant use variable
                        $start_date = date_create($bind_date);
                        $end_date = date_add($start_date, date_interval_create_from_date_string("$duration months"));
                        
                        $expire_date= date_format($end_date,"Y-m-d");

                        //update to link
                        /*
                            subscription_linker status
                            0 = undefined
                            1 = active
                            2 = expired
                        */

                        $status = 1;
                        if(mysqli_query($con,"INSERT INTO subscription_linker(package_id,puser_id,status,bind_date,exp_date) VALUES('$pack_id','$user_id','$status','$bind_date','$expire_date')")){
                            //update sl_session record
                            $main_status = 2;
                            if(mysqli_query($con,"UPDATE sl_session SET main_status='$main_status' WHERE ref='$tnxref'")){
                                header("Location: home".$php);
                            }else{
                                mysqli_query($con,"INSERT INTO subscription_linker(package_id,puser_id,status,bind_date,exp_date) VALUES('$pack_id','$user_id','$status','$bind_date','$bind_date')");
                            }
                        }else{
                            die("error, refresh or contact admin");
                        }
                    }else{
                        //update expire of old old
                        $sql1_data = mysqli_fetch_assoc($sql1);
                        $old_e_date = date("Y-m-d", strtotime($sql1_data['exp_date']));

                        //cant use variable
                        $start_date = date_create($old_e_date);
                        $end_date = date_add($start_date, date_interval_create_from_date_string("$duration months"));
                        
                        $expire_date= date_format($end_date,"Y-m-d");

                        //update to link
                        /*
                            subscription_linker status
                            0 = undefined
                            1 = active
                            2 = expired
                        */

                        $status = 1;
                        if(mysqli_query($con,"UPDATE subscription_linker SET package_id = '$pack_id', status = '$status', exp_date='$expire_date' WHERE puser_id='$user_id'")){
                            //update sl_session record
                            $main_status = 2;
                            if(mysqli_query($con,"UPDATE sl_session SET main_status='$main_status' WHERE ref='$tnxref'")){
                                header("Location: home".$php);
                            }else{
                                mysqli_query($con,"INSERT INTO subscription_linker(package_id,puser_id,status,bind_date,exp_date) VALUES('$pack_id','$user_id','$status','$bind_date','$bind_date')");
                            }
                        }else{
                            die("error, refresh or contact admin");
                        }

                    }


                    //acknowledge payment from sl_session
                }else if(intval($record_data['main_status'] == 2)){
                    ?>
                        <script>
                            alert('payment acknowledged');
                            window.location.replace('home<?php echo $php;?>');
                        </script>
                    <?php
                }else if(intval($record_data['main_status'] >= 3)){
                    die('contact admin');
                }


            }

            
            
        }else if('abandoned' == $tranx->data->status){
            //echo 'dis';
            //echo $tranx->data->status;
            $payment_data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM sl_session WHERE ref='$tnxref'"));
            header('Location: '.$payment_data['pay_url']);
            
        }else if('failed' == $tranx->data->status){
            //echo $tranx->data->status;
            $payment_data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM sl_session WHERE ref='$tnxref'"));
            die('try again by <a href="'.$payment_data['pay_url'].'">clicking here</a>, or contact admin');
        }
        //end process

    }
?>