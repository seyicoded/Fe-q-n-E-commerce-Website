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

    function check_status_and_reward($con, $pid){
        $dt = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM post WHERE p_id='$pid'"));
        
        $status = $dt['status'];

        if(intval($status) == 0){
            return true;
        }

        $rewarded = $dt['rewarded'];

        if(intval($rewarded) != 0){
            return true;
        }
        
        $user_id = $dt['user_id'];
        
        if(intval($user_id) == 0){
            return true;
        }

        // add 6% to user
        // credit user 4% of his total package price
        // get user detail
        $package_id = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM subscription_linker WHERE puser_id='$user_id'"))['package_id'];
        $package_amount = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_package WHERE p_id='$package_id'"))['p_price'];

        $package_amount = intval($package_amount);

        $amount_to_add_6_pect = floor( (6 * $package_amount) / 100 );

        // get user wallet
        $user_wallet = intval(mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$user_id'"))['pu_wallet']);

        $new_user_wallet = intval($amount_to_add_6_pect) + $user_wallet;

        // update wallet amount
        if( mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$new_user_wallet' WHERE pu_id='$user_id'") ){
            if(mysqli_query($con, "UPDATE post SET rewarded = 1 WHERE p_id = $pid")){
                // echo "true";
                return true;
            }else{
                // echo false;
                return false;
            }
        }else{
            // echo false;
            return false;
        }
    }
    
    if(isset($_POST['submit'])){
        // print_r($_POST);
        // die('died');
        // return 0;
        $pid = $_POST['p_id'];
        $title = $_POST['p_title'];
        $p_type = $_POST['p_type'];
        $p_status = intval($_POST['p_status']);
        $desc = $_POST['desc'];
        $content = $_POST['p_content'];
        if($_FILES['p_image']['name'] != ''){
            // echo "sent";

            $img_name = rand(0,1000).rand(0,1000).basename($_FILES['p_image']['name']);
            $img_path = "../media/image/post/".$img_name;

            if(move_uploaded_file($_FILES['p_image']['tmp_name'],$img_path)){
                //add to db i guess
                $sql = "UPDATE post SET p_title = '$title', p_type = '$p_type', p_desc = '$desc', p_content = '$content', image = '$img_name', status=$p_status WHERE p_id = '$pid'";
                if( mysqli_query($con, $sql) ){
                    // check if it's a new from a user then reward the user
                    check_status_and_reward($con, $pid);
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
            // echo "not sent";

            $sql = "UPDATE post SET p_title = '$title', p_type = '$p_type', p_desc = '$desc', p_content = '$content', status=$p_status WHERE p_id = '$pid'";
            if( mysqli_query($con, $sql) ){
                check_status_and_reward($con, $pid);
                header('Location: pay_view_post.php');
            }else{
            unlink($img_path); 
            ?>
                    <script>
                        alert('an error occurred');
                    </script>
                <?php
            }
        }
        
        
        
    }else{
        $authen = '';
    }
    
    if(isset($_GET['pid'])){
        $pid = $p->sqlr($con, $p->xssr($_GET['pid']));
        
        $dt = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM post WHERE p_id='$pid'"));
        $title = $dt['p_title'];
        $p_type = $dt['p_type'];
        $p_status = $dt['status'];
        $desc = $dt['p_desc'];
        $content = $dt['p_content'];
        $img_name = $dt['image'];
        $img_path = "../media/image/post/".$img_name;
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
                <h2 class="w3-center w3-card-4" style="font-weight: bold;">EDIT A POST</h2>
                
                <input type="hidden" name="p_id" value="<?php echo $pid;?>" />

                <div class="w3-margin">
                    <input value="<?php echo $title;?>" type="text" class="w3-input" name="p_title" placeholder="Enter Post Title" required>
                    <label class="w3-label w3-validate">Post Title</label>
                </div>
                
                <div class="w3-margin">
                    <select name="p_type" class="w3-input">
                        <option value="normal" <?php echo ($p_type == 'normal') ? 'selected' : '' ?>>Normal</option>
                        <option value="sponsor" <?php echo ($p_type == 'sponsor') ? 'selected' : '' ?>>Sponsor</option>
                    </select>
                    <label class="w3-label w3-validate">Post Type</label>
                </div>

                <div class="w3-margin">
                    <select name="p_status" class="w3-input">
                        <option value="1" <?php echo (intval($p_status) == 1) ? 'selected' : '' ?>>ACTIVE</option>
                        <option value="0" <?php echo (intval($p_status) == 0) ? 'selected' : '' ?>>IN-ACTIVE</option>
                    </select>
                    <label class="w3-label w3-validate">Post Status</label>
                </div>
                
                <div class="w3-margin">
                    <textarea class="w3-input" name="desc" class="custom-control" placeholder="Enter Post Description" required><?php echo $desc;?></textarea>
                    <label class="w3-label w3-validate">Post Description</label>
                </div>
            
                <br>
                <div class="w3-margin w3-container">
                    <textarea class="w3-input w3-round" style="height:400px; display: none;" name="p_content" placeholder="Enter Product Explanation"></textarea>
                    
                    <div id="editor">
                    <?php echo $content;?>
                    </div>
                    <label class="w3-label w3-validate">Post Content</label>
                </div>
                
                <img src="<?php echo $img_path;?>" style="width: 300px; height: 300px" />
                <div class="w3-margin">
                    <input type="file" class="w3-input" name="p_image">
                    <label class="w3-label w3-validate">Post Image</label>
                </div>
                
                
                
                <div class="w3-margin"><?php echo $msg;?></div>
                
                <div class="w3-margin">
                    <input class="w3-btn-block" type="submit" name="submit" value="EDIT">
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
