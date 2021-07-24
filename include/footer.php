<div class="w3-container">
    <i style="font-weight: 300;">Other articles you may like</i>
    <div class="w3-row">
        <?php
            include("connectdb.php");
            $p = new db();
            $con = $p -> con();
            $sql = mysqli_query($con,"SELECT * FROM `health_doctor` ORDER BY RAND() LIMIT 3");
            $num = mysqli_num_rows($sql);
            
            $site_hd_url = "http://".$_SERVER['SERVER_NAME']."/femquenn/health-doctor/";
            for($i=0; $i < $num; $i++){
                $r = mysqli_fetch_assoc($sql);
                ?>
                    <div class="w3-col s12 m3 l3 w3-padding">
                        <div class="w3-card-4 w3-center" style="cursor:pointer;" onclick="window.open('<?php echo $site_hd_url.$r['page_url'];?>');">
                            <img class="w3-responsive" style="width:100%; height: 180px;" src="<?php echo $site_hd_url."image/".$r['image_url'];?>" alt="<?php echo $r['title'];?>">
                            <div class="w3-text-shadow w3-margin" style="text-transform: uppercase;"><?php echo $r['title'];?></div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>

<footer class="w3-container core-color">
    <br>
                <div class="w3-row">
                    <div class="w3-col s12 m6 l6">
                        <div class="footer-container">
                            
                            <form class="w3-card-4" onsubmit="return false">
                                <h3 class="w3-center w3-xxlarge">MESSAGE US</h3>
                                
                                <p>
                                    <input type="text" class="w3-input core-color" placeholder="Enter Your Full Name" name="cname" required>
                                    <label class="w3-label w3-validate">Full Name</label>
                                </p>
                                
                                <p>
                                    <input type="email" class="w3-input core-color" placeholder="Enter Your Email" name="cemail" required>
                                    <label class="w3-label w3-validate">Email</label>
                                </p>
                                
                                <p>
                                    <input type="tel" class="w3-input core-color" placeholder="Enter Your Telephone Number" name="ctel" required>
                                    <label class="w3-label w3-validate">Telephone</label>
                                </p>
                                
                                <p>
                                    <textarea class="w3-input core-color" style="height: 160px;" placeholder="Enter Your Message HERE" name="cmessage" required></textarea>
                                    <label class="w3-label w3-validate">Message</label>
                                </p>
                                
                                <p>
                                    <div id='noti-6' class="w3-center"></div>
                                    <br>
                                    <input type="button" class="w3-btn-block w3-right w3-blue" onclick="messageus()" style="font-weight: bold;" value="SUBMIT">
                                    <br>                                    
                                </p>
                                
                            </form>
                            
                        </div>
                    </div>
                    
                    <div class="w3-col s12 m6 l6">
                        <div class="footer-container">
                            
                            <div class="w3-card-4">
                                 <h3 class="w3-center w3-xxlarge">CONTACT US</h3>
                                 
                                 <div class="w3-card-4 w3-margin">
                                    <h5 class="adr_head">Head Address</h5>
                                    <p class="adr_content">Plot B Shop 20, Kuje Market Plaza, Abuja.</p>
                                    <br />
                                    <h5 class="adr_head">Branch Address</h5>
                                    <p class="adr_content">Nigerian Correctional Hqtr's Mammy Mkt, Airport Abuja.</p>
                                 </div>
                                 
                                 <div class="w3-card-4 w3-margin">
                                    <h5 class="adr_head">Email Address</h5>
                                    <p class="adr_content">
                                        <a href="mailto:info@femquen.com">info@femquen.com</a> 
                                    </p>
                                 </div>
                                 
                                 <div class="w3-card-4 w3-margin">
                                    <h5 class="adr_head">Phone / SMS</h5>
                                    <p class="adr_content">
                                        <a target="_blank" href="tel:+2349019596506">+2349019596506</a>, &nbsp; <a target="_blank" href="+2349070739750">+2349070739750</a>, &nbsp; <a target="_blank" href="+2349023112671">+2349023112671</a>
                                    </p>
                                 </div>
                                 
                                 <div class="w3-card-4 w3-margin">
                                    <h5 class="adr_head">Whatsapp</h5>
                                    <p class="adr_content">
                                        <a href="intent://send/+2348075350985#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end">CLICK HERE IF YOUR USING A PHONE TO LOAD THIS PAGE</a> 
                                        +2348075350985, &nbsp; +2348097104124, &nbsp; +2349023112671
                                    </p>
                                 </div>
                                 
                                 <br>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="w3-center w3-text-sand w3-margin" style="font-weight:bold; opacity:0.7;">
                    Developed and Powered by <a target="_blank" style="text-decoration: none; color: #000000;" href="http://www.scti.tk">SCTI</a> <br>
                    &copy;opyright <?php echo date("Y");?>, All Right Reserved.
                 </div>
            </footer>