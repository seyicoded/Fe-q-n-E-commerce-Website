<?php

    //load checker to see if it's expired
    
    function check_expire($con){
        $check_status = 1;
        $sql = mysqli_query($con,"SELECT * FROM subscription_linker WHERE status='$check_status'");
        while($r = mysqli_fetch_assoc($sql)){
            $date_now = strtotime("today");
            $date_exp = strtotime($r['exp_date']);
            
            if($date_now <= $date_exp){
                //normal
            }else{
                //expire
                $si_id = $r['si_id'];
                $status = 2;
                mysqli_query($con,"UPDATE subscription_linker SET status='$status' WHERE si_id='$si_id'");
            }
        }
    }

    $puid = null;

    if(isset($_SESSION[md5('pu_state')])){
        check_expire($con);        
        $puid = base64_decode($_SESSION[md5('pu_id')]);

        //check if user exist
        $data = mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$puid'");
        if(mysqli_num_rows($data) != 0){
            $r = mysqli_fetch_assoc($data);
            $pu_r = $r;

            // do some checkin to see if user is expired, or not active yet

            //in subscription link, status is 0 = not active, one for active, 2 is expired
            // if null den not yet subscribe

            $rsll = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM subscription_linker WHERE puser_id='".$r['pu_id']."'"));

            if(count($rsll) == 0){
                header('Location: subsribe'.$php);
            }else{
                //do some other verification
                //check status

                $expire_status = intval($rsll['status']);
                $expire_date = $rsll['exp_date'];

                //check to see if it's expired
                if($expire_status != 1){
                    //check sl_session for pending
                    $dtch_session = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM sl_session WHERE user_id='".$r['pu_id']."' && main_status != '2'"));
                    if( count($dtch_session) != 0 ){
                        header('Location:'.$dtch_session['pay_url']);
                    }
                    //expired
                    ?>
                        <script>
                            alert('subscription has expired');
                            window.location.replace('<?php echo 'subsribe'.$php;?>')
                        </script>
                    <?php
                }
                
                //update referral amount.. if not added
                //check if refferal hasn't been settled
                $ref_linker = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM referral_linker WHERE new_user_id='".$r['pu_id']."'"));
                if(count($ref_linker) != 0){
                    if( intval($ref_linker['status']) != 1 ){
                        //let's settle referral then
                        //...

                        $package_id = $rsll['package_id'];
                        $package_amount = ((mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_package WHERE p_id = '$package_id'"))))['p_price'];
                        $package_amount = intval($package_amount);

                        $ten_percent = floor((10 * $package_amount) / 100);

                        //add amount to referral wallet
                        $referral_id = $ref_linker['referral_code'];
                        $referral_id = str_ireplace("REFCODE", "", $referral_id);
                        $referral_wallet = ((mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id = '$referral_id'"))))['pu_wallet'];
                        $new_referral_amount = intval($referral_wallet) + $ten_percent;
                        //update referral account
                        if( mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$new_referral_amount' WHERE pu_id = '$referral_id'") ){

                            $one = 1;
                            if(mysqli_query($con, "UPDATE referral_linker SET status = '$one' WHERE new_user_id='".$r['pu_id']."'")){

                            }else{
                                mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$referral_wallet' WHERE pu_id = '$referral_id'");
                            }

                        }else{
                            mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$referral_wallet' WHERE pu_id = '$referral_id'");
                        }

                    }
                }


                //daily login aspect
                $today = date("Y-m-d", strtotime("today"));
                //checker
                $daily_dt = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM daily_login_logger WHERE day_count='$today' && user_id='".$pu_r['pu_id']."'"));

                if( count($daily_dt) == 0){
                    //first time logging in today
                    $package_id = $rsll['package_id'];
                    $package_amount = ((mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_package WHERE p_id = '$package_id'"))))['p_price'];
                    $one_percent = floor((1 * $package_amount) / 100);

                    $user_wallet = $pu_r['pu_wallet'];
                    $new_user_wallet = intval($user_wallet) + $one_percent;
                    //update referral account
                    if( mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$new_user_wallet' WHERE pu_id = '".$pu_r['pu_id']."'") ){

                        if(mysqli_query($con, "INSERT INTO daily_login_logger(user_id, day_count) VALUES('".$pu_r['pu_id']."', '$today')")){
                            ?>
                                <script>
                                    window.location.reload();
                                </script>
                            <?php
                        }else{
                            mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$user_wallet' WHERE pu_id = '".$pu_r['pu_id']."'");
                        }
                    }
                    
                    
                }

                
            }
        }else{
            header("Location: login".$php);
        }
    }else{
        header("Location: login".$php);
    }
?>