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
    
    $key = $title = $desc = $content = "";
    
    if(isset($_POST['submit'])){
        //$key = $_POST['key'];
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $content = $_POST['content'];
                
        
        if($authena == $authen){
            
            //logic, upload d image an keep it url:: create the file :: update d url_of_page,url_of_image,page_name to server
            
            //uploading the image to site
            $img_name = rand(0,1000).basename($_FILES['file']['name']);
            $img_path = "../image/".$img_name;
            if(getimagesize($_FILES['file']['tmp_name'])){
                
                if(move_uploaded_file($_FILES['file']['tmp_name'],$img_path)){
                    $full_image_url = "http://".$url_for_hd."image/".$img_name;
                    
                    //creating the file
                    
                    $site_content = '
                    
                            
                            <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />           
        <meta property="og:title" content="FQCI: '.$title.' " />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="'.$desc.'" />
        <meta property="og:image" content="'.$full_image_url.'" />
        <meta name="description" content="FQCI: '.$desc.'">
        <meta name="keywords" content="FQCI,Health,Doctor,'.$title.','.$desc.'">
        <meta name="creation-date" content="2019">
        <meta name="revisit-after" content="15 days">
        <title>FQCI: '.$title.'</title>
        <link rel="stylesheet" href="../template/lib/w3.css">         
        <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="../media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../template/css/index.css">
        <script type="text/javascript" src="../template/js/jquerym.js"></script>
        <script type="text/javascript" src="../template/js/index.js"></script>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id="body" class="w3-container w3-padding-0 w3-margin-0">
            
            <?php
                //import header
                include("config/new-header.php");
            ?>
            
            <div id="content" class="w3-container w3-padding-0 w3-margin-0">
                
                <?php /* site content goes here */?>
                
                <div class="w3-container w3-margin">
                    
                    <div>
                        <h1 class="w3-center w3-text-shadow" title="'.$title.'" style="text-transform:uppercase;">'.$title.'</h1>
                    </div>
                    
                    <div>
                        <img class="w3-responsive" src="'.$full_image_url.'" style="width: 100%; height: 600px;" alt="'.$title.'">
                    </div>
                    
                    <div class="w3-margin">
                        '.$content.'
                    </div>
                    
                </div>
                
            </div>
            
            <?php
                //import footer
                include("../include/footer.php");
            ?>
            
        </div>
    </body>
</html>

                    
                    
                    ';
                    
                    $new_file_name = str_ireplace(" ","-",$title.".php");
                    $myfile = fopen("../$new_file_name","w") or die("Unable to open file!");
                    fwrite($myfile, $site_content);
                    fclose($myfile);
                    
                    //add it to DB
                    if(mysqli_query($con,"INSERT INTO health_doctor(title,image_url,page_url) VALUES('$title','$img_name','$new_file_name')")){
                        echo "ARTICLE SUCCESSSFULLY CREATED";
                        ?>
                            <script type="text/javascript">
                                alert("Added Successfully");
                            </script>
                       <?php
                    }else{
                        echo "ERROR, contact admin";
                        ?>
                            <script type="text/javascript">
                                alert("Error, contact admin");
                            </script>
                       <?php
                    }
                    
                }else{
                    echo "ERROR UPLOADING FILE TO SERVER, TRY AGAIN LATER";
                }
                
            }else{
                echo "image is invalid";
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
        
        <link rel="stylesheet" href="../../template/ckec/samples/css/samples.css">
        <script type="text/javascript" src="../../template/ckec/ckeditor.js"></script>
        <script type="text/javascript" src="../../template/ckec/samples/js/sample.js"></script>
    </head>
    <body class="w3-container w3-padding-0 w3-margin-0" style="width: 100%; height: 100%; position: absolute; background: #ACACAC;">
        <br><div class="w3-left" style="cursor: pointer;"> <a href="../../adn/homepage.php"><i class="fa fa-chevron-left"></i>BACK</a></div> <br>
        
        <div class="w3-card-12 w3-grey" style="position:absolute; top:10%; overflow: auto; margin-left:10%; width:80%; margin-right:10%;">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" style="overflow: auto;" class="" onsubmit="reprocess()">
                <div>
                    <h3 class="w3-center">CREATE NEW ARTICLE</h3>
                </div>
                
                <div>
                    <input class="w3-input w3-light-grey" type="text" name="title" value="<?php echo $title;?>" placeholder="Enter Article Title" required>
                    <label class="w3-validate w3-label">Title for site/og</label>
                </div>
                
                <br>
                <div>
                    <input class="w3-input w3-light-grey" type="text" name="desc" value="<?php echo $desc;?>" placeholder="Enter Article desc" required>
                    <label class="w3-validate w3-label">Description for og/header_info</label>
                </div>
                
                <br>
                <div>
                    <textarea class="w3-input w3-light-grey" name="content" style="display: none;" style="height: 300px;"><?php echo $content;?></textarea>
                    <div id="editor">
                        <?php 
                            if(($content) == ""){
                                echo "<h2>content goes here</h2>";
                            }else{
                                echo $content;
                            }
                            
                        ?>
                    </div>
                    <label class="w3-validate w3-label">Content (html designs are accepted)</label>
                </div>
                
                <div>
                    <input class="w3-input" type="file" name="file" required>
                    <label class="w3-validate w3-label">Site main image/og main image</label>
                </div>
                
                <div>
                    <input class="w3-input w3-light-grey" type="hidden" name="key" value="<?php echo $key;?>" placeholder="Enter Modification key" required>
                </div>
                
                <div>
                    <input class="w3-btn-block" type="submit" name="submit" value="Create Article">
                </div>
                
            </form>
            <br>
        </div>
        <br>
        
        <script>
                initSample();
                
                function reprocess(){
                    $("textarea[name='content']").html( CKEDITOR.instances['editor'].getData() );
                    return true;
                }
        </script>
        
    </body>
</html>
