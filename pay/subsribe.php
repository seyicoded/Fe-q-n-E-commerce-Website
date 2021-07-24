<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    $secret_key = $p->secret_key();

    $puid = base64_decode($_SESSION[md5('pu_id')]);
    $data = mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$puid'");
    $r = mysqli_fetch_assoc($data);
    $pu_r = $r;
    $rsll = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM subscription_linker WHERE puser_id='".$r['pu_id']."'"));
    $expire_status = (!(isset($rsll['status'])) ? '': $rsll['status']);
    $expire_date = (!(isset($rsll['exp_date'])) ? '': $rsll['exp_date']);

    $msg = "";
    
    if(isset($_SESSION[md5('pu_state')])){
        
        $puid = base64_decode($_SESSION[md5('pu_id')]);

        //check if user exist
        $data = mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$puid'");
        if(mysqli_num_rows($data) != 0){
            $r = mysqli_fetch_assoc($data);
        }else{
            header("Location: login".$php);
        }
    }else{
        header("Location: login".$php);
    }

    if(isset($_POST['Subscribe'])){
        print_r($_POST);
        $package_id = $p->sqlr($con,$p->xssr($_POST['package_']));
        $package_id = ($package_id == 'null') ? '1' : $package_id;
        $duration = $p->sqlr($con,$p->xssr($_POST['duration']));
        $puid = base64_decode($_SESSION[md5('pu_id')]);
        $ref = "FQCI_PT".date("Y.m.d.h.i.sa").rand(0,110);

        //get data for paystack
        $email = $r['pu_email'];

        $amound_data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM pay_package WHERE p_id='$package_id'"));
        $r_amount = intval($amound_data['p_price']);
        //amount + service charge
        $amount = $r_amount + 100 + (($r_amount * 1.5) / 100);

        $amount = $amount * 100;

        $callback_url = 'http://'.$_SERVER['SERVER_NAME'].'/femquenn/pay/server_process_subscription.php';  
        
        /*
            status 
            0 = no link generated
            1 = link generated
            2 = paid successfully && credited
            3 = abadoned
            4 = failed
        */

        //start

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount'=>$amount,
            'email'=>$email,
            'ref' => $ref,
            'trx_ref' => $ref,
            'reference' => $ref,
            'callback_url' => $callback_url
        ]),
        CURLOPT_HTTPHEADER => [
            "authorization: Bearer $secret_key", //replace this with your own test key
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if(!$tranx['status']){
        // there was an error from the API
        print_r('API returned error: ' . $tranx['message']);
        die('try again or contact admin');
        }

        // comment out this line if you want to redirect the user to the payment page
        print_r($tranx);
        // redirect to page so User can pay
        // uncomment this line to allow the user redirect to the payment page
        $pay_link = $tranx['data']['authorization_url'];
        $main_status = 1;
        $sql = "INSERT INTO sl_session(user_id,pack_id,duration_month,ref,pay_url,main_status) VALUES('$puid','$package_id','$duration','$ref','$pay_link',$main_status)";

        if( mysqli_query($con,$sql) ){
            //update referral info, if any
            try {
                mysqli_query($con, "UPDATE referral_linker SET new_user_pack_id = '$package_id' WHERE new_user_id = '$puid'");
            } catch (Exception $e) {
                //throw $th;
            }
            header("Location: $pay_link");
        }else{
            ?><script>
                alert('error, try again');
                window.location.replace('subsribe'.$php);
            </script><?php
        }
        //header('Location: ' . $tranx['data']['authorization_url']);

        //stop
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Subscription Page</title>
    
    <?php
        include('include/head.php');
    ?>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <script type="text/javascript" src="src/js/index.js"></script>
</head>
<body>

    <?php
        include("include/signedHeader.php");
    ?>

    <style>
        .w3-label{
            margin-bottom: 9px;
        }
    </style>

    <div class="container align-items-center">
        <div class="w3-card-4 py-4 my-4 w3-round px-2">
            <form method="post" id="registration_container" action="<?php echo $_SERVER['PHP_SELF'];?>">
                
                <h2 class="w3-center">Subscription</h2>

                <div>
                    <h4>Click on a Package to Select It</h4>
                    <small class="w3-small" style="font-style: italic;">hover and wait on any to view it's details</small>
                    <div class="row">
                        <?php
                            $data = (mysqli_query($con,"SELECT * FROM pay_package ORDER BY p_id ASC"));
                            for ($i=0; $i < mysqli_num_rows($data) ; $i++) { 
                                $res = mysqli_fetch_assoc($data);
                                $id = $res['p_id'];
                                $price = intval($res['p_price']);
                                $h_of_p = ($price / 100);

                                ?>
                                    <div class="w3-col m6 l4 l3 w3-padding">
                                        <div class="w3-card-2 p-3 package_container" title="<?php echo $res['p_desc'];?>" style="cursor: pointer;" id='p-<?php echo $id;?>' onclick="clicked(this,'<?php echo $id;?>')">
                                            <h4 class="w3-center" style="font-weight: bold;"><?php echo $res['p_name'];?></h4>
                                            <h3 class="w3-center" style="font-weight: bolder; font-size: 35px;">N <?php echo number_format($res['p_price']);?></h3>
                                            <table class="w3-table">
                                                <tr>
                                                    <td>Referral Bonus</td>
                                                    <td>10% on the person's package</td>
                                                    <td>N<?php echo (number_format(10 * $h_of_p));?></td>
                                                </tr>

                                                <tr>
                                                    <td>Daily Login Bonus</td>
                                                    <td>1%</td>
                                                    <td>N<?php echo (number_format(1 * $h_of_p));?></td>
                                                </tr>

                                                <tr>
                                                    <td>Sponspor Post Read</td>
                                                    <td>4%</td>
                                                    <td>N<?php echo (number_format(4 * $h_of_p));?></td>
                                                </tr>

                                                <tr>
                                                    <td>Regular Posting</td>
                                                    <td>6%</td>
                                                    <td>N<?php echo (number_format(6 * $h_of_p));?></td>
                                                </tr>

                                                <tr>
                                                    <td>Graphic Content</td>
                                                    <td>%.</td>
                                                    <td>Depends on it's gravity</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>

                    <input type="hidden" name="package_" id="package_" value="null"/>
                </div>
                <br>

                <div>
                    <select class="form-control" name="duration" required>
                        <option>click to select</option>
                        <?php
                        
                            $d = 12;
                            $a = 8;

                            for($i = 3 ; $i < 78 ; $i+=3){
                                ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?> month</option>
                                <?php
                            }
                        ?>
                    </select>
                    <label class="w3-label w3-validate">Select Month</label>
                </div>
                <br>

                <div class="w3-container w3-padding w3-margin w3-center"><?php echo $msg;?></div>

                <div>
                    <input class="w3-btn w3-right w3-green w3-card-2 w3-round" type="submit" name="Subscribe" value="Subscribe"/>
                </div>
                

                <br><br>

            </form>
        </div>
    </div>

    <script>
        function clicked(cont, id){
            $('.package_container').css({'background':'none', 'color':'black'});
            $('#p-'+id).css({'background':'green', 'color':'white'});
            //package_
            $("#package_").val(id);
        }
    </script>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>
