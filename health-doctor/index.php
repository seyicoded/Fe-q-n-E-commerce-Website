<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta name="description" content="Our list of Compensation benefits would leave you stunt, check the page to find out more">
        <link rel="canonical" href="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/health-doctor/">
        <meta property="og:title" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/health-doctor/">
        <meta property="og:image" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/media/image/icon/icon.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="350">
        <meta property="og:image:height" content="400">
        <meta property="og:image:alt" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:description" content="Our list of Compensation benefits would leave you stunt, check the page to find out more"> 
        <meta name="copyright" content="FQCI is protected by copyright.">
        <meta name="keywords" content="website, fqci, marketing, drugs, products, goods, health, curative, greenlife, compensations, incomes, benefits, profits, official">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">                                                  
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FQCI&hearts; All Articles</title>
        <link rel="stylesheet" href="../template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../template/lib/w3.css">         
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="../template/css/index.css">
        <script type="text/javascript" src="../template/js/jquerym.js"></script>
        <script type="text/javascript" src="../template/js/index.js"></script>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id="body" class="w3-container w3-padding-0 w3-margin-0">
            
            <?php
                //import header
                include("config/new-header.php");
            ?>
            
            <div id="content" class="w3-container w3-padding-0 w3-margin-0">
                
                <?php /* site content goes here */?>
                
                <div class="w3-container w3-margin">
                    
                   <div class="w3-row">
                        
                        <?php
            include("../include/connectdba.php");
            $p = new dba();
            $con = $p -> con();
            $sql = mysqli_query($con,"SELECT * FROM `health_doctor` ORDER BY hd_id DESC");
            $num = mysqli_num_rows($sql);
            
            $site_hd_url = "http://".$_SERVER['SERVER_NAME']."/femquen/health-doctor/";
            for($i=0; $i < $num; $i++){
                $r = mysqli_fetch_assoc($sql);
                
                $p = ($i >= 6) ? "1": $i;
                $ii = ((intval($p) * 3) + 7) . "00";
                
                ?>
                    <div class="w3-col s12 m6 l4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="<?php echo $ii;?>ms">
                        <div class="w3-card-4 w3-margin w3-center" style="cursor:pointer;">
                            <a href="<?php echo $site_hd_url.$r['page_url'];?>" target="_blank">
                                <img class="w3-responsive" style="width:100%; height: 280px;" src="<?php echo $site_hd_url."image/".$r['image_url'];?>" alt="<?php echo $r['title'];?>">
                                <div class="w3-text-shadow w3-margin" style="text-transform: uppercase; padding-bottom: 10px; padding-top: 6px;"><?php echo $r['title'];?></div>
                            </a>
                        </div>
                    </div>
                <?php
            }
        ?>
                        
                   </div>
                    
                </div>
                
            </div>
            
            <?php
                //import footer
                include("../include/footer.php");
            ?>
            
        </div>
        
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
