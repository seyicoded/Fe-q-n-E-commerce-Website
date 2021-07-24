<?php
    //include config for health doctor
    include('include.php');
    
    //inlcude config for db
    include('../../include/connectdb.php');
    $p = new db();
    $con = $p -> con();
    
    include("../../adn/config.php");
    if(isset($_COOKIE[md5("admin_signed_in")])){
        $authena = base64_decode($_COOKIE[md5("admin_authen")]);
    }else{
        ?>
            <script type="text/javascript">
                window.location.replace("index.php");
            </script>
        <?php
    }
    
    $key = "";
    
    if(isset($_POST['submit'])){
        
        //$key = $p -> sqlr($con,$p->xssr($_POST['key']));
        
        if($authen == $authena){
            $new_dir = "../files/".rand(0,100).basename($_FILES['file']['name']);
            
            if(move_uploaded_file($_FILES['file']['tmp_name'],$new_dir)){
                echo "FILE UPLOADED SUCCESSFULLY <br> file url name: '";
                echo $url_for_hd."/files/".$new_dir."'";
            }else{
                echo "ERROR UPLOADING FILE TO SERVER, TRY AGAIN LATER";
            }
            
        }else{
            echo "invalid key entered";
        }
        
        
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FEMQUEN And Co. Int'l</title>
        <link rel="stylesheet" href="../../template/lib/w3.css">         
        <link rel="stylesheet" href="../../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../../media/image/icon/icon.png" type="image/x-icon">
        <script type="text/javascript" src="../../template/js/jquerym.js"></script>
    </head>
    <body class="w3-display-container w3-padding-0 w3-margin-0" style="width: 100%; height: 100%; position: fixed; background: #ACACAC;">
        
        <div class="w3-left" style="cursor: pointer;"> <a href="../../adn/homepage.php"><i class="fa fa-chevron-left"></i>BACK</a></div>
        
        <div class=" w3-card-12 w3-center w3-grey" style="position:absolute; top:30%; overflow: auto; margin-left:20%; width:60%; margin-right:20%;">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <div>
                    <h3>UPLOAD A FILE RESOURCE TO SITE</h3>
                </div>
                
                <div>
                    <input class="w3-input" type="file" name="file" required>
                </div>
                
                <div>
                    <input class="w3-input w3-light-grey" type="hidden" name="key" value="<?php echo $key;?>" placeholder="Enter Modification key">
                </div>
                
                <div>
                    <input class="w3-btn-block" type="submit" name="submit" value="Upload">
                </div>
            </form>
        </div>
    </body>
</html>
