<?php
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    
    if(isset($_GET['ref'])){
        $ref = $p->sqlr($con,$p->xssr($_GET['ref']));
        $status = 1;
        
        $sql = mysqli_query($con,"SELECT * FROM transaction AS a INNER JOIN ordered AS b ON a.o_id=b.o_id WHERE a.reference='$ref' AND a.status='$status'");
        
        if( (mysqli_num_rows($sql)) != 0 ){
            $r = mysqli_fetch_assoc($sql);
            
            //if(){                                              }
        }else{
            header("location:payment-error-message.php?ref=$refernce&error21=true");
        }
    }else{
        header("location:payment-error-message.php?ref=$refernce&error20=true");
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
        <style type="text/css">
            
            body{
                background: white url('media/image/greenlife/award/service-12.jpg') no-repeat 0px 0px;
                width: 100%;
                height: 100%;
                background-size: cover;
                -o-background-size: cover;
                -ms-background-size: cover;
                -moz-background-size: cover;
                -webkit-background-size: cover;
                position: relative;
                top:0px;
                left:0px;
                overflow: hidden;
            }
            
            #content{
                background: rgba(0,0,0,0.7);
                width: 100%;
                display: block;
                overflow: auto;
                height: 100%;
                position: relative;
                top:0px;
                left:0px;
                z-index:1;
            }
            
            #reg-form{
                display: block;
                position: relative;
                color:white;                
                font-weight: bold;
            }
            @media screen and (max-width: 700px) {
                #reg-form{
                    margin: 5% 3%;
                    width:94%;    
                }
            }
            @media screen and (min-width: 701px) {
                #reg-form{
                    margin: 5% 25%;
                    width:50%;
                }
            }
            @font-face {
                font-family: stylle;
                src: url('b.ttf');
            }
        </style>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <script type="text/javascript">
            $("body").css("height",($(window).height())+"px");
        </script>
        <div id='body' class="w3-container w3-padding-0 w3-margin-0">
            
            
            <div id='content' class="w3-container w3-padding-0 w3-margin-0">
                
                <script type="text/javascript">
                    $("#content").css("height",($(window).height())+"px");
                </script>
                
                <div class="" id="reg-form">
                    <div class="wow fadeIn" data-wow-duration="1000ms" data-wow-delay="500ms">
                        <br>
                        <h1 class="w3-center w3-text-white w3-xxxlarge" style=" font-weight: bolder !important; font-family: stylle;">PAYMENT ACKNOWLEDGED</h1>
                    </div>
                    
                    <br>
                    
                    <h3>Its advisible you save this information below in case of any issues later on</h3>
                    <table class="w3-card-4 w3-round w3-padding w3-animate-opacity wow w3-table" data-wow-duration="1000ms" data-wow-delay="1200ms" style="background: rgba(0,0,0,1) !important; width: 100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td>ORDER ID</td>
                                <td><?php echo $r['order_code'];?></td>
                            </tr>
                            
                            <tr>
                                <td>PRODUCT NAME</td>
                                <td><?php echo $r['p_name'];?></td>
                            </tr>
                            
                            <tr>
                                <td>PRODUCT QUANTITY</td>
                                <td><?php echo $r['quantity'];?></td>
                            </tr>
                            
                            <tr>
                                <td>PRODUCT PRICE</td>
                                <td><?php echo "₦ ".number_format($r['price']);?> <b style="font-weight: bolder; color: grey;">PAID</b></td>
                            </tr>
                            
                            <tr>
                                <td>ORDER BY</td>
                                <td><?php echo $r['full_name'];?></td>
                            </tr>
                            
                            <tr>
                                <td>PHONE|EMAIL</td>
                                <td><?php echo $r['phone']." | ".$r['email'];?></td>
                            </tr>              
                            
                            <tr>
                                <td>DATE PAID</td>
                                <td><?php echo date("d/m/Y H:i A",strtotime($r['date_of_success']));?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="wow bounce" data-wow-duration="3000ms" data-wow-delay="300ms">
                        <button class="w3-right w3-hide-medium w3-hide-small w3-btn w3-round" style="background: rgba(100,100,255,0.5) !important; margin-left: 1px;" onclick="window.location.href = ('view-purchase.php')">CONTINUE</button>
                        <button class="w3-right w3-hide-medium w3-hide-small w3-btn w3-round" style="background: rgba(100,100,255,0.5) !important;" onclick="window.print()">SAVE</button>
                    </div>
                    <br>
                    <button class="w3-left w3-hide-large w3-btn w3-round" style="background: rgba(100,100,255,0.5) !important;" onclick="window.print()">SAVE</button>
                    <button class="w3-left w3-hide-large w3-btn w3-round" style="background: rgba(100,100,255,0.5) !important;" onclick="window.location.href = ('view-purchase.php')">SAVE</button>
                    <br>
                </div>
                
                
            </div>
            
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
