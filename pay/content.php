<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");

    if(!isset($_GET['d'])){
        echo "
            <script>
                window.history.back();
            </script>
        ";
    }

    $id = intval($p->sqlr($con, $p->xssr($_GET['d'])));

    $datd = null;
    try{
        $data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM post WHERE p_id = $id"));
    }catch(Exception $e){
        echo "
            <script>
                window.history.back();
            </script>
        ";
    }

    $views = intval($data['views']) + 1;
    mysqli_query($con, "UPDATE post SET views = '$views' WHERE p_id = $id");
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
    <script type="text/javascript" src="src/js/index.js"></script>
    <style type="text/css">
                        .content-box-inner{
                            font-family: sans-serif;
                            font-size: 15px;
                            height: 70px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            -o-text-overflow: ellipsis;
                            -ms-text-overflow: ellipsis;
                            -moz-text-overflow: ellipsis;
                            -webkit-text-overflow: ellipsis;
                        }
                        .content-box-inner:hover{
                            
                            
                        }
                        .anim{
                            animation: bounce 2s linear 2s infinite alternate ;
                        }
                        
                        #image-box{
                            position: relative;
                            overflow: hidden;
                        }
                        
                        #image-box img{
                            -webkit-transition: all 0.4s linear;
                            -o-transition: all 0.4s linear;
                            transition: all 0.4s linear;
                        }
                        #image-box img:hover{
                              -webkit-transform: scale(1.15);
                              -ms-transform: scale(1.15);
                              transform: scale(1.15);
                        }
                    </style>

<script type="text/javascript">
                        function show_image(image_id){
                                $("#loader-"+image_id).hide();
                                $("#image-"+image_id).show();
                            }

                            window.onload = function(){
                                setTimeout(function(){
                                    $.get('./content_rewarded.php', {p_id: '<?php echo $id;?>'});
                                }, 45000);
                            }
                    </script>
</head>
<body>
    <?php
        include("include/signedHeader.php");
    ?>

    <div style="display: flex; justify-content: flex-end; width: 98%">
        views: <span class="w3-text-grey"><?php echo $views;?></span>
    </div>
    <div class="w3-content">
        <div>
            <h1 class="w3-center w3-text-grey"><?php echo $data['p_title'];?></h1>
        </div>
        <div id='image-box'>
            <div id="loader-<?php echo $id;?>" style="height: 160px; width: 100%; position: relative;">
                <img src="../media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">
            </div>
            <img id="image-<?php echo $id;?>" onload="show_image('<?php echo $id;?>')" src="../media/image/post/<?php echo $data['image'];?>" alt="<?php echo $r['p_name'];?>" class="w3-round" style="width: 100%; height: 512px; display: none; margin: 3% 0%">
        </div>

        <div>
            <p class="w3-small" style="text-align: justify;">
                <?php echo $data['p_desc'];?>
            </p>

            <p class="" style="text-align: justify;">
                <?php echo $data['p_content'];?>
            </p>
        </div>
    </div>

    
    <?php
        include('../include/footer.php');
    ?>
</body>
</html>