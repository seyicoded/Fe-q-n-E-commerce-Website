<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();

    $msg = "";

    if(isset($_POST['login'])){
        $Email = $p->sqlr($con,$p->xssr($_POST['Email']));
        $password = $p->sqlr($con,$p->xssr($_POST['password']));

        $new_pas = sha1($password);
        //check if user already exist
        $data = mysqli_query($con,"SELECT * FROM pay_users WHERE pu_email='$Email' && pu_password='$new_pas'");
        if( mysqli_num_rows($data) != 0){
            
            //get the user_id
            $data = mysqli_fetch_assoc($data);
            $_SESSION[md5('pu_id')] = base64_encode($data['pu_id']);
            $_SESSION[md5('pu_state')] = base64_encode(true);

            header("Location: home.php");
        }else{
            //user already exist
            $msg = "account not found";
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
                    <h1 class="w3-center w3-small" style="font-weight:bolder;">SIGN IN</h1>
                </div>

                <div>
                    <input class="w3-input" id="Email" type="email" name="Email" placeholder="Enter Your Email" required/>
                    <label class="w3-label w3-validate" for="Email">Email</label>
                </div>

                <div>
                    <input class="w3-input" id="password" type="password" name="password" placeholder="Enter Your Full Name" required/>
                    <label class="w3-label w3-validate" min="8" for="password">Password</label><span class="w3-text-green w3-right" onclick="toggle_pass()" style="cursor:pointer;">toggle password</span>
                </div>

                <div class="w3-container w3-padding w3-margin w3-center"><?php echo $msg;?></div>

                <div>
                    <input class="w3-btn w3-right w3-green w3-card-2 w3-round" type="submit" name="login" value="LOGIN"/>
                </div>
                

                <br><br><br>

                <a class="w3-right w3-small" href="recover_password.php" style="text-decoration: none; font-style:italic;">Recover Password</a>

            </form>
        </div>
    </div>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>
