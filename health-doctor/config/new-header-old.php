<div id="header" class="w3-display-container w3-padding-0 w3-margin-0">
                <img class="w3-image w3-img" id='header-image' src="../media/image/resource/index.jpg" style="width: 100%; height:740px;">
                
                <script type="text/javascript">
                    //alert($(window).height());
                    //alert(window.innerHeight);
                    $("#header-image").css("height",window.innerHeight+"px");
                </script>
                
                <div class="w3-display-middle">
                    <div class= "w3-xxxlarge w3-text-grey w3-animate-opacity" style="font-weight: bolder;">
                        <b class="w3-tag w3-grey w3-text-white">F</b>EM<b class="w3-tag w3-grey w3-text-light-grey">Q</b>UEN <small style="font:6px;" class="w3-small">AND Co. INT'L</small>
                        
                    </div>
                    <div id='auto-text' class="w3-normal">    
                        All Your Business Needs
                    </div>
                    
                 </div>
            </div>
            
            <!-- menu -->
            <div>
                <!--for big and middle devices-->
                <ul class="w3-navbar w3-light-grey w3-padding w3-border-bottom w3-hide-small">
                    <li class="w3-left"><a class="w3-disable" style="font-weight: bold;">FEMQUEN AND CO. INT'L</a></li>         
                    <li class="w3-right w3-dropdown-hover">
                        <a class="w3-hover-light-blue" onclick="$('#mm1').toggle()">More <i class="fa fa-caret-down w3-text-black" aria-hidden="true"></i> </a>
                        <div class="w3-dropdown-content" id='mm1' style="position: absolute; right: 0px;">
                            <a href="../greenlife_testimony.php">Greenlife Testimonies</a>
                            <a style="cursor:pointer" onclick="scroll_to_btm()">Message Us</a>
                            <a style="cursor: pointer;" onclick="scroll_to_btm()">Contact Us</a>
                            <a style="cursor: pointer;" href="../about us.php">About Us</a>
                        </div>
                    </li>
                    <li class="w3-right w3-disable"><a href="../greenlife_product.php" style="cursor: pointer;">Greenlife Product</a></li>
                    <li class="w3-right"><a href="../greenlife_marketing_plan.php" class="">Greenlife Marketing Plan</a></li>
                    <li class="w3-right"><a href="../index.php" class="w3-light-green">Home</a></li>
                </ul>
                
                <!--for small devices-->
                <ul class="w3-navbar w3-light-grey w3-padding w3-border-bottom w3-hide-medium w3-hide-large">
                    <li class="">
                        <a>
                            <span class="w3-left"> <i onclick="document.getElementById('small_menu').classList.toggle('w3-hide')" class="fa fa-bars"></i> </span>
                            <span class="w3-right" style="font-weight: bold;">FEMQUEN AND CO. INT'L</span>
                        </a>
                    </li>  
                </ul>
                <div id='small_menu' class="w3-navbar w3-hide w3-grey w3-border-bottom w3-hide-medium w3-hide-large">
                    <div class="w3-text-white w3-hover-white"><a href="../index.php">Home</a></div>
                    
                    <div class="w3-text-white w3-hover-white"><a  href="../greenlife_product.php" style="cursor: pointer;">Greenlife Product</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="../greenlife_marketing_plan.php">Greenlife Marketing Plan</a></div>
                    <div class="w3-text-white w3-hover-white"><a href="../greenlife_testimony.php">Greenlife Testimonies</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor:pointer" onclick="scroll_to_btm()">Message Us</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor: pointer;" onclick="scroll_to_btm()">Contact Us</a></div>
                    <div class="w3-text-white w3-hover-white"><a style="cursor: pointer;" href="../about us.php">ABOUT Us</a></div>
                </div>
            </div>
