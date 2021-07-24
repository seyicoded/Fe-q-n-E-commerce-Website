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
    
    if(isset($_POST['submit'])){
        $pname = $p->sqlr($con,$p->xssr($_POST['p_name']));
        $pprice = $p->sqlr($con,$p->xssr($_POST['p_price']));
        $desc = $p->sqlr($con,($_POST['desc']));
        //$authen = $p->sqlr($con,$p->xssr($_POST['authen']));
        
        //print_r($_POST);
        //exit();
        
        if($authen != $authena){
            $msg = "modification key is invalid".$authen.$authena;
        }else{
            $sql = "INSERT INTO pay_package(p_name,p_price,p_desc) VALUES('$pname','$pprice','$desc')";
            if(mysqli_query($con,$sql)){
                $msg = "Created Successfully...";
            }else{
                $msg = "Error Creating...";
            }
        }
    }else{
        $authen = '';
    }
    
    //var a_content = CKEDITOR.instances['editor'].getData();
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
            
            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" class="w3-content w3-card-12">
                <h2 class="w3-center w3-card-4" style="font-weight: bold;">ADD A PACKAGE</h2>
                
                <div class="w3-margin">
                    <input type="text" class="w3-input" name="p_name" placeholder="Enter Package Name" required>
                    <label class="w3-label w3-validate">Package Name</label>
                </div>
                
                <div class="w3-margin">
                    <input type="text" class="w3-input" name="p_price" placeholder="Enter Package Price" required>
                    <label class="w3-label w3-validate">Package Price</label>
                </div>
                
                <div class="w3-margin">
                    <textarea class="w3-input" name="desc" class="custom-control" placeholder="Enter Package Description" required></textarea>
                    <label class="w3-label w3-validate">Package Description</label>
                </div>
            
                <br>
                <!-- <div class="w3-margin w3-container">
                    <textarea class="w3-input w3-round" style="height:400px; display: none;" name="p_content" placeholder="Enter Product Explanation"></textarea>
                    
                    <div id="editor">
                        <h1>Product Expl. Content Goes Here</h1>    
                    </div>
                    <label class="w3-label w3-validate">Product Explanation/Content</label>
                </div> -->
<!--                 
                <div class="w3-margin">
                    <input type="file" class="w3-input" name="p_image" required>
                    <label class="w3-label w3-validate">Product Image</label>
                </div> -->
                
                
                
                <div class="w3-margin"><?php echo $msg;?></div>
                
                <div class="w3-margin">
                    <input class="w3-btn-block" type="submit" name="submit" value="SUBMIT">
                </div>
                
                <br>
            </form>
            
            <script>
                initSample();
                
                function reprocess(){
                    $("textarea[name='p_content']").html( CKEDITOR.instances['editor'].getData() );
                    return true;
                }
            </script>
                        
        </div>
    </body>
</html>
