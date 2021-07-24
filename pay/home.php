<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");

    $count_start_id = 1;
    $count_end = 10;
    if(!isset($_GET['end_row'])){
        $count_start_id = intval(mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM post WHERE status = 1 ORDER BY p_id DESC"))['p_id']);
    }else{
        $count_start_id = intval($p->sqlr($con, $p->xssr($_GET['end_row'])));
    }

    function print_product($con){
        $wh = '';
                                $q1 = "SELECT * FROM product";
                                $sql = mysqli_query($con,$q1);
                                $num = mysqli_num_rows($sql);
                                
                                $show_only = rand(1, $num);

                                for($i = 1 ; $i <= $num ; $i++){
                                    $r = mysqli_fetch_assoc($sql);
                                    if($i != $show_only){
                                        continue;
                                    }
                                            
                                    $p = ($i >= 5) ? "1": $i;
                                    $ii = ((intval($p) * 2) + 5) . "00";
                                    
                                    ?>
                                        <div class="w3-content wow fadeInDown" data-wow-duration="1200ms" data-wow-delay="<?php echo $ii;?>ms">
                                            <div class="w3-card-4 w3-round" style="margin: 6%;">
                                                <div id='image-box'>
                                                    <div id="loader-<?php echo $i;?>" style="height: 160px; width: 100%; position: relative;">
                                                        <img src="../media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">
                                                    </div>
                                                    <img id="image-<?php echo $i;?>" onload="show_image('<?php echo $i;?>')" src="../media/image/product/<?php echo $r['p_image'];?>" alt="<?php echo $r['p_name'];?>" class="w3-round" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                                
                                                <div id="content-box">
                                                    <h4 class="w3-center" style="padding:1% 0px; font-weight: 900"><?php echo $r['p_name'];?></h4>
                                                    
                                                    <div class="w3-card-4 w3-margin w3-padding content-box-inner"><?php echo substr($r['p_desc'],0,270)."........";?></div>
                                                    <div style="width: 100%; padding: 1%;">
                                                        <!--position:absolute; right: 10% !important;-->
                                                        <!-- <a href="product.php?mode=info&pid=<?php echo $r['p_id'];?>&p_name=<?php echo $r['p_name'];?>"><button class="w3-card-4 w3-center w3-btn w3-blue w3-round" style=" font-weight: bold; display: inline-block; width: 48%; ">DISCOVER</button></a> -->
                                                        <a href="../product.php?mode=get&pid=<?php echo $r['p_id'];?>&p_name=<?php echo $r['p_name'];?>"><button class="w3-card-4 w3-center w3-btn w3-btn-block w3-green w3-round" style=" font-weight: bold; display: inline-block; width: 100%;">BUY NOW</button></a>
                                                    </div>
                                                                                                                            
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    
                                    $last_id_loaded = $r['p_id'];
                                }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay DashBoard</title>
    
    <?php
        include('include/head.php');
    ?>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <script type="text/javascript" src="src/js/index.js"></script>

    <style type="text/css">
                        .content-box-inner{
                            font-family: sans-serif;
                            font-size: 15px;
                            height: 70px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            -o-text-overflow: ellipsis;
                            -ms-text-overflow: ellipsis;
                            -moz-text-overflow: ellipsis;
                            -webkit-text-overflow: ellipsis;
                        }
                        .content-box-inner:hover{
                            
                            
                        }
                        .anim{
                            animation: bounce 2s linear 2s infinite alternate ;
                        }
                        
                        #image-box{
                            position: relative;
                            overflow: hidden;
                        }
                        
                        #image-box img{
                            -webkit-transition: all 0.4s linear;
                            -o-transition: all 0.4s linear;
                            transition: all 0.4s linear;
                        }
                        #image-box img:hover{
                              -webkit-transform: scale(1.15);
                              -ms-transform: scale(1.15);
                              transform: scale(1.15);
                        }
                    </style>

                    <script type="text/javascript">
                        function show_image(image_id){
                                $("#loader-"+image_id).hide();
                                $("#image-"+image_id).show();
                            }
                    </script>

</head>
<body>

    <?php
        include("include/signedHeader.php");
    ?>

    <marquee>you can also made your articles to ours, once threhold your articles could be sponsor post for that day, also we reward constitent posting</marquee>

    <div style="display: flex; justify-content: flex-end;">
        <a href="create-article.php" style="text-decoration: none;" class="w3-small w3-text-light-green">click to create post and earn</a>
    </div>
    <div class="w3-content">
        <?php
            $sql = mysqli_query($con,"SELECT * FROM post WHERE status= 1 AND p_id <= $count_start_id ORDER BY p_id DESC LIMIT 10");
            $number = mysqli_num_rows($sql);
            $last_page = 0;
            for($i = 0; $i < $number; $i++){
                $r = mysqli_fetch_assoc($sql);
                $last_page = $r['p_id'];
                if(($i % 3) == 0){
                    // show ads
                    // for now products
                    print_product($con);
                }
                
                ?>
                    <div class="w3-content wow fadeInDown" data-wow-duration="1200ms" data-wow-delay="<?php echo $ii;?>ms">
                        <div class="w3-card-4 w3-round" style="margin: 2%; padding: 1%">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="content.php?i=<?php echo $r['p_title'];?>&d=<?php echo $r['p_id'];?>" style="text-decoration: none;"><h4 class="w3-text-grey"><?php echo $r['p_title'];?></h4></a>
                                <span 
                                class="<?php
                                    echo ($r['p_type'] == 'sponsor') ? "w3-card-2 w3-round": "";
                                ?>"
                                style="<?php
                                    echo ($r['p_type'] == 'sponsor') ? "padding: 1%; border-radius: 30px !important; elevation: 5; font-weight: bold; cursor: none": "";
                                ?>"
                                ><?php echo $r['p_type'];?></span>
                            </div>

                            <div>
                                <p style="font-size: 9px">
                                    <?php echo $r['p_desc'];?>, <a href="content.php?i=<?php echo $r['p_title'];?>&d=<?php echo $r['p_id'];?>" style="text-decoration: none; color: cadetblue !important;"> click to read more fully...</a>
                                </p>
                            </div>

                            <div style="display: flex; justify-content: flex-end; align-items: center;">
                                <span class="w3-small w3-text-grey" style="font-style: italic; font-size: 9;"><?php echo date("Y-m-d @ H:i a",strtotime($r['date']));?></span>
                            </div>

                        </div>
                    </div>
                <?php
            }

        ?>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a class="w3-text-grey w3-small" onclick="window.history.back()" style="text-decoration: none; cursor: pointer;"><< previous</a>
            <a class="w3-text-grey w3-small" style="text-decoration: none; cursor: pointer;" href="?end_row=<?php echo $last_page;?>">next >></a>
        </div>
    </div>    

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>
