<div id='header-container-main'>
        
        
        <?php
            //print_r($_SERVER);
            if( ($_SERVER['PHP_SELF'] == "/femquenn/index.php") || ($_SERVER['PHP_SELF'] == "index.php") ($_SERVER['PHP_SELF'] == "/") ){
                ?>
                    
                    <div id="header" class="w3-display-container w3-padding-0 w3-margin-0">
                            <img class="w3-image w3-img" src="media/image/resource/index.jpg" id='header-big-image' style="width: 100%; height:740px;">
                            <div class="w3-display-middle">
                            
                                <div class="w3-hide-small">
                            
                                    <div class= "w3-xxxlarge w3-text-grey w3-animate-opacity" style="font-weight: bolder;">
                                        <b class="w3-tag w3-grey w3-text-white">F</b>EM<b class="w3-tag w3-grey w3-text-light-grey">Q</b>UEN <small style="font:6px;" class="w3-small">AND Co. INT'L</small>
                                        
                                    </div>
                                    <div id='auto-text' class="w3-xlarge auto-text w3-margin wow swing"  data-wow-duration="3500ms" data-wow-delay="0ms">    
                                        All Your Business Needs
                                    </div>
                                
                                </div>
                                
                                <div class="w3-hide-medium w3-hide-large w3-show-small">
                            
                                    <div class= "w3-xxlarge w3-text-grey w3-animate-opacity" style="font-weight: bolder;">
                                        <b class="w3-tag w3-grey w3-text-white">F</b>EM<b class="w3-tag w3-grey w3-text-light-grey">Q</b>UEN <small style="font:6px;" class="w3-small">AND Co. INT'L</small>
                                        
                                    </div>
                                    <div id='auto-text' style="" class="w3-small auto-text w3-margin wow swing" data-wow-duration="3500ms" data-wow-delay="0ms">    
                                        All Your Business Needs
                                    </div>
                                
                                </div>
                                
                             </div>
                        </div>
                        
                        <script type="text/javascript">
                            //alert($(window).height());
                            //alert(window.innerHeight);
                            //alert(window.innerHeight);
                            $("#header-big-image").css("height",window.innerHeight+"px");
                            
                            //$("#header-big-image").height();
                        </script>
                <?php
            }else{
                ?>
                    <div id='header-for-other-page'>
                        
                        <!--for big and medium-->
                        <div class="w3-show-medium w3-show-large w3-hide-small w3-green" style="width: 100%; height: 100%;">
                        
                            <div style="display: inline-block; height: 100%;">
                                <img src="media/image/icon/icon.png" style="height: 80%; width: 120px; margin: 10% ; margin-left:20% ;" id="main-no-index-icon">
                            </div>     
                            
                            <div style="display: inline-block;  position: absolute; margin-left: 3%; height: 100%; top:0px;">
                                <h1 style="font-weight: bolder; margin-top:9%;"><b style="color: #F0F0F0;">Femquen</b> <b style="color: #D0D0D0;">International</b></h1>
                            </div>
                                                                            
                            <div id='auto-text-for-other-page' class=" w3-xlarge">    
                                <span class="auto-text" style="display: inline;"> All Your Business Needs </span>
                            </div>
                        </div>
                        
                        <!--for small-->
                        <div class="w3-hide-medium w3-hide-large w3-show-small w3-green" style="width: 100%; height: 100%;">
                        
                            <div style="display: inline-block; height: 100%; width: 100%;">
                                <img src="media/image/icon/icon.png" id="main-no-index-icon-small">
                            </div>     
                            
                            <div id='auto-text-for-other-page' style="" class="w3-large">    
                                <span class="auto-text"> All Your Business Needs </span>
                            </div>
                        </div>
                        
                    </div>
                <?php
            }
        ?>
            
            
            <style type="text/css">
                .slow-down{
                    transition:all 3s !important;
                    -webkit-transition:all 3s !important;
                }
                .social{
                    cursor: pointer;
                    margin: 15px 7px 4px 15px;
                }
                .fb:hover{
                    color: blue;
                }
                .whatsapp:hover{
                    color: green;
                }
                .instagram:hover{
                    color: pink;
                }

                @media screen and (max-width: 588px){
                    .social-container li{
                        display: inline-block;
                        float: right;
                    }
                }
            </style>

            <div class="w3-container w3-margin-0 w3-padding-4 w3-green">
                <ul class="w3-navbar social-container">
                    <div class="w3-right">
                        <li> <i class="fa fa-facebook social fb" onclick=" window.open('https://facebook.com/') "></i> </li>
                        <li> <i class="fa fa-whatsapp social whatsapp" onclick=" window.open('https://whatsapp.com/') "></i> </li>
                        <li> <i class="fa fa-instagram social instagram" onclick=" window.open('https://instagram.com/') "></i> </li>
                    </div>
                </ul>
            </div>
            <!-- menu -->
            <div id='nav-menu'>
                <!--for big and middle devices-->
                <ul class="w3-navbar core-color w3-padding w3-border-bottom w3-hide-small" id='menu-big-cover' style="padding:0px !important ;">
                    <li class="w3-left" id='title'><a class="w3-disable" style="font-weight: bolder;">FEMQUEN AND CO. INT'L</a></li>         
                    <li class="w3-right w3-dropdown-hover">
                        <a class="w3-hover-green" onclick="$('#mm1').toggle()">More <i class="fa fa-caret-down w3-text-white" aria-hidden="true"></i> </a>
                        <div class="w3-dropdown-content slow-down" id='mm1' style="position: absolute; right: 0px;">
                            
                            <?php
                                if(isset($_COOKIE[md5('signed_data')])){
                                    ?>
                                        <a  href="view-purchase.php" style="cursor: pointer;">VIEW PURCHASE(PURCHASE ACCESS)</a>
                                    <?php
                                }else{
                                    ?>
                                        <a href="signin.php">SIGN IN (PURCHASE ACCESS)</a>
                                    <?php
                                }
                                ?>
                            
                            
                            
                            <a href="health-doctor/">View All Articles</a>
                            <a href="gtps.php">Greenlife Treasure Purse</a>
                            <a href="greenlife_testimony.php">Greenlife Testimonies</a>
                            <a style="cursor:pointer" onclick="scroll_to_btm()">Message Us</a>
                            <a style="cursor: pointer;" onclick="scroll_to_btm()">Contact Us</a>
                            <a style="cursor: pointer;" href="about us.php">About Us</a>
                        </div>
                    </li>
                    <li class="w3-right w3-disable"><a href="greenlife-products.php" style="cursor: pointer;">Greenlife Product</a></li>
                    <li class="w3-right"><a href="greenlife_c_plan.php" class="">Greenlife COMPENSATION Plan</a></li>
                    <li class="w3-right"><a href="index.php" style="">Home</a></li>
                </ul>
                
                <!--for small devices-->
                <ul class="w3-navbar core-color w3-padding w3-border-bottom w3-hide-medium w3-hide-large" id='menu-small-cover'>
                    <li class="" id='title'>
                        <a class="w3-padding-0">
                            <span class="w3-left">
                                <i title="menu" onclick="document.getElementById('small_menu').classList.toggle('w3-hide');document.getElementById('small_menu').classList.toggle('w3-animate-zoom');" style="cursor: pointer;" class="fa fa-bars"></i>
                                
                            </span>
                            <span class="w3-right" style="font-weight: bold;" title="homepage" onclick="window.location.href='index.php'">
                                <b style=" cursor: pointer; display: inline; position: relative;">
                                    <span style="cursor: pointer;">FEMQUEN AND CO. INT'L</span>
                                    <i class="fa fa-home" style="cursor: pointer; font-size: 20px; padding-left: 2px;"></i>
                                </b>
                                
                            </span>
                        </a>
                    </li>  
                </ul>
                <div id='small_menu' class="w3-navbar w3-hide w3-border-bottom w3-hide-medium w3-hide-large w3-card-16" style="z-index:9999999999;">
                    <div class="w3-text-white w3-hover-white"><a href="index.php">Home</a></div>
                    
                    <?php
                    if(isset($_COOKIE[md5('signed_data')])){
                            ?>
                                <div class="w3-text-white w3-hover-white"><a  href="view-purchase.php" style="cursor: pointer;">VIEW PURCHASE(PURCHASE ACCESS)</a></div>
                            <?php
                    }else{
                        ?>
                            <div class="w3-text-white w3-hover-white"><a  href="signin.php" style="cursor: pointer;">SIGN IN (PURCHASE ACCESS)</a></div>
                        <?php
                    }
                    ?>
                    
                    <div class="w3-text-white w3-hover-white"><a  href="greenlife-products.php" style="cursor: pointer;">Greenlife Product</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="greenlife_c_plan.php">Greenlife COMPENSATION Plan</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="gtps.php">Greenlife Treasure Purse</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="health-doctor/">View All Articles</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="greenlife_testimony.php">Greenlife Testimonies</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor:pointer" onclick="scroll_to_btm()">Message Us</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor: pointer;" onclick="scroll_to_btm()">Contact Us</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor: pointer;" href="about us.php">ABOUT Us</a></div>
                </div>
            </div>
            
</div>

<script type="text/javascript">
    window.onscroll = function(){
        //nav-menu
         var header_height = ( $("#header-container-main").height() - $("#nav-menu").height() );
         var pos_of_bar = ( (document.documentElement || document.body).scrollTop );
         
         if(pos_of_bar >= header_height){
             //float
             $("#nav-menu").css({"position":"fixed","top":"0px","width":"100%","z-index":"9999"});
         }else{
             //normal
             $("#nav-menu").css({"position":"relative","top":"0px","width":"100%","z-index":"9999"});
         }
    }
</script>