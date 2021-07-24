<?php
    session_start();
    include("../include/connectdb.php");
    $p = new db();
    $con = $p->con();
    
    if(isset($_POST['load_full_info'])){
        $pid = $p->sqlr($con,$p->xssr($_POST['pid']));
        $r = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM product WHERE p_id='$pid'"));
        ?>
            <div class="w3-container">
                <img src="media/image/product/<?php echo $r['p_image'];?>" style="width: 70%; position: relative; left:15%; height: 300px;" class="w3-card-4 w3-round">
                <h4 class="w3-center" style="font-weight: bolder"><?php echo $r['p_name'];?></h4>
                
                <div class="w3-card-8 w3-padding" style="text-align:justify; font-weight: 600; color:rgba(0,0,0,0.6);">
                    <?php echo $r['p_desc']?>
                    
                    <br>
                    <div class="w3-right">
                        <?php echo "N ".number_format(($r['p_price']),0).".00"?>
                    </div>
                    <br>
                    
                </div>    
                
                <br>
                <br>
                
                <div class="w3-card-8 w3-padding" style="text-align:justify; font-weight: 600; color:rgba(0,0,0,0.6);">
                    incase you need this product now..... or need more information about it just us via, sms or call us or if preferable, Message us
                </div>
                
            </div>
            <br>
        <?php
    }
?>