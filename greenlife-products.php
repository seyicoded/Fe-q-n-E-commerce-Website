<?php
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
?>
<!DOCTYPE html>
<html>
    <head>
    
        <meta name="description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various... check for more ">
        <link rel="canonical" href="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:title" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:image" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/media/image/icon/icon.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="350">
        <meta property="og:image:height" content="400">
        <meta property="og:image:alt" content="Femquen & Co Int'l (FQCI) Official Site">
        <meta property="og:description" content="We are Engaged with the Marketing of Natural Herbal Medicines and related products. The Natural Herbal Medicines deals wiith curatives and prevention of various types of health challenges, we perform diagonistic analysis and profer recommendation leading to cure of various... check for more"> 
        <meta name="copyright" content="FQCI is protected by copyright.">
        <meta name="keywords" content="website, fqci, marketing, drugs, products, goods, health, curative, greenlife, official">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FQCI &hearts; Products</title>
        <link rel="stylesheet" href="template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="template/lib/w3.css">         
        <link rel="stylesheet" href="template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="media/image/icon/icon.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="template/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="template/css/index.css">
        <script type="text/javascript" src="template/js/jquerym.js"></script>
        <script type="text/javascript" src="template/js/index.js"></script>
        
        <script type="text/javascript" src="template/ckec1/ckeditor.js"></script>
        <script type="text/javascript" src="template/ckec1/samples/js/sample.js"></script>
    </head>
    <body class="w3-padding-0 w3-margin-0">
        <div id='body' class="w3-container w3-padding-0 w3-margin-0">
            
            <?php
                //import header
                include("include/header.php");
            ?>                                                                                                                                 
            
            <div id='content' class="w3-container w3-padding-0 w3-margin-0">
                
                <?php /* site content goes here */?>
                
                <?php
                        if(isset($_COOKIE[md5('signed_data')])){
                            ?>
                                <a class="w3-right" style="color:rgba(100,200,130,0.7) !important;" href="view-purchase.php">view purchased history</a>
                                <a class="w3-right" style="color:rgba(100,200,130,0.7) !important; display: none;" href="greenlife-products-all.php">All product</a>
                                <br>
                            <?php
                        }
                ?>
                
                <div class="w3-container ">
                    <a href="greenlife_product.php" style="float: right; color: rgba(20,2,4,0.4) !important;">comprehensive data</a>
                    <h1 class="w3-padding w3-pale-green w3-text-green" style="font-weight: bolder; padding: 4% 3% !important;">GREENLIFE PRODUCTS</h1>
                </div>
                
                <img src="media/image/resource/i.gif" style="display: none;">
                
                <div class="w3-container w3-margin w3-padding-0" id='product-container'>
                    <div id='container-header'>
                        <span class="w3-margin" style="font-size: 17px;  color: rgba(0,0,0,0.7); font-weight: bold;">Looking for a product, why not try our AI search</span>
                        <form action="" onsubmit="return false" class="row w3-margin">
                            <div class="w3-col s12 m9 l10"><input name="search" type="search" list="search_suggestion" onkeyup="check_search(this.value)" class="form-control" style="width:95%; height: 40px;" placeholder="Enter Product Name or Any Description about it you need"></div>
                            <div class="w3-col s12 m3 l2"><button type="submit" class="btn w3-padding w3-light-blue" style="font-weight: bolder; color:white !important; height: 51px;" onclick="search_now(this)" required>SEARCH</button></div>
                            <datalist id='search_suggestion'>
                            </datalist>
                        </form>
                        
                    </div>
                    
                    <script type="text/javascript">
                    
                        function search_now(btn){
                            var search = $("input[name='search']").val();
                            var container = $("#container-content .row");
                            if(search.length <= 0){
                                btn.innerHTML = 'input text';
                                return false;
                            }
                            btn.innerHTML = '<img src="media/image/resource/i.gif" style="">';
                            container.css("opacity","0.4");
                            
                            var aj = createajax();
                            var fd = new FormData();
                            
                            fd.append("search_text",search);
                            fd.append("display_search_result","true");
                            
                            aj.onreadystatechange = function(){
                                    if(aj.readyState == 4 && aj.status == 200){
                                        //alert(aj.responseText);                     
                                        //return true;
                                        var inp = JSON.parse(aj.responseText);
                                        //alert(typeof inp);
                                        if(inp.exist){
                                            $("#container-content .row").html(atob(inp.msg));
                                            sl1 = inp.sl1;
                                            sl2 = inp.sl2;
                                            ln = inp.ln;  
                                            sendng = 0;                               
                                            btn.innerHTML = 'SEARCH';
                                            container.css("opacity","1");
                                        }else{
                                            //alert(false+ inp);
                                            sendng = 1;   
                                            btn.innerHTML = 'SEARCH';
                                            container.css("opacity","1");
                                        }
                                        
                                    }
                                    if(aj.readyState < 4 && aj.status == 200){}
                                    if(aj.readyState <= 4 && aj.status == 404){}
                            }
                            
                            aj.open("POST","ajax/purchase_product.php");
                            aj.send(fd);
                        }
                    
                        function check_search(txt){
                            var aj = createajax();
                            var fd = new FormData();
                            fd.append("txt",txt);
                            fd.append("check_search",true);
                            
                            aj.onreadystatechange = function(){
                                if(aj.readyState ==4 && aj.status == 200){
                                    $("#search_suggestion").html(aj.responseText);
                                }
                            }   
                            
                            aj.open("POST","ajax/purchase_product.php");
                            aj.send(fd);
                        }
                    </script>
                    
                    <script type="text/javascript">
                        function show_image(image_id){
                                $("#loader-"+image_id).hide();
                                $("#image-"+image_id).show();
                            }
                    </script>
                    
                    <style type="text/css">
                        .content-box-inner{
                            font-family: sans-serif;
                            font-size: 15px;
                            height: 240px;
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
                    
                    
                    <div id='container-content' class="">
                    
                        
                        <div class="row w3-margin">
                            <?php
                                //save d last id
                                //send d last id and the sql encoded with base64encoding
                                
                                $wh = '';
                                $q1 = "SELECT * FROM product";
                                $q2 = "ORDER BY p_id ASC LIMIT 12";
                                $query_text = "$q1 $wh $q2";
                                $sql = mysqli_query($con,$query_text);
                                $num = mysqli_num_rows($sql);
                                $last_id_loaded = 0;
                                for($i = 1 ; $i <= $num ; $i++){
                                    $r = mysqli_fetch_assoc($sql);
                                            
                                    $p = ($i >= 5) ? "1": $i;
                                    $ii = ((intval($p) * 2) + 5) . "00";
                                    
                                    ?>
                                        <div class="w3-col s12 m6 l3 wow fadeInDown" data-wow-duration="1200ms" data-wow-delay="<?php echo $ii;?>ms">
                                            <div class="w3-card-4 w3-round" style="margin: 6%;">
                                                <div id='image-box'>
                                                    <div id="loader-<?php echo $i;?>" style="height: 300px; width: 100%; position: relative;">
                                                        <img src="media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">
                                                    </div>
                                                    <img id="image-<?php echo $i;?>" onload="show_image('<?php echo $i;?>')" src="media/image/product/<?php echo $r['p_image'];?>" alt="<?php echo $r['p_name'];?>" class="w3-round" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                                
                                                <div id="content-box">
                                                    <h4 class="w3-center" style="padding:8% 0px; font-weight: 900"><?php echo $r['p_name'];?></h4>
                                                    
                                                    <div class="w3-card-4 w3-margin w3-padding content-box-inner"><?php echo substr($r['p_desc'],0,270)."........";?></div>
                                                    <div style="width: 100%; padding: 2%;">
                                                        <!--position:absolute; right: 10% !important;-->
                                                        <a href="product.php?mode=info&pid=<?php echo $r['p_id'];?>&p_name=<?php echo $r['p_name'];?>"><button class="w3-card-4 w3-center w3-btn w3-blue w3-round" style=" font-weight: bold; display: inline-block; width: 48%; ">DISCOVER</button></a>
                                                        <a href="product.php?mode=get&pid=<?php echo $r['p_id'];?>&p_name=<?php echo $r['p_name'];?>"><button class="w3-card-4 w3-center w3-btn w3-green w3-round" style=" font-weight: bold; display: inline-block; width: 48%;">BUY NOW</button></a>
                                                    </div>
                                                                                                                            
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    
                                    $last_id_loaded = $r['p_id'];
                                }
                            
                            ?>
                            
                            <script type="text/javascript">
                             //variable to change and utilize
                             var sl1 = "<?php echo base64_encode($q1);?>";
                             var sl2 = "<?php echo base64_encode($q2);?>";
                             var ln = "<?php echo base64_encode($last_id_loaded);?>";
                        </script>
                        </div>
                        
                        <div class="w3-container anim">
                            <div id='loader' style="display:none; position: relative; left: 50%; opacity:0.7; width:42px; border-top:9px solid green;border-bottom:9px solid green;border-left:9px solid red;border-right:9px solid blue;" class="w3-circle w3-spin">&nbsp;</div>
                        </div>
                        
                        <div id='scroll-to-view-more'> </div>
                        
                        
                    </div>
                </div>
                
            </div>
            
                        <script type="text/javascript">
                            
                            var sendng = 0;
                            
                            function show_more(){
                                if(sendng == 0){
                                    //use ajax success to change it back to 0
                                    sendng = 1;
                                }else{
                                    return false;
                                }
                                
                                var loader = $("#loader");
                                
                                loader.show();
                                
                                var aj = createajax();
                                var fd = new FormData();
                                
                                fd.append("sl1",sl1);
                                fd.append("sl2",sl2);
                                fd.append("ln",ln);
                                fd.append("view_more","true");
                                
                                aj.onreadystatechange = function(){
                                    if(aj.readyState == 4 && aj.status == 200){
                                        //alert(aj.responseText);                     
                                        var inp = JSON.parse(aj.responseText);
                                        //alert(typeof inp);
                                        if(inp.exist){
                                            //$("#container-content .row").append(atob(inp.msg));
                                            $("#container-content .row").append((inp.msg));
                                            sl1 = inp.sl1;
                                            sl2 = inp.sl2;
                                            ln = inp.ln;
                                            loader.hide();
                                            sendng = 0;
                                        }else{
                                            //alert(false+ inp);
                                            sendng = 1;
                                            loader.hide();
                                        }
                                        
                                    }
                                    if(aj.readyState < 4 && aj.status == 200){}
                                    if(aj.readyState <= 4 && aj.status == 404){}
                                }
                                
                                aj.open("POST","ajax/purchase_product.php");
                                aj.send(fd);
                                
                            }
                            
                            window.addEventListener("scroll",function(){
                                //var y = window.pageYOffset;                              
                                //var y = $("#scroll-to-view-more").offset().top();
                                var sm_top = document.getElementById('scroll-to-view-more').offsetTop;
                                var w_hei = $(window).height();
                                
                                var y = (sm_top - w_hei) - 100;
                                
                                var pos_of_bar = ( (document.documentElement || document.body).scrollTop );
                                if(pos_of_bar >= y){
                                    //console.log("true: "+pos_of_bar+":"+y);
                                    show_more();
                                }else{
                                    //console.log("false: "+pos_of_bar+":"+y);
                                }
                            });
                        </script>
            
            <?php
                //import footer
                include("include/footer.php");
            ?>
            
        </div>
        <script type="text/javascript" src="template/js/wow.min.js"></script>
        <script type="text/javascript" src="template/bootstrap/js/bootstrap.min.js"></script>
        <script src="owlcarousel/owl.carousel.min.js"></script>
        <script type="text/javascript">
            //Initiat WOW JS
            new WOW().init();
        </script>
        <script>
            $('.carousel').carousel({
                interval:3000,
                pause:"hover"
            })
            initSample();
        </script>
    </body>
</html>
