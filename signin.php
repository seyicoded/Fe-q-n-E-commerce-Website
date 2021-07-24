<?php
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    
    if(isset($_POST['submit'])){
        //$pname = $p->sqlr($con,$p->xssr($_POST['p_name']));
        $email = $p->sqlr($con,$p->xssr($_POST['email']));
        $name = $p->sqlr($con,$p->xssr($_POST['name']));
        $tel = $p->sqlr($con,$p->xssr($_POST['tel']));
        
        $sql = mysqli_query($con,"SELECT * FROM ordered WHERE email='$email' AND full_name LIKE '%$name%' AND phone LIKE '%$tel%'");
        $num = mysqli_num_rows($sql);
        
        if($num == 0){
            ?>
                <script type="text/javascript">
                    alert('account not found');
                </script>
            <?php
        }else{
            $r = mysqli_fetch_assoc($sql);
            
            //store user data into cookies
            setcookie(md5('signed_data'),base64_encode('true'), time () + (86400 * 365) , '/');
            setcookie(md5('full_name'),base64_encode($r['full_name']), time () + (86400 * 365) , '/');
            setcookie(md5('email'),base64_encode($email), time () + (86400 * 365) , '/');
            setcookie(md5('phone'),base64_encode($r['phone']), time () + (86400 * 365) , '/');
            setcookie(md5('address'),base64_encode($r['address']), time () + (86400 * 365) , '/');
            ?>
                <script type="text/javascript">
                    window.location.replace('view-purchase.php');
                </script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
    
        <meta name="description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various ">
        <link rel="canonical" href="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:title" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:image" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/media/image/icon/icon.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="350">
        <meta property="og:image:height" content="400">
        <meta property="og:image:alt" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various "> 
        <meta name="copyright" content="FQCI is protected by copyright.">
        <meta name="keywords" content="website, fqci, marketing, drugs, products, goods, health, curative, greenlife, official">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FEMQUEN And Co. Int'l</title>
        <link rel="stylesheet" href="template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="template/lib/w3.css">         
        <link rel="stylesheet" href="template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="template/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="template/css/index.css">
        <script type="text/javascript" src="template/js/jquerym.js"></script>
        <script type="text/javascript" src="template/js/index.js"></script>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id='body' class="w3-container w3-padding-0 w3-margin-0">
            
            <?php
                //import header
                include("include/header.php");
            ?>
            
            <div id='content' class="w3-container w3-padding-0 w3-margin-0">
                
                <?php /* site content goes here */?>
                
                <style type="text/css">
                    @media screen and (max-width: 500px){
                        #cent{
                            width:98%;
                            margin: 6% 1%;
                        }
                    }
                    @media screen and (min-width: 501px){
                        #cent{
                            width:50%;
                            margin: 4% 25%;
                        }
                    }
                </style>
                
                <form id='cent' class="w3-card-4 w3-round w3-padding" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <h1 class="w3-center" style="font-weight: 700; color: grey;">SIGN IN</h1>
                    <br>
                    
                    <div>
                        <input class="w3-input" type="email" placeholder="Enter Email Address used in purchase" name="email" required>
                        <label class="w3-validate w3-label"><i>Email</i></label>
                    </div>
                    
                    <div>
                        <input class="w3-input" type="text" placeholder="Enter Any Name used from full name" name="name" required>
                        <label class="w3-validate w3-label"><i>Name</i></label>
                    </div>
                    
                    <div>
                        <input class="w3-input" type="tel" placeholder="Enter phone number used" name="tel" required>
                        <label class="w3-validate w3-label"><i>Phone</i></label>
                    </div>
                    
                    <div>
                        <button class="w3-btn-block w3-round w3-light-green w3-text-white" type="submit" name="submit" style="font-weight:bolder;">SIGN IN</button>
                    </div>
                    <br>
                </form>
                
            </div>
            
            <?php
                //import footer
                include("include/footer.php");
            ?>
            
        </div>
        <script type="text/javascript" src="template/js/wow.min.js"></script>
        <script type="text/javascript" src="template/bootstrap/js/bootstrap.min.js"></script>
        <script src="owlcarousel/owl.carousel.min.js"></script>
        <script type="text/javascript">
            //Initiat WOW JS
            new WOW().init();
        </script>
        <script>
            $('.carousel').carousel({
                interval:3000,
                pause:"hover"
            })
        </script>
    </body>
</html>
