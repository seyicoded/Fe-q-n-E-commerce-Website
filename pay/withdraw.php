<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");

    $msg ='';
    if(isset($_POST['SEND'])){
        // check, put in database, den deduce the amount from user to avoid double placement
        $amount = $p->sqlr($con,$p->xssr($_POST['amount']));
        $accountname = $p->sqlr($con,$p->xssr($_POST['accountname']));
        $bankname = $p->sqlr($con,$p->xssr($_POST['bankname']));
        $banktype = $p->sqlr($con,$p->xssr($_POST['banktype']));
        $account_numeber = $p->sqlr($con,$p->xssr($_POST['account_numeber']));
        $checkbox = $p->sqlr($con,$p->xssr($_POST['checkbox']));

        if($checkbox == 'on'){
            //print_r($pu_r);
            if(intval($pu_r['pu_wallet']) >= intval($amount)){
                $new_amount = intval($pu_r['pu_wallet']) - intval($amount);
                //deduce from user account first
                $puid = $pu_r['pu_id'];
                if(mysqli_query($con,"UPDATE pay_users SET pu_wallet='$new_amount' WHERE pu_id='$puid'")){
                    //now add to record den reload this page
                    $status = 0;
                    $sqlwd = "INSERT INTO pay_wthdrawal(pu_id,account_name,bank_name,bank_type,acount_number,amount,status) VALUES('$puid','$accountname','$bankname','$banktype','$account_numeber','$amount','$status')";
                    if(mysqli_query($con,$sqlwd)){
                        header('Location: withdrawal_history'.$php);
                    }else{
                        mysqli_query($con,"UPDATE pay_users SET pu_wallet='".$pu_r['pu_wallet']."' WHERE pu_id='$puid'");
                        header('Location: withdraw'.$php);
                    }
                }else{
                    $msg = "an error occurred, try again later";
                }
            }else{
                $msg = "haba na, have heart";
            }
        }else{
            $msg = 'must accept our terms of payment';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay DashBoard</title>
    
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

    <div id="main-content">
    <?php
        //$pu_r
    ?>
        <div class="container align-items-center">
            <div class="form-signin w3-card-4 py-4 my-4 w3-round">
                <form method="post" id="registration_container" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="align-items-center w3-center">
                        <img src="media/svg/treasure.svg"/>
                    </div>

                    <div>
                        <h1 class="w3-center w3-small" style="font-weight:bolder;">CASH OUT|WITHDRAW</h1>
                    </div>

                    <div>
                        <input class="w3-input" id="amount" type="number" name="amount" max="<?php echo $pu_r['pu_wallet'];?>" min="0    " placeholder="Enter Your Amount" required/>
                        <label class="w3-label w3-validate" for="Email">Amount <small class="w3-small">max: <?php echo $pu_r['pu_wallet'];?></small></label>
                    </div>                    

                    <div>
                        <input class="w3-input" id="accountname" type="text" name="accountname" placeholder="Enter Your Account Name" required/>
                        <label class="w3-label w3-validate" for="accountname">ACCOUNT NAME</label>
                    </div>

                    <div>
                        <input class="w3-input" id="bankname" type="text" name="bankname" placeholder="Enter Your Bank Name" required/>
                        <label class="w3-label w3-validate" for="bankname">Bank NAME| (e.g GTBANK: savings)</label>
                    </div>

                    <div>
                        <select name="banktype" id="banktype" class="w3-input" required>
                            <option value="Current">Current</option>
                            <option value="Saving">Saving</option>
                            <option value="Saving">Other: entered in bank email</option>
                        </select>
                        <label class="w3-label w3-validate" for="banktype">Bank Type</label>
                    </div>

                    <div>
                        <input class="w3-input" id="account_numeber" type="type" maxlength="14" minlength="8" name="account_numeber" placeholder="Enter Your Bank Account Number" required/>
                        <label class="w3-label w3-validate" for="bankname">Account Number</label>
                    </div>

                    <div>
                        <input type="checkbox" name="checkbox" required/> I hereby authenticate this payment from my wallet to the above account as an act of clicking the checkbox.
                    </div>

                    <div class="w3-container w3-padding w3-margin w3-center"><?php echo $msg;?></div>

                    <div>
                        <div class="alert alert-info w3-small">Money would only be deposited only after user account has been vetted and approved by admin which takes upto 24 hour to 48 hours, in case of emergency contact us directly. </div>
                        <input class="w3-btn w3-right w3-green w3-card-2 w3-round" type="submit" name="SEND" value="SEND"/>
                    </div>
                    

                    <br><br><br>
                    &nbsp;

                </form>
            </div>
        </div>
        
        </div>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>

