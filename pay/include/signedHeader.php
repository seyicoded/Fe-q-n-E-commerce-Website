<style>
    @media only screen and (max-width: 600px){
        #welcome-nav{
            height: auto;
        }
    }
</style>
<nav id="welcome-nav" class="w3-green w3-padding-jumbo">
    <div id='welcome-brand' class="w3-xlarge w3-left">FEMQUEN PAY</div>
    <div class="w3-right w3-center" id='welcome-nav-content-right'>
        <a href="#"><button class="w3-btn w3-green w3-padding">Home</button></a>
        <a href="#"><button class="w3-btn w3-green w3-padding">EXPIRE ON: <?php echo $expire_date;?></button></a>
        <a href="withdraw<?php echo $php;?>"><button class="w3-btn w3-green w3-padding"><?php echo "N".number_format($pu_r['pu_wallet']).'.00';?></button></a>
        <a href="register<?php echo $php;?>?refcode=<?php echo "REFCODE".($pu_r['pu_id']);?>"><button class="w3-btn w3-green w3-padding"><?php echo "REF: "."REFCODE".($pu_r['pu_id']);?></button></a>
        <a href="#">
            <div class="w3-dropdown-hover">
                <button class="w3-btn w3-green w3-padding">MENU</button>
                <div class="w3-dropdown-content w3-border">
                    <?php
                        if($expire_status != 1){
                            //expired or not active
                            //display re-subscribe only
                            ?>
                            <a href="#">Re-Subscribe</a>
                            <?php
                        }else if($expire_status == 1){
                            ?>
                                <a href="withdrawal_history<?php echo $php;?>">View Withdraw History</a>
                                <a href="">aaa</a>
                                <a href="logout<?php echo $php;?>">Logout</a>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </a>
    </div>
</nav>

<br>
<br>
&nbsp;

<div style="display: flex; justify-content: flex-end;">
    <div>
        referral link: 
        <a href="https://pay.femquen.com/register<?php echo $php;?>?refcode=<?php echo "REFCODE".($pu_r['pu_id']);?>" target="_blank">
            https://pay.femquen.com/register<?php echo $php;?>?refcode=<?php echo "REFCODE".($pu_r['pu_id']);?>
        </a>
        &nbsp;
    </div>

</div>