<?php
    //make it responsive
    /*
    * check payment state
    * create new payment
    */               
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    
    $full_name = $email = $phone = $address = '';
    if(isset($_COOKIE[md5('signed_data')])){
        $full_name = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('full_name')])));
        $email = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('email')])));
        $phone = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('phone')])));
        $address = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('address')])));
    }else{
        header('Location:signin.php');
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
            @media print{
                #headera,#footera{
                    display: none;
                }
                
                #content {
                    display: block !important;
                }   
            }
        </style>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id='body' class="w3-container w3-padding-0 w3-margin-0">
            
            <div id='headera'>
            <?php
                //import header
                include("include/header.php");
            ?>
            </div>
            
            <div id='content' class="w3-container w3-padding-0 w3-margin-0">
                
                <style type="text/css">
                    button{
                        font-weight: 900;
                    }
                </style>
                
                <?php /* site content goes here */?>
                
                <div class="w3-margin alert alert-info">
                    <h2 style="font-weight: bold;">GUIDELINES OF USE</h2>
                    <ul>
                        <li>
                            If you made a payment on our site and you have been debited and it's showing error, 
                            assuming you have already recieve alert then wait for 5 minute, as you can remember 
                            we asked you to save your order code, if you don't know it just scroll down to 
                            the product to have ordered and on it's row click on 'RE-CHECK' button below and hopefully it's 
                            resolve your issue else contact us via our contact us page indicating your order code.
                        </li>
                        
                        <li style="margin-top: 15px;">
                            If you tried making a payment by it was declined, or due to bank issue at that moment it
                            was declined and you haven't been charged|debited yet, we advise still clicking on 'RE-CHECK'
                            on that product row below first and if error presist then you'll have to make a new payment order
                            by clicking on 'NEW' button below and hopefully after making the new payment, you order state would 
                            be updated else contact us via our contact us page indicating your order code.
                        </li>
                    </ul>
                </div>
                
                <br>
                <div class="w3-right"><button class="w3-btn w3-blue w3-round w3-margin" onclick="window.print()">PRINT</button></div>
                <br>
                <br>
                <br>
        
                <div class="w3-responsive" style="width: 100%;">
                    <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable" style="width: 100%;">
                        <thead style="font-weight: bold;">
                            <tr class="w3-light-green">
                                <th>O/CODE</th>
                                <th>P/Name</th>
                                <th>P/Qty</th>
                                <th>T/PRICE</th>
                                <th>PAYMENT MODE</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>---</th>
                                <th>---</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = mysqli_query($con,"SELECT * FROM ordered WHERE email LIKE '%$email%' ORDER BY mode DESC, o_id DESC");
                                $num = mysqli_num_rows($sql);
                                echo 'Showing '.$num." orders";                                           
                                //echo "  ".$email."  ";
                                
                                if($num <= 0){
                                    ?>
                                        <tr>
                                            <td colspan="9" class="w3-center">no order yet</td>
                                        </tr>
                                    <?php
                                }else{
                                    for($i = 0 ; $i < $num ; $i++){
                                        //start
                                        
                                        $r = mysqli_fetch_assoc($sql);
                                        //echo intval($r['mode']);
                                        //controller for mode
                                        /* from ordered table in db
                                            db_mode
                                                  0 = bank;
                                                  1 = online;
                                                  
                                            status     for mode 0
                                                    0 = unpaid
                                                    1 = paid processing
                                                    2 = delivered
                                                    
                                            status     for mode 1
                                                    0 = unpaid or requery
                                                    1 = paid processing
                                                    2 = delivered
                                        */
                                        
                                        if( intval($r['mode']) == 0 ){
                                            ?>
                                                <tr>
                                                    <td><?php echo $r['order_code'];?></td>
                                                    <td><?php echo $r['p_name'];?></td>
                                                    <td><?php echo $r['quantity'];?></td>
                                                    <td><?php echo "₦".number_format($r['price']);?></td>
                                                    <td><?php echo "BANK TRANSFER";?></td>
                                                    <td><?php echo ( ( $r['status'] == 0 ) ? "UNPAID" : (( ($r['status'] == 1) ) ? "PROCESSSING" : "DELIVERED" ));?></td>
                                                    <td><?php echo date("d/m/Y@H:i a", strtotime($r['date']));?></td>
                                                    <td> <button class="w3-btn w3-blue w3-round" style="width: 100%; height: 100%;" disabled="disabled">...</button> </td>
                                                    <td> <button class="w3-btn w3-green w3-round" style="width: 100%; height: 100%;" disabled="disabled">...</button> </td>
                                                </tr>
                                            <?php    
                                        }else{
                                            $r1 = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM transaction WHERE o_id='".$r['o_id']."'"));
                                            $t_st = intval($r1['status']);
                                            ?>
                                                <tr>
                                                    <td><?php echo $r['order_code'];?></td>
                                                    <td><?php echo $r['p_name'];?></td>
                                                    <td><?php echo $r['quantity'];?></td>
                                                    <td><?php echo "₦".number_format($r['price']);?></td>
                                                    <td><?php echo "ONLINE";?></td>
                                                    <td><?php echo ( ( $r1['status'] == 0 ) ? "UNPAID|(REQUERY)" : (( ($r['status'] == 1) ) ? "PAID PROCESSSING" : "DELIVERED" ));?></td>
                                                    <td><?php echo date("d/m/Y@H:i a", strtotime($r['date']));?></td>
                                                    <?php
                                                        if($t_st == 0){
                                                            //new payment window.location.replace('paynow.php?o_id='+inp.o_id+'&o_code='+inp.o_code)
                                                            
                                                            ?>
                                                                <td> <button class="w3-btn w3-blue w3-round" style="width: 100%; height: 100%;" onclick="window.location.replace('paynow.php?o_id=<?php echo $r['o_id'];?>&o_code=<?php echo $r['order_code'];?>')">NEW</button> </td>
                                                                <td> <button class="w3-btn w3-green w3-round" style="width: 100%; height: 100%;" onclick="window.location.replace('success.php?trxref=<?php echo $r1['reference'];?>&reference=<?php echo $r1['reference'];?>')">RE-CHECK</button> </td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <td> <button class="w3-btn w3-blue w3-round" style="width: 100%; height: 100%;" disabled="disabled">...</button> </td>
                                                                <td> <button class="w3-btn w3-green w3-round" style="width: 100%; height: 100%;" disabled="disabled">...</button> </td>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </tr>
                                            <?php
                                        }
                                        
                                        
                                        //stop
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            
            <div id='footera'>
            <?php
                //import footer
                include("include/footer.php");
            ?>
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
