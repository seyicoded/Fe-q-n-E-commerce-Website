<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
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
        <title>FQCI&hearts;: ABOUT US</title>
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
                    #cover{
                        padding:0px;
                        width: 90%;
                        height: auto;  
                        position: relative;
                        margin: 2% 5%;
                        background: grey url('media/image/resource/a.jpg') no-repeat 0px 0px;
                        background-size: cover;
                        -o-background-size: cover;
                        -ms-background-size: cover;
                        -moz-background-size: cover;
                        -webkit-background-size: cover;
                        
                    }
                    #cov-2{
                        width: 80%;
                        position: relative;
                        margin: 2% 10% ;
                        background: rgba(255,255,255,0.1);
                    }
                </style>
                
                <div class="w3-container wow fadeIn w3-round w3-card-2" id="cover">
                    <div class="w3-container" style="width: 100%; height: 100%; background: rgba(255,255,255,0.5);">
                    <?php //onmouseover="this.classList.add('w3-animate-zoom')" onmouseout="this.classList.remove('w3-animate-zoom')"?>
                        <div class="w3-card-16 w3-round wow fadeInUp" id='cov-2' data-wow-duration="1000ms" data-wow-delay="1000ms">
                            <h3 class="w3-xxlarge w3-center w3-text-shadow" style="padding: 1%; text-transform: uppercase; font-weight: bold;">About Us</h3>
                            
                            <div class="w3-large w3-padding">
                                <?php include('au.txt');?>
                            </div>
                        </div>
                    </div>
                </div>
                
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
