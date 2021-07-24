<?php
    session_start();
    include("../include/connectdb.php");
    $p = new db();
    $con = $p->con(); 
    
    include("config.php");
    if(isset($_COOKIE[md5("admin_signed_in")])){
        $authena = base64_decode($_COOKIE[md5("admin_authen")]);
    }else{
        ?>
            <script type="text/javascript">
                window.location.replace("index.php");
            </script>
        <?php
    }
    
    if(isset($_GET['id'])){
        $pid = $p->sqlr($con,$p->xssr($_GET['id']));
        
        //get data                                  
        $r = mysqli_fetch_assoc($sql = mysqli_query($con,"SELECT * FROM product WHERE p_id='$pid'"));
        $old_image_path_server = "../media/image/product/".$r['p_image'];
        
        if(mysqli_query($con,"DELETE FROM product WHERE p_id='$pid'")){
            unlink($old_image_path_server);
        }else{
            
        }
        
        
    }else{
        
    }
    
    header('Location:delete_product.php');
?>