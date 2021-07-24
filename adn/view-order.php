
<?php
    session_start();
    include("../include/connectdb.php");
    include("config.php");
    $p = new db();
    $con = $p->con(); 
    
    
    if(isset($_COOKIE[md5("admin_signed_in")])){
        $authena = base64_decode($_COOKIE[md5("admin_authen")]);
    }else{
        ?>
            <script type="text/javascript">
                window.location.replace("index.php");
            </script>
        <?php
    }
    
    if( (isset($_GET['nsonline'])) && (isset($_GET['o_id']) || isset($_GET['o_code'])) ){
        $oid = $p->sqlr($con,$p->xssr($_GET['o_id']));
        $ocode = $p->sqlr($con,$p->xssr($_GET['o_code']));
        $ns = $p->sqlr($con,$p->xssr($_GET['nsonline']));
        
        if(intval($ns) == 0){
            $sql = "UPDATE ordered SET status='$ns' WHERE o_id='$oid' OR order_code='$ocode';";
            $sql .= "UPDATE transaction SET status='$ns' WHERE o_id='$oid';";
             
        }else{
            $one = 1;
            $sql = "UPDATE ordered SET status='$ns' WHERE o_id='$oid' OR order_code='$ocode';";
            $sql .= "UPDATE transaction SET status='$one' WHERE o_id='$oid';";
            
        }
        
        if(mysqli_multi_query($con,$sql)){
            header("Location:view-order.php?o_code=$ocode&o_id=$oid");
        }else{
                
        }
        
    }
    
    if( (isset($_GET['nsbt'])) && (isset($_GET['o_id']) || isset($_GET['o_code'])) ){
        $oid = $p->sqlr($con,$p->xssr($_GET['o_id']));
        $ocode = $p->sqlr($con,$p->xssr($_GET['o_code']));
        $ns = $p->sqlr($con,$p->xssr($_GET['nsbt']));
        
        if(mysqli_query($con,"UPDATE ordered SET status='$ns' WHERE o_id='$oid' OR order_code='$ocode'")){
            header("Location:view-order.php?o_code=$ocode&o_id=$oid");
        }else{
            
        }
    }
    
    if(isset($_GET['o_id']) || isset($_GET['o_code'])){
        $oid = $p->sqlr($con,$p->xssr($_GET['o_id']));
        $ocode = $p->sqlr($con,$p->xssr($_GET['o_code']));
        
        $r = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM ordered WHERE o_id='$oid' OR order_code='$ocode'"));
    }else{
        ?>
            <script type="text/javascript">
                window.location.replace("orders.php");
            </script>
        <?php
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
        <link rel="stylesheet" href="index.css">         
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/animate.min.css"> 
        <script type="text/javascript" src="../template/js/jquerym.js"></script>       
        <style type="text/css">
            #cont{
                width:70%;
                margin: 1% 15%;
            }
            
            @media only screen and (max-width: 500px){
                #cont{
                    width:98%;
                    margin: 1%;
                }    
            }
        </style>
    </head>
    <body>        
        <img src="../media/image/resource/a.jpg" id='bg-img'>
        
        <div id='content'>
            <ul id='header' class="w3-navbar w3-border w3-large">
                <li><a class="" href="orders.php"><i class="fa fa-chevron-left w3-large"></i></a></li>
                <li class="w3-hide-medium w3-hide-small"><a style="background: rgba(0,0,0,0) !important; font-weight: bolder;">FEMQUEN ADMIN PORTAL</a></li>                  
                <li class="w3-hide-medium w3-hide-small w3-right"><a href="signout.php"><i class="fa fa-sign-in w3-large"></i></a></li>
            </ul>
            
            <h2 class="w3-center" style="font-weight: bolder;"><?php echo $r['order_code'];?></h2>
            
            <div id='cont' class="w3-responsive">
                <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable w3-text-shadow w3-card-2 w3-round">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $r['email'];?></td>
                        </tr>
                        
                        <tr>
                            <td>Full Name</td>
                            <td><?php echo $r['full_name'];?></td>
                        </tr>
                        
                        <tr>
                            <td>Phone</td>
                            <td><?php echo $r['phone'];?></td>
                        </tr>
                        
                        <tr>
                            <td>Address</td>
                            <td><?php echo $r['address'];?></td>
                        </tr>
                        
                        <tr>
                            <td>Product Name</td>
                            <td><?php echo $r['p_name'];?></td>
                        </tr>
                        
                        <tr>
                            <td>Quantity</td>
                            <td><?php echo $r['quantity'];?> pcs</td>
                        </tr>
                        
                        <tr>
                            <td>Total Price</td>
                            <td><?php echo "₦ ".number_format($r['price']).".00";?></td>
                        </tr>
                        
                        <tr>
                            <td>Date</td>
                            <td><?php echo date("d/m/Y @ H:i A",strtotime($r['date']));?></td>
                        </tr>
                        
                        <tr>
                            <td class="w3-center w3-xlarge" colspan="2" style="font-weight: bold;">PAYMENT INFO</td>                        
                        </tr>
                        
                        <?php
                            if(intval($r['mode']) == 0){
                                ?>
                                    <tr>
                                        <td>Payment Mode</td>
                                        <td>BANK TRANSFER</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Payment State</td>
                                        <td><?php echo ( ( $r['status'] == 0 ) ? "UNPAID" : (( ($r['status'] == 1) ) ? "PROCESSSING" : "DELIVERED" ));?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Change Payment State</td>
                                        <td>
                                            <select class="custom-select" onchange="change_for_bt(this.value,'<?php echo $ocode;?>','<?php echo $oid;?>')">
                                                <option value="null">SELECT NEW STATE</option>
                                                <option value="0">UNPAID</option>
                                                <option value="1">PROCESSING</option>
                                                <option value="2">DELIVERED</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php
                            }else{
                                $r1 = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM transaction WHERE o_id='".$r['o_id']."'"));
                                $t_st = intval($r1['status']);
                                ?>
                                    <tr>
                                        <td>Payment Mode</td>
                                        <td>ONLINE</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Payment State</td>
                                        <td><?php 
                                            echo ( ( $r1['status'] == 0 ) ? "UNPAID|(REQUERY)" : (( ($r['status'] == 1) ) ? "PAID PROCESSSING" : "DELIVERED" ) );
                                            $btn = ' <button class="w3-btn w3-green w3-round" style="" onclick=\'window.location.replace("../success.php?trxref='.$r1['reference'].'&reference='.$r1['reference'].'")\'>RE-CHECK FROM PAYMENT SERVER</button> ';
                                            echo "&nbsp;". ( (($t_st) == 0) ? $btn:"" ) ;
                                            
                                        ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Change Payment State (Manually)</td>
                                        <td>
                                            <select class="custom-select" onchange="change_for_online(this.value,'<?php echo $ocode;?>','<?php echo $oid;?>')">
                                                <option value="null">SELECT NEW STATE</option>
                                                <option value="0">UNPAID</option>
                                                <option value="1">PAID PROCESSING</option>
                                                <option value="2">DELIVERED</option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                <?php
                            }
                        ?>
                        
                    </tbody>
                </table>
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
            
            function change_for_bt(state,ocode,oid){
                if(state == "null"){
                    return false;
                }                      
                //alert(state+"--"+ocode+"--"+oid);
                url = "nsbt="+state+"&o_code="+ocode+"&o_id="+oid;
                window.location.replace("view-order.php?"+url);
            }
            //change_for_online
            function change_for_online(state,ocode,oid){
                if(state == "null"){
                    return false;
                }                      
                //alert(state+"--"+ocode+"--"+oid);
                url = "nsonline="+state+"&o_code="+ocode+"&o_id="+oid;
                //alert("view-order.php?"+url);
                window.location.replace("view-order.php?"+url);
            }
        </script>
    </body>
</html>
