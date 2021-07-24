
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
    
    if(isset($_GET['approve'])){
        $pf_id = $p->sqlr($con,$p->xssr($_GET['pf_id']));
        $one = 1;
        if(mysqli_query($con,"UPDATE product_feedback SET status='$one' WHERE pf_id='$pf_id'")){
            ?>
                <script type="text/javascript">
                    alert('feedback approved successfully');
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript">
                    alert('error approving feedback');
                </script>
            <?php
        }
        
        ?>
        <script type="text/javascript">
            window.location.replace('comment.php');
        </script>
        <?php
        
    }
    if(isset($_GET['delete'])){
        $pf_id = $p->sqlr($con,$p->xssr($_GET['pf_id']));
        if(mysqli_query($con,"DELETE FROM product_feedback WHERE pf_id='$pf_id'")){
            ?>
                <script type="text/javascript">
                    alert('deleted successfully');
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript">
                    alert('error deleting feedback');
                </script>
            <?php
        }
        
        ?>
        <script type="text/javascript">
            window.location.replace('comment.php');
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
        </style>
    </head>
    <body>        
        <img src="../media/image/resource/a.jpg" id='bg-img'>
        
        <nav id='nav' class="wow fadeInLeft" data-wow-duration="2500ms">
            <div>
                <b class="w3-right w3-padding w3-margin" onclick="$('#nav').toggle()" id='close'>&times;</b>
            </div>
            
            <nav class="w3-sidenav w3-xlarge" id='item' style='height:500px;'>
                <a href="homepage.php">DASHBOARD</a>
                <a href="add_product.php">ADD PRODUCT</a>
                <a href="edit_product.php">EDIT PRODUCT</a>
                <a href="delete_product.php">DELETE PRODUCT</a>  
                <a href="orders.php">ORDERS</a>
                <a href="comment.php">COMMENT</a>
                <a href="../health-doctor/config/create-article.php">CREATE ARTICLE</a>
                <a href="../health-doctor/config/upload-file.php">UPLOAD FILE FOR ARTICLE</a>
                <a href="../health-doctor/config/view-file.php">VIEW UPLOADED FILE FOR ARTICLE</a>
                <a href="signout.php">SIGN OUT</a>
            </nav>
            
        </nav>
        
        <div id='content'>
            <ul id='header' class="w3-navbar w3-border w3-large">
                <li><a class="w3-green" href="#" onclick="$('#nav').toggle()"><i class="fa fa-bars w3-large"></i></a></li>
                <li class="w3-hide-medium w3-hide-small"><a style="background: rgba(0,0,0,0) !important; font-weight: bolder;">FEMQUEN ADMIN PORTAL</a></li>                  
                <li class="w3-hide-medium w3-hide-small w3-right"><a href="signout.php"><i class="fa fa-sign-in w3-large"></i></a></li>
            </ul>
            
            <h1 class="w3-center" style="font-weight: bold;">ORDER DATA</h1>
            
            <div class="w3-responsive">
                    <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
                        <thead style="font-weight: bold;">
                            <tr class="w3-light-green">
                                <th>PRODUCT NAME</th>
                                <th>CLIENT NAME</th>
                                <th>EMAIL</th>
                                <th>FEEDBACK</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>--</th>
                                <th>---</th>      
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = mysqli_query($con,"SELECT * FROM product_feedback ORDER BY status ASC, pf_id DESC");
                                $num = mysqli_num_rows($sql);
                                echo 'Showing '.$num." comments";                                           
                                //echo "  ".$email."  ";
                                
                                if($num <= 0){
                                    ?>
                                        <tr>
                                            <td colspan="9" class="w3-center">no comment yet</td>
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
                                        
                                        ?>
                                            <tr>
                                                <td><?php
                                                    $s_pn = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM product WHERE p_id='".$r['pf_p_id']."'"));
                                                    echo $s_pn['p_name'];
                                                ?></td>
                                                <td><?php echo $r['name'];?></td>
                                                <td><?php echo $r['email'];?></td>
                                                <td><?php echo ($r['feedback']);?></td>
                                                <td><?php echo ( intval($r['status']) == 0 ) ? "PENDING":"APPROVED" ;?></td>
                                                <td><?php echo date("d/m/y @ H:i A",strtotime($r['date']));?></td>
                                                <?php
                                                    if(intval($r['status']) == 0){
                                                        ?>
                                                            <td><button class="btn btn-success w3-round w3-green" onclick="window.location.replace('<?php echo "comment.php?approve=true&pf_id=".$r['pf_id'];?>')" >APPROVE</button></td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <td><button class="btn btn-success w3-round w3-green" disabled="disabled" style="opacity:50%;">APPROVE</button></td>
                                                        <?php
                                                    }
                                                ?>
                                                <td><button class="btn btn-danger w3-round w3-red" onclick="delet()">DELETE</button></td>
                                                <script type="text/javascript">
                                                    function delet(){
                                                        if(confirm('are you sure you wanna delete dis product')){
                                                            window.location.replace('<?php echo "comment.php?delete=true&pf_id=".$r['pf_id'];?>')
                                                        }
                                                        //
                                                    }
                                                </script>
                                                
                                            </tr>
                                        <?php
                                        
                                        //stop
                                    }
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
        </script>
    </body>
</html>
