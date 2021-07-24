<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();

    $msg = "";

    if(isset($_POST['register'])){
        $fullName = $p->sqlr($con,$p->xssr($_POST['fullName']));
        $Email = $p->sqlr($con,$p->xssr($_POST['Email']));
        $password = $p->sqlr($con,$p->xssr($_POST['password']));
        $tel = $p->sqlr($con,$p->xssr($_POST['tel']));
        $referral_code = $p->sqlr($con,$p->xssr($_POST['referral_code']));

        $new_pas = sha1($password);
        //check if user already exist
        if( mysqli_num_rows(mysqli_query($con,"SELECT * FROM pay_users WHERE pu_email='$Email'")) == 0){
            $sql = "INSERT INTO pay_users(pu_fullname,pu_email,pu_password) VALUES('$fullName','$Email','$new_pas')";
            if(mysqli_query($con,$sql)){
                //get the user_id
                $data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM pay_users WHERE pu_email='$Email'"));
                $_SESSION[md5('pu_id')] = base64_encode($data['pu_id']);
                $_SESSION[md5('pu_state')] = base64_encode(true);

                //store referral info into database
                if(($referral_code != null) && ($referral_code != '')){
                    mysqli_query($con,"INSERT INTO referral_linker(referral_code,new_user_id) VALUES('$referral_code','".$data['pu_id']."')");
                }
                header("Location: home.php");
            }else{
                $msg = "an error occurred creating account, try again later...";
            }
        }else{
            //user already exist
            $msg = "account already exist, consider using another email or try our forget email";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Registration Page</title>
    
    <?php
        include('include/head.php');
    ?>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <script type="text/javascript" src="src/js/index.js"></script>
</head>
<body>

    <?php
        include("include/unsignedheader.php");
    ?>

    <style>
        .w3-label{
            margin-bottom: 9px;
        }
    </style>

    <script>
        var i = 0;
        function toggle_pass(){
            if(i == 0){
                $("#password").attr("type","text");
                i=1;
            }else{
                $("#password").attr("type","password");
                i=0;
            }
            
        }
    </script>

    <div class="container align-items-center">
        <div class="form-signin w3-card-4 py-4 my-4 w3-round">
            <form method="post" id="registration_container" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="align-items-center w3-center">
                    <img src="media/svg/machine.svg"/>
                </div>

                <div>
                    <h1 class="w3-center w3-small" style="font-weight:bolder;">Fill This Form</h1>
                </div>

                <div>
                    <input class="w3-input" id="fullName" name="fullName" placeholder="Enter Your Full Name" required/>
                    <label class="w3-label w3-validate" for="fullName">Full Name</label>
                </div>

                <div>
                    <input class="w3-input" id="Email" type="email" name="Email" placeholder="Enter Your Email" required/>
                    <label class="w3-label w3-validate" for="Email">Email</label>
                </div>

                <div>
                    <input class="w3-input" id="password" type="password" name="password" placeholder="Enter Your Full Name" required/>
                    <label class="w3-label w3-validate" min="8" for="password">Password</label><span class="w3-text-green w3-right" onclick="toggle_pass()" style="cursor:pointer;">toggle password</span>
                </div>

                <div>
                    <input class="w3-input" id="tel" type="tel" name="tel" placeholder="Enter Your Phone Number" required/>
                    <label class="w3-label w3-validate" for="tel">phone</label>
                </div>

                <div>
                    <?php
                        if(isset($_GET['refcode'])){
                            ?>
                                <input class="w3-input" id="referral_code" value="<?php echo $_GET['refcode'];?>" name="referral_code" placeholder="Enter Your Referral Code if any"/>
                            <?php
                        }else{
                            ?>
                                <input class="w3-input" id="referral_code" name="referral_code" placeholder="Enter Your Referral Code if any"/>
                            <?php
                        }
                    ?>
                    <label class="w3-label w3-validate" for="tel">Referral Code</label>
                </div>

                <div class="w3-container w3-padding w3-margin w3-center"><?php echo $msg;?></div>

                <div>
                    <input class="w3-btn w3-right w3-green w3-card-2 w3-round" type="submit" name="register" value="REGISTER"/>
                </div>

                <br><br><br>

            </form>
        </div>
    </div>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>
