<?php
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    
    if(isset($_POST['feedback_now'])){
        
        $name = $p->sqlr($con,$p->xssr($_POST['name']));
        $email = $p->sqlr($con,$p->xssr($_POST['email']));
        $pid = $p->sqlr($con,$p->xssr($_POST['p_id']));
        $comment = $p->sqlr($con,$p->xssrcontent($_POST['comment']));
        $status = 0;
        
        //print_r($_POST);
        //exit();
        //add to db
        $sql = "INSERT INTO product_feedback(pf_p_id,name,email,feedback,status) VALUES('$pid','$name','$email','$comment','$status')";
        mysqli_query($con,$sql);
        
        //cookie manipulation
        if(!(isset($_COOKIE[md5('signed_data')]))){
            setcookie(md5('full_name'),base64_encode($name), time () + (86400 * 365) , '/');
            setcookie(md5('email'),base64_encode($email), time () + (86400 * 365) , '/');
        }
        
        //redirect
        $mode = $_POST['mode'];
        $p_name = $_POST['p_name'];
        $pid = $_POST['p_id'];
        $url = ("mode=$mode&pid=$pid&p_name=$p_name");
        header("Location:product.php?$url");
        exit();
    }
    
    if(isset($_GET['mode'])){
        try{
            $pid = $p->sqlr($con,$p->xssr($_GET['pid']));
            $pname = $p->sqlr($con,$p->xssr($_GET['p_name']));
            $sql = mysqli_query($con,"SELECT * FROM product WHERE p_id='$pid' || p_name='$pname'");
            $num = mysqli_num_rows($sql);
            
            if($num == 0){
                header("Location:greenlife-products-all.php");
            }
            
            $r = mysqli_fetch_assoc($sql);
        }catch(Exception $e){
            header("Location:greenlife-products-all.php");
        }
        
    }else{
        header("Location:greenlife-products-all.php");
    }
    
    function get_discount($price){
        $price = str_replace(",","",$price);
        $price = intval($price);
        $discounted_amount = 0;
        
        if( ($price) < 10000 ){
            //discounted 22%
            $discounted_amount = ((22 * $price) / 100);
        }else if( (($price) > 10000) && (($price) < 80000)) {
            //discounted 22%
            $discounted_amount = ((22 * $price) / 100);
        }else if( ($price) > 80000 ){
            //discounted 10%
            $discounted_amount = ((10 * $price) / 100);
        }
        
        $old_price = ceil($price + $discounted_amount);
        
        return $old_price;
    }
?>
<!DOCTYPE html>
<html>
    <head>
    
        <meta name="description" content="<?php echo substr($r['p_desc'],0,300);?>......">
        <link rel="canonical" href="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:title" content="FQCI: <?php echo $r['p_name'];?> product information">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>">
        <meta property="og:image" content="http://wwww.<?php echo $_SERVER['SERVER_NAME'];?>/media/image/product/<?php echo $r['p_image'];?>">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="350">
        <meta property="og:image:height" content="400">
        <meta property="og:image:alt" content="FQCI: <?php echo $r['p_name'];?> product information">
        <meta property="og:description" content="<?php echo substr($r['p_desc'],0,300);?>......"> 
        <meta name="copyright" content="FQCI is protected by copyright.">
        <meta name="keywords" content="<?php echo $r['p_name'];?>, website, fqci, marketing, drugs, products, goods, health, curative, greenlife, official">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">           
        <title>FQCI: <?php echo $r['p_name'];?> product information</title>
        <link rel="stylesheet" href="template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="template/lib/w3.css">         
        <link rel="stylesheet" href="template/font-awesome/css/font-awesome.min.css">
        <link rel="icon" href="media/image/product/<?php echo $r['p_image'];?>" type="image/x-icon">
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
                if(isset($_GET['mode'])){
                    if($_GET['mode'] == 'get'){
                        ?>          
                            
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    //data-toggle="modal"
                                    ($("button[data-toggle='modal']").click());
                                });
                            </script>
                        <?php
                    }
                }
            ?>
            
            <?php
                //import header
                include("include/header.php");
            ?>
            
            <div id='content' class="w3-container w3-padding-0 w3-margin-0">
                
                <?php /* site content goes here */?>
                
                <script type="text/javascript">
                        function show_image(image_id){
                                $("#loader-"+image_id).hide();
                                $("#image-"+image_id).show();
                        }
                        
                        var price_orig = ' <?php echo str_replace(",","",$r['p_price']); ?> ';
                        
                        function reduce_quan(){
                            var num = parseInt($("input[name='quantity']").val());
                            num -= 1;
                            num = (( num <= 0) ? 0 :num) ;
                            
                            var price = price_orig * num ;
                            price = convert_to_money(price);
                            //console.log(num);
                            $("input[name='quantity']").val(num);
                            $("input[name='price']").val("₦"+price);
                        }
                        
                        function increase_quan(){
                            var num = parseInt($("input[name='quantity']").val());
                            num += 1;
                            var price = price_orig * num ;
                            price = convert_to_money(price);
                            //console.log(num);
                            $("input[name='quantity']").val(num);
                            $("input[name='price']").val("₦"+price);
                        }
                        
                        function update(num){
                            num = parseInt(num);
                            num = (( num <= 0) ? 0 :num) ;
                            
                            var price = price_orig * num ;
                            price = convert_to_money(price);
                            //console.log(num);
                            $("input[name='quantity']").val(num);
                            $("input[name='price']").val("₦"+price);
                        }
                        
                        function convert_to_money(str){
                            str = str.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            return str;
                        }
                </script>
                
                <style type="text/css">
                    form[name='get_now_form'] label{
                        font-weight: bold;
                    }
                </style>
                
                <div class="w3-container">
                    
                    <?php
                        if(isset($_COOKIE[md5('signed_data')])){
                            ?>
                                <a class="w3-right" style="color:rgba(100,200,130,0.7) !important;" href="view-purchase.php">view purchased history</a>
                            <?php
                        }
                    ?>
                    
                    <br>
                    
                    <h1 class="w3-center w3-text-grey w3-text-shadow" style="font-weight: bold; text-transform: uppercase;"><?php echo $r['p_name'];?></h1>
                    
                    <div class="row w3-margin">
                        <div class="w3-col s12 m6 l5">
                            <div class="w3-card-4 w3-round w3-margin-32">
                                <div id='image-box' class="w3-round con">
                                    <?php $i = 0;?>
                                    <div id="loader-<?php echo $i;?>" style="height: 300px; width: 100%; position: relative;">
                                        <img src="media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">
                                    </div>
                                    <img id="image-<?php echo $i;?>" onload="show_image('<?php echo $i;?>')" src="media/image/product/<?php echo $r['p_image'];?>" alt="<?php echo $r['p_name'];?>" class="w3-round" style="width: 100%; height: 460px; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="w3-col s12 m6 l7">                                   
                           
                           <br>
                           <div style="position: relative;">
                                <div style="text-decoration:line-through grey double; font-weight:bold; color: #580000; padding: 0px !important; margin: 0px !important;" class="w3-xlarge w3-padding-0 w3-margin-0"><?php echo "₦".number_format(get_discount($r['p_price']));?></div>
                                <div style="font-weight:bolder; padding: 0px !important; margin: 0px !important;" class="w3-jumbo w3-animate-fading w3-padding-0 w3-margin-0"><?php echo "₦".number_format( str_replace(",","",$r['p_price']));?></div>
                                <div class="w3-right w3-small" style="font-family: cursive; font-style: italic;">grab while stock last (<span style="color: red;"> < 100 remaining </span>)</div>
                           </div>
                           
                           <form name="get_now_form" style="margin: 0px;" class="" onsubmit="return false">
                           
                                <div class="w3-margin">
                                    <label class="w3-label">PRICE</label>
                                    <input name="price" class="form-control" value="<?php echo "₦".number_format(str_replace(",","",$r['p_price']));?>.00" disabled="disabled">
                                </div>
                                <br>
                                
                                <div class="w3-margin">
                                    <label class="w3-label">QUANTITY</label>
                                    <div class="row">
                                        <button class="w3-col s1 m1 l1 border bg-light" onclick="reduce_quan()"> <i class="fa fa-angle-down"></i></button>
                                        <input name="quantity" type="number" class="w3-col s10 m10 l10 form-control" value="1" required onchange="update(this.value)">
                                        <button class="w3-col s1 m1 l1 border bg-light" onclick="increase_quan()"> <i class="fa fa-angle-up"></i></button>
                                    </div>
                                    
                                </div>
                                <br>
                           
                                <div>
                                    <marquee class="w3-large">Payment methods are available for both online and offline transaction</marquee>
                                    <button class="w3-btn-block w3-round w3-blue w3-xlarge w3-text-shadow" style="font-weight:bolder;" onclick="$('#mode_of_payment_sel').removeAttr('selected');$('#mode_of_payment_sel').attr('selected','selected'); load_data_for_payment($('#mode_of_payment').val());" data-toggle="modal" data-target="#myModal">GET IT NOW</button>
                                </div>
                           </form>
                        </div>
                    </div>
                    
                    <div class="w3-container" style="text-align: justify;">
                        <div class="w3-content w3-padding" style="font-style: italic; text-transform: lowercase;">
                            <?php echo $r['p_desc'];?>
                        </div>
                        
                        <br />
                        <div class="w3-container">
                            <?php echo $r['p_content'];?>
                        </div>
                        
                    </div>
                    <br>
                    <br>
                    
                    <div class="w3-content">
                        <h2 class="w3-center" style="text-transform: capitalize;">Feedback Section</h2>
                        <div>
                            <?php
                                //$pid
                                $one = 1;
                                $sql = mysqli_query($con,"SELECT * FROM product_feedback WHERE status='$one' AND pf_p_id='$pid'");
                                while( ($r = mysqli_fetch_assoc($sql)) ){
                                    ?>
                                        <div class="w3-card-2 w3-padding w3-round">
                                            <div class="w3-large w3-text-light-blue w3-text-shadow" style="font-weight: bolder; text-transform: uppercase;"><?php echo $r['name'];?></div>
                                            <div class="w3-margin w3-padding w3-round w3-card-2"><?php echo $r['feedback'];?></div>
                                            <div class="w3-small" style="text-align: right"><i><?php echo date("d/m/Y @ H;i A",strtotime($r['date']));?> </i></div>
                                        </div>
                                        <br />
                                    <?php
                                }                       
                            ?>
                        </div>
                        
                        <div>
                            <br>
                            <i class="w3-small">you can give us your view on this product here, now...</i>
                            
                            <?php
                                $full_name = (isset($_COOKIE[md5('full_name')])) ? base64_decode($_COOKIE[md5('full_name')]): "";
                                $email = (isset($_COOKIE[md5('email')])) ? base64_decode($_COOKIE[md5('email')]): "";
                                
                                if(intval(strlen($email)) >3 ){
                                    $zero = 0;
                                    $s1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM product_feedback WHERE email='$email' AND status='$zero' AND pf_p_id='$pid'"));
                                    ?>
                                        <div class="w3-container" style="text-align: right;">
                                            Pending comment: <i class="w3-badge w3-indigo w3-small" style="font-style:italic;"><?php echo $s1;?></i>
                                        </div>
                                    <?php
                                }else{
                                    
                                }
                            ?>
                            
                            <form class="w3-card-8 w3-border" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="reprocesss()">
                            
                                <div>
                                    <input type="text" class="w3-input" name="name" placeholder="Enter your name, fully preferably" value="<?php echo $full_name;?>" required>
                                    <label class="w3-label w3-validate">Name</label>
                                </div>
                                
                                <div>
                                    <i class="w3-small">you're secured, email won't be displayed..<b style="color: red;">&hearts;</b></i>
                                    <input type="text" class="w3-input" name="email" placeholder="Enter your Email" value="<?php echo $email;?>" required>
                                    <label class="w3-label w3-validate">Email</label>
                                </div>
                                
                                <input type="hidden" name="pid" value="<?php echo $r['p_id'];?>">
                                <input type="hidden" name="comment" value="" required>
                                <input type="hidden" name="p_id" value="<?php echo $_GET['pid'];?>" required>
                                <input type="hidden" name="p_name" value="<?php echo $_GET['p_name'];?>" required>
                                <input type="hidden" name="mode" value="<?php echo $_GET['mode'];?>" required>
                                
                            
                                <div id="editor">
                                    <p>Your feedback goes here</p>    
                                </div>
                                <div class="w3-padding" style="text-align: right;">
                                    <i class="w3-small">all feedback would be posted by scanned but our service representative first to avoid terms violation, thanks.</i>
                                </div>
                                <div>
                                    <button type="submit" name="feedback_now" class="w3-center w3-btn-block w3-blue w3-text-shadow w3-xlarge" style="font-weight: bolder;">SEND</button>
                                </div>
                            </form>
                            <script type="text/javascript">
                                function reprocesss(){
                                    $("input[name='comment']").val( CKEDITOR.instances['editor'].getData() );
                                    return true;
                                }
                            </script>
                            
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
            <?php // modal start?>
            
            <!-- Trigger the modal with a button -->
                
                <style type="text/css">
                    .modal-header{
                        width: 100%;
                        position:relative !important;  
                    }
                    .modal-header .close{      
                    }
                    
                    .modal-dialog{
                        top:10% !important;
                    }
                    select[name='mode_of_payment'] *{
                        font-size: 18px;
                        font-weight: bold;
                        padding:15px;
                        margin-bottom: 5px;
                    }
                </style>
                
                <?php
                    $full_name = $email = $phone = $address = '';
                    if(isset($_COOKIE[md5('signed_data')])){
                        $full_name = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('full_name')])));
                        $email = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('email')])));
                        $phone = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('phone')])));
                        $address = base64_decode($p->sqlr($con,$p->xssr($_COOKIE[md5('address')])));
                    }
                ?>
                
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog" style="z-index:99999 !important;">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">       
                      <div class="modal-header">
                        <h4 class="modal-title" style="font-weight: bold;">Submit Request</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        
                        <img id="image-<?php echo $i;?>" src="media/image/product/<?php echo $r['p_image'];?>" alt="<?php echo $r['p_name'];?>" class="w3-round w3-card-4" style="width: 50%; height: 130px; margin: 1% 24%; border: 1px solid rgba(0,0,0,0.4);">
                        <br>
                        
                        <form onsubmit="return false">
                        
                            <input type="hidden" name="<?php echo md5('id');?>" value="<?php echo $r['p_id'];?>">
                            
                            <br>
                            <div>
                                <input class="form-control" type="text" placeholder="Enter Product Name" name="product_name" value="<?php echo $r['p_name'];?>" disabled="disabled" required>
                                <label class="w3-label w3-validate">Product Name</label>
                            </div>
                            <br>
                            
                            <div>
                                <input class="form-control" type="text" placeholder="Enter Product Name" id='quantityy' name="quantity" value="1" disabled="disabled" required>
                                <label class="w3-label w3-validate">Product Quantity</label>
                            </div>
                            <br>
                            
                            <div>
                                <input class="form-control" type="text" placeholder="Enter price" id='pricee' name="price" value="<?php echo "₦".number_format(str_replace(",","",$r['p_price']));?>" disabled="disabled" required>
                                <label class="w3-label w3-validate">Product Price</label>
                            </div>
                            <br>
                            
                            <div>
                                <input class="w3-input" type="text" placeholder="Enter Your Full Name" name="full_name" value="<?php echo $full_name;?>" required>
                                <label class="w3-label w3-validate">Full Name</label>
                            </div>
                            <br>
                            
                            <div>
                                <input class="w3-input" type="email" id='email' placeholder="Enter Your Email" value="<?php echo $email;?>" name="email" required>
                                <label class="w3-label w3-validate">Email</label>
                            </div>
                            <br>
                            
                            <div>
                                <input class="w3-input" type="tel" id='phone' placeholder="Enter Your Phone Number" value="<?php echo $phone;?>" name="phone" required>
                                <label class="w3-label w3-validate">Reachable Phone Number</label>
                            </div>
                            <br>
                            
                            <div>
                                <textarea class="w3-round form-control" style="width:100%; height: 150px; resize:none;" placeholder="Enter Address" name="address" required><?php echo $address;?></textarea>
                                <label class="w3-label w3-validate">Reachable Address (Home)</label>
                            </div>
                            <br>
                            
                            <div class="alert alert-info w3-small">
                                It's not mandatory you paid now, you can choose to place the order as bank transfer then we'll get your request
                                and get back to you on that product and how you would want to get it....
                            </div>
                            
                            <div>
                                <select id='mode_of_payment' name="mode_of_payment" class=" custom-select" onchange="load_data_for_payment(this.value)">
                                    <option value='select' id='mode_of_payment_sel'>click to select</option>
                                    <option value="bank">BANK TRANSFER</option>
                                    <option value="online">ONLINE</option>
                                </select>
                                <label class="w3-label w3-validate">Select Mode of Payment</label>
                            </div>
                            <br>
                            
                            <div id='data_for_payment'></div>
                            <br>
                            
                            <div id='noti'></div>
                            <br>
                            
                            <button type="submit" class="w3-btn-block w3-blue w3-round" style="font-weight: bold;" onclick="submit_order(this)">Place Order</button> 
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default w3-small" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>
            
            <?php // modal stop?>
                               
            <?php
                //import footer
                include("include/footer.php");
            ?>
            
        </div>
        <script type="text/javascript">
        
            function submit_order(btn){                                                      
                btn.innerHTML = '<img src="media/image/resource/i.gif" style="padding:1%;">';
                
                //declare data
                var noti = $("#noti");
                var pid = $("input[name='<?php echo md5('id');?>']").val(); 
                var pname = $("input[name='product_name']").val();
                //var quantity = $("#quantity").val();
                var quantity = (document.getElementById('quantityy')).value;
                //var price = $("#price").val();
                var price = (document.getElementById('pricee')).value
                var full_name = $("input[name='full_name']").val();
                var email = $("input[name='email']").val();
                var phone = $("input[name='phone']").val();
                var address = $("textarea[name='address']").val();
                var mode = $("select[name='mode_of_payment']").val();
                
                //noti.html(pid+pname+quantity+price+full_name+email+phone+mode);
                
                // mini validation
                if( (full_name.length <= 3) ){
                    noti.html('<div class="alert alert-danger">full name is considered invalid</div>');
                    btn.innerHTML = 'Re-Submit';
                    $("input[name='full_name']").focus();
                    return false;
                }
                
                if( (email.length <= 3) || !(( document.getElementById('email') ).checkValidity()) ){
                    noti.html('<div class="alert alert-danger">email is considered invalid</div>');
                    btn.innerHTML = 'Re-Submit';
                    $("input[name='email']").focus();
                    return false;
                }
                               
                if( ((phone.length <= 10 )) || !(( document.getElementById('phone') ).checkValidity()) ){
                    noti.html('<div class="alert alert-danger">phone number is considered invalid</div>');
                    btn.innerHTML = 'Re-Submit';
                    $("input[name='phone']").focus();
                    return false;
                }
                
                if( (address.length <= 3) ){
                    noti.html('<div class="alert alert-danger">address is considered invalid</div>');
                    btn.innerHTML = 'Re-Submit';
                    $("textarea[name='address']").focus();
                    return false;
                }
                
                if( (mode == "select") ){
                    noti.html('<div class="alert alert-danger">a mode must be selected</div>');
                    btn.innerHTML = 'Re-Submit';
                    $("select[name='mode_of_payment']").focus();
                    return false;
                }
                                                       
                noti.html('validation complete, processing request...');
                
                var aj = createajax();
                var fd = new FormData();
                
                //prepare request to send
                fd.append("pid",pid);
                fd.append("pname",pname);
                //wow
                fd.append("quantity",quantity);
                fd.append("price",price);
                //dont touch
                fd.append("full_name",full_name);
                fd.append("email",email);
                fd.append("phone",phone);
                fd.append("address",address);
                fd.append("mode",mode);
                fd.append("add_product_to_purchase","true");
                
                aj.onreadystatechange = function(){
                    if(aj.readyState == 4 && aj.status == 200){
                        noti.html('<div class="alert alert-success">'+aj.responseText+'</div>');
                        var inp = JSON.parse(aj.responseText);
                        
                        if(inp.mode == "bank"){
                            if(inp.done){
                                noti.html('<div class="alert alert-success">Successfully requested, please wait while your been redirected to a view purchase page...</div>');
                                setTimeout(function(){window.location.replace('view-purchase.php');},2000);
                            }else{
                                noti.html('<div class="alert alert-info">an error occurred, try again by clicking on re-submit</div>');
                                btn.innerHTML = 'Re-Submit';
                            }
                        }else if(inp.mode == "online"){
                            if(inp.done1){
                                if(inp.done2){
                                    //done and successful
                                    noti.html('<div class="alert alert-success">please wait while your been redirected to a secure payment platform...</div>');
                                    setTimeout(function(){window.location.replace('paynow.php?o_id='+inp.o_id+'&o_code='+inp.o_code);},2000);
                                }else{
                                    noti.html('<div class="alert alert-info">an error occurred #102, try again by clicking on re-submit</div>');
                                    btn.innerHTML = 'Re-Submit';
                                }
                            }else{
                                noti.html('<div class="alert alert-info">an error occurred #101, try again by clicking on re-submit</div>');
                                btn.innerHTML = 'Re-Submit';
                            }
                        }
                    }
                    if(aj.readyState < 4 && aj.status == 200){
                        noti.html('<div class="alert alert-info">sending, please wait...</div>');
                        //btn.innerHTML = 'Re-Submit';
                    }
                    if(aj.readyState <= 4 && aj.status == 404){
                        noti.html('<div class="alert alert-info">an error occurred while connecting to server, try again by clicking on re-submit</div>');
                        btn.innerHTML = 'Re-Submit';
                    }
                }
                
                noti.html('processing complete, sending instructions to server');
                
                aj.open("POST","ajax/purchase_product_order.php");
                aj.send(fd);
            }
        
            function load_data_for_payment(val){
                var container = $("#data_for_payment");
                console.log(val);
                //alert(val);
                switch(val){
                    case "select":
                        container.html("<div class='alert alert-danger'>you must select a method</div>");
                    break;
                    
                    case 'bank':
                        container.html("<div class='alert alert-info'>your order would be submitted and we'll get back to you within the next 24 hours but you'll still need to pay the amount to our official account so the product can be processed</div>");
                        var acct = '';
                        acct += "<div class='alert alert-info'>"
                         + "<div>BANK NAME: GTBANK</div>"
                         + "<div>Account NAME: Opadonu Helen</div>"
                         + "<div>Account NUMBER: 0147730687</div>"
                         + "<div>Account TYPE: Saving</div>"
                         + "</div>"
                        ;
                        container.append(acct);
                    break;
                    
                    case 'online':
                        container.html("<div class='alert alert-info'>once clicked on place order, you'll be redirected to a secure payment platform</div>");
                        //convert_to_money(price)
                        
                        //alert(price_orig);
                        
                        var pric = parseInt($("#quantityy").val());
                        pric = pric * price_orig;
                        console.log(pric);
                        //service charge
                        var s_ch = ( (1.5 * pric) / 100 );
                        s_ch = (pric >= 2500) ? (s_ch+=100):(s_ch);
                        
                        s_ch = ( (s_ch > 530) ? (530):(s_ch) );
                        
                        var total = pric + s_ch;
                        var sc = "Service charge cost is gotten from the fee used to perform the transaction and its usually 1.5% of the total price of item, + if item exceed 2,499 naira, then an addition fee of 100 naira is added, so that's the maths....";
                        var msg = '';
                        msg += "<div class='alert alert-success'>"
                         + "<h4 style='font-weight:bold; text-align:center; text-transform:uppercase;'>break down of payment<h4>"
                         + "<table>"
                         + "<thead>"
                         + "<tr>"
                         + "<th>..</th>"
                         + "<th>..</th>"
                         + "</tr>"
                         + "</thead>"
                         + "<tbody>"
                         
                         + "<tr>"
                         + "<td>Price of Product</td>"
                         + "<td>₦"+convert_to_money(pric)+"</td>"
                         + "</tr>"
                         
                         + "<tr>"
                         + "<td>Service Charge <i class='w3-badge w3-small w3-green w3-circle' title='"+sc+"' style='cursor:pointer;'>i</i></td>"
                         + "<td>₦"+convert_to_money(s_ch)+"</td>"
                         + "</tr>"
                         
                         + "<tr style='border-top:1px solid rgba(0,0,0,0.4); padding:5px;'>"
                         + "<td>Total Cost</td>"
                         + "<td>₦"+convert_to_money(total)+"</td>"
                         + "</tr>"
                         
                         + "</tbody>"
                         + "</table>"
                         + "</div>";
                        container.append(msg);
                    break;
                }
            }
        </script>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      