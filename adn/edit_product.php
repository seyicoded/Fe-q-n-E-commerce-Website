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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FEMQUEN And Co. Int'l</title>
        <link rel="stylesheet" href="../template/lib/w3.css">         
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/index.css">
        <script type="text/javascript" src="../template/js/jquerym.js"></script>
        <script type="text/javascript" src="../template/js/index.js"></script>
    </head>
    <body>
        <div class="w3-left" style="cursor: pointer;"> <a href="homepage.php"><i class="fa fa-chevron-left"></i>BACK</a></div> <br>
        <h4>SELECT PRODUCT TO EDIT by clicking on it</h4>
        <ol>
            <?php
                $sql = mysqli_query($con,"SELECT * FROM product ORDER BY p_name ASC");
                $num = mysqli_num_rows($sql);
                for($i=0;$i < $num;$i++){
                    $r = mysqli_fetch_assoc($sql);
                    echo "<li> <a target='_blank' href='edit_product_2.php?id=".$r['p_id']."'>".$r['p_name']."</a> </li>";
                }
            ?>
        </ol>
    </body>
</html>
