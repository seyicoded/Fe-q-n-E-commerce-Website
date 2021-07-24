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
        $title = $_POST['p_title'];
        $p_type = $_POST['p_type'];
        $desc = $_POST['desc'];
        $content = $_POST['p_content'];
        $img_name = rand(0,1000).rand(0,1000).basename($_FILES['p_image']['name']);
        $img_path = "../media/image/post/".$img_name;

        if(move_uploaded_file($_FILES['p_image']['tmp_name'],$img_path)){
            //add to db i guess
            $sql = "INSERT INTO post(p_title, p_type, p_desc, p_content, image) VALUES('$title', '$p_type', '$desc', '$content', '$img_name')";
            if( mysqli_query($con, $sql) ){
                header('Location: pay_view_post.php');
            }else{
               unlink($img_path); 
               ?>
                    <script>
                        alert('an error occurred');
                    </script>
                <?php
            }
        }else{
            ?>
                <script>
                    alert('an error occurred');
                </script>
            <?php
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
            
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="w3-content w3-card-12" enctype="multipart/form-data" style="overflow: auto;" class="" onsubmit="reprocess()">
                <h2 class="w3-center w3-card-4" style="font-weight: bold;">ADD A POST</h2>
                
                <div class="w3-margin">
                    <input type="text" class="w3-input" name="p_title" placeholder="Enter Post Title" required>
                    <label class="w3-label w3-validate">Post Title</label>
                </div>
                
                <div class="w3-margin">
                    <select name="p_type" class="w3-input">
                        <option value="normal">Normal</option>
                        <option value="sponsor">Sponsor</option>
                    </select>
                    <label class="w3-label w3-validate">Post Type</label>
                </div>
                
                <div class="w3-margin">
                    <textarea class="w3-input" name="desc" class="custom-control" placeholder="Enter Post Description" required></textarea>
                    <label class="w3-label w3-validate">Post Description</label>
                </div>
            
                <br>
                <div class="w3-margin w3-container">
                    <textarea class="w3-input w3-round" style="height:400px; display: none;" name="p_content" placeholder="Enter Product Explanation"></textarea>
                    
                    <div id="editor">
                        <h1>Post Content Goes Here</h1>    
                    </div>
                    <label class="w3-label w3-validate">Post Content</label>
                </div>
                
                <div class="w3-margin">
                    <input type="file" class="w3-input" name="p_image" required>
                    <label class="w3-label w3-validate">Post Image</label>
                </div>
                
                
                
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
