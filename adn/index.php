
<?php
    session_start();
    include("../include/connectdb.php");
    include("config.php");
    $p = new db();
    $con = $p->con(); 
    
    if(isset($_POST['login'])){
        $username = strtolower($p->sqlr($con,$p->xssr($_POST['username'])));
        $password = strtolower($p->sqlr($con,$p->xssr($_POST['password'])));
        
        if( ($username == $real_username_admin) && ($password == $real_password_admin) ){
            setcookie(md5("admin_signed_in"),sha1("true"),( time() + (86400 * 365)), "/");
            setcookie(md5("admin_authen"),base64_encode($authen),( time() + (86400 * 365)), "/");
            
            header("Location:homepage.php");
            ?>
                <script type="text/javascript">
                    window.location.replace("homepage.php");
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript">
                    alert('authentication invalid');
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FQCI: ADMIN</title>
        <link rel="stylesheet" href="../template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../template/lib/w3.css">         
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/animate.min.css"> 
        <script type="text/javascript" src="../template/js/jquerym.js"></script>       
        <style type="text/css">
            body{
                width:100%;
                height:100%;
            }
            #bg-img{
                position: fixed;
                z-index:-1;
                top:0px;
                left:0px;
                width:100%;
                height:100%;
                opacity:80%;
            }
            #content{
                background: rgba(0,0,0,0.7);
                position: relative;
                z-index:1;
                top:0px;
                left:0px;
                width:100%;
                height:100%;
                overflow: auto;
                color:white;
            }
            
            @media screen and (max-width: 500px){
                #site-content{
                    width:90%;
                    margin:10% 5%;                     
                }
            }
            @media screen and (min-width: 501px){
                #site-content{
                    width:70%;
                    margin:8% 15%;                    
                }
            }
            
            @font-face {
                font-family: stylle;
                src: url('BAZARONI.TTF');
            }
            .w3-input{
                background: rgba(255,255,255,0) !important;
                border-bottom: 1px solid white;
                text-align: center;
                color: white;
                width:80%;
                margin: 1% 10%;
            }
            .w3-input:focus, .w3-input:active{
                background: rgba(255,255,255,0) !important;
            }
            button{
                width:80%;
                margin: 1% 10%;
            }
        </style>
    </head>
    <body>        
        <img src="../media/image/resource/a.jpg" id='bg-img'>
        
        <div id='content'>
            
            <div id='site-content'>
                <h1 class="w3-center " style="text-transform: uppercase; font-family: stylle; font-weight: bolder;">FQCI ADMIN PORTAL</h1>
                <h2 class="w3-center" style=" font-family: stylle;">LOGIN</h2>
                
                <br>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="w3-center">
                    <div>
                        <input type="text" class="w3-input" name="username" placeholder="Enter username" required>
                        <label class="w3-validate w3-label">username</label>
                    </div>
                    
                    <div>
                        <input type="password" class="w3-input" name="password" placeholder="Enter Password" required>
                        <label class="w3-validate w3-label">password</label>
                    </div>
                    
                    <br>
                    <div>
                        <button class="w3-round w3-btn w3-green" type="submit" name="login" style="font-weight:bold;">LOGIN</button>
                    </div>
                </form>
            </div>
            
        </div>   
        
        <script type="text/javascript">
            $("#content").css("height",($(window).height())+"px");
        </script>              
        
        <script type="text/javascript" src="../template/js/wow.min.js"></script>
        <script type="text/javascript" src="../template/bootstrap/js/bootstrap.min.js"></script>
        <script src="../owlcarousel/owl.carousel.min.js"></script>
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
