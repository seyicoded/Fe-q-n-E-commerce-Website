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
    
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FEMQUEN And Co. Int'l</title>
        <link rel="stylesheet" href="../template/lib/w3.css">         
        <link rel="stylesheet" href="../template/ckec/samples/css/samples.css">
        
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/index.css">
        <script type="text/javascript" src="../template/js/jquerym.js"></script>
        <script type="text/javascript" src="../template/js/index.js"></script>
        
        <script type="text/javascript" src="../template/ckec/ckeditor.js"></script>
        <script type="text/javascript" src="../template/ckec/samples/js/sample.js"></script>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id='body' class="w3-container w3-padding-0 w3-margin-0">
        
        <div class="w3-left" style="cursor: pointer;"> <a href="homepage.php"><i class="fa fa-chevron-left"></i>BACK</a></div>
            
        <div>
            <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>NAME</th>
                        <th>PRICE</th>
                        <th>DESCRIPTION</th>
                        <th>DATE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $dt = mysqli_query($con,"SELECT * FROM pay_package ORDER BY p_id DESC");
                    while($r = mysqli_fetch_assoc($dt)){
                        ?>
                            <tr>  
                                <td><?php echo $r['p_id']?></td>
                                <td><?php echo $r['p_name']?></td>
                                <td><?php echo $r['p_price']?></td>
                                <td><?php echo $r['p_desc']?></td>
                                <td><?php echo date("Y-m-d @ H:i a",strtotime($r['date']))?></td>
                                <td><a href="pay_modify_package_2.php?pid=<?php echo $r['p_id'];?>" class="w3-btn w3-green w3-text-white w3-round">EDIT</a></td>
                            </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>    
                        
        </div>
    </body>
</html>
