<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");

    $user_id =  $puid;
    $msg = '';

    if(isset($_POST['submit'])){
        $title = $_POST['p_title'];
        $p_type = 'normal';
        $desc = $_POST['desc'];
        $content = $_POST['p_content'];
        $img_name = rand(0,1000).rand(0,1000).basename($_FILES['p_image']['name']);
        $img_path = "../media/image/post/".$img_name;

        if(move_uploaded_file($_FILES['p_image']['tmp_name'],$img_path)){
            //add to db i guess
            $sql = "INSERT INTO post(user_id, p_title, p_type, p_desc, p_content, image, status, rewarded) VALUES($user_id, '$title', '$p_type', '$desc', '$content', '$img_name', 0, 0)";
            if( mysqli_query($con, $sql) ){
                ?>
                    <script>
                        alert('post submitted');
                    </script>
                <?php
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
    <link rel="stylesheet" href="../template/ckec/samples/css/samples.css">
    <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">

    <script type="text/javascript" src="src/js/index.js"></script>
    <script type="text/javascript" src="../template/ckec/ckeditor.js"></script>
    <script type="text/javascript" src="../template/ckec/samples/js/sample.js"></script>
</head>
<body>
    <?php
        include("include/signedHeader.php");
    ?>

    <div class="w3-content">
        <form method="POST" enctype="multipart/form-data" class="w3-container w3-card-4 w3-round w3-padding-4 w3-margin-8" style="margin-top: 3% !important">
            <h4 class="w3-center w3-text-grey">fill info below to submit a post request</h4>

            <div class="w3-margin">
                    <input type="text" class="w3-input" name="p_title" placeholder="Enter Post Title" required>
                    <label class="w3-label w3-validate">Post Title</label>
                </div>
                
                <div class="w3-margin">
                    <select name="p_type" class="w3-input">
                        <option value="normal">Normal</option>
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
    </div>

    <script>
                initSample();
                
                function reprocess(){
                    $("textarea[name='p_content']").html( CKEDITOR.instances['editor'].getData() );
                    return true;
                }
            </script>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>