<?php
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various... check for more ">
        <link rel="canonical" href="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:title" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:image" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/media/image/icon/icon.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="350">
        <meta property="og:image:height" content="340">
        <meta property="og:image:alt" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various... check for more"> 
        <meta name="copyright" content="FQCI is protected by copyright.">
        <meta name="keywords" content="website, fqci, marketing, drugs, products, goods, health, curative, greenlife, official">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FQCI &hearts; Products</title>
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
                <div class="w3-container">
                    
                    <div class="w3-responsive w3-padding-0 w3-margin-0">
                        
                        <h1 class="w3-padding w3-margin w3-text-shadow w3-text-grey" style="font-weight: bold;">COMPREHENSIVE PRODUCTS LIST</h1>
                        
                        <table style="overflow: auto; width: 100%;" class="w3-table w3-responsive w3-bordered w3-striped w3-border w3-hoverable w3-padding-0 w3-margin-0 w3-card-4">
                            <thead>
                                <tr class="w3-green">
                                    <th>Product</th>
                                    <th>Price (N)</th>
                                    <th class="w3-center">Description</th>
                                    <th class="w3-center">-</th>
                                    <th class="w3-center">-</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = mysqli_query($con,"SELECT * FROM product ORDER BY p_id DESC");
                                    $num = mysqli_num_rows($sql);
                                    
                                    for($i=0; $i < $num ;$i++){
                                        $r = mysqli_fetch_assoc($sql);
                                        ?>
                                            <tr class="table-product_tr">
                                                <td><?php echo $r['p_name'];?></td>
                                                <td><?php echo number_format(($r['p_price']),0);?></td>
                                                <td>
                                                    <div class="text_overflow" style="text-overflow: ellipsis; height: 30px; position: relative;">
                                                        <?php echo $r['p_desc'];?>
                                                    </div>
                                                    
                                                    
                                                </td>
                                                <td><button onclick="more_info('<?php echo $r['p_id'];?>')" class="w3-btn w3-green w3-card-2">MORE INFO</button> </td>
                                                <td><button onclick="buy('<?php echo $r['p_name'];?>','<?php echo number_format(($r['p_price']),0);?>')" class="w3-btn w3-green w3-card-2">PLACE ORDER</button> </td>
                                            </tr>
                                        <?php
                                    }
                                ?>  
                            </tbody>
                        </table>
                        
                    </div>
                    
                </div>
                
            </div>
            
            <div id="more_info_modal" class="w3-modal">
                <div class="w3-modal-content w3-card-12 w3-round" style="margin-bottom: 2%;"> 
                    <div class="w3-container">
                      <span onclick="document.getElementById('more_info_modal').style.display='none'" class="w3-closebtn">&times;</span>
                      <br>
                      <br>
                      <div id='more_info_ajax_render'>
                        loading product information please wait...
                      </div>
                    </div>
                </div>
            </div>
            
            <div id="buy_modal" class="w3-modal">
                <div class="w3-modal-content w3-card-12 w3-round">
                    <div class="w3-container w3-padding w3-margin">
                      <span onclick="document.getElementById('buy_modal').style.display='none'" class="w3-closebtn">&times;</span>
                      <br>
                      <br>
                      <form onsubmit="return false">
                            <h4 style="font-weight: bold;" class="w3-center w3-xxlarge">PURCHASE</h4>
                            <p>
                                <input type="text" name="pname" class="w3-input w3-grey w3-disabled w3-disable" value="loading" disabled>
                                <label class="w3-label w3-text-green">Product Name</label>
                            </p>
                            
                            <p>
                                <input type="text" name="pprice" class="w3-input w3-grey w3-disabled w3-disable" value="loading" disabled>
                                <label class="w3-label w3-text-green">Product Price</label>
                            </p>
                            
                            <p>
                                <input type="number" name="pquantity" class="w3-input" value=1 placeholder="Please Enter the Quantity Required" required>
                                <label class="w3-label w3-validate">Product Quantity</label>
                            </p>
                            
                            <br>
                            <marquee class="w3-container w3-padding w3-leftbar w3-rightbar w3-pale-yellow">We will need some of your informations so that we can contact you..</marquee>
                            <br>
                            
                            <p>
                                <input type="text" name="uname" class="w3-input" placeholder="Please Enter Your Full Name" required>
                                <label class="w3-label w3-validate">Full Name</label>
                            </p>
                            
                            <p>
                                <input type="tel" name="uphone" class="w3-input" placeholder="Please Enter Your Phone Number, multiple are allowed like 080abc.. , 080def" required>
                                <label class="w3-label w3-validate">Phone Number</label>
                            </p>
                            
                            <p>
                                <input type="email" name="uemail" class="w3-input" placeholder="Please Enter Your Email if any, multiple are allowed like a@b.c , abc@d.com">
                                <label class="w3-label w3-validate">Email</label>
                            </p>
                            
                            <p>
                                <textarea type="email" name="uaddress" class="w3-input w3-card-8 w3-round" style="width: 100%; height: 200px; resize:none;" placeholder="Please Enter Your Contact Address in full and also specifying the state and country" required></textarea>
                                <label class="w3-label w3-validate">Contact</label>
                            </p>
                            
                            <p>
                                <div id="notification" class="w3-red w3-center w3-large"></div>
                                <br>
                                <button type="submit" onclick="purchase()" class="w3-btn w3-right w3-card-4">PLACE AN ORDER NOW</button>
                                <br>
                                <br>
                                <br>
                            </p>
                      </form>
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
