<?php 
    $msg = "...";
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

    if(isset($_GET['pid'])){
        $pid = $p->sqlr($con, $p->xssr($_GET['pid']));

        if(mysqli_query($con, "DELETE FROM post WHERE p_id ='$pid'")){
            echo 'successfully';
            return true;
        }else{
            echo "error: ".mysqli_error($con);
            return false;
        }
    }
    
?>