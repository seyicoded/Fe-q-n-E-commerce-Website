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
    
    if(isset($_GET['mode'])){
        $pwid = $p->sqlr($con,$p->xssr($_GET['pwid']));
        if( $_GET['mode'] == "approve" ){
            //approved
            mysqli_query($con, "UPDATE pay_wthdrawal SET status=1 WHERE pw_id='$pwid'");
        }else{
            //decline && refund to wallet also
            mysqli_query($con, "UPDATE pay_wthdrawal SET status=2 WHERE pw_id='$pwid'");
            //refund nw
            $dt = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_wthdrawal WHERE pw_id='$pwid'"));
            $amount_requested = $dt['amount'];
            $amount_requested = intval($amount_requested);
            $pu_id = $dt['pu_id'];
            $user_wallet = (mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$pu_id'")))['pu_wallet'];
            $user_wallet = intval($user_wallet);

            $new_wallet_amount = $user_wallet + $amount_requested;
            mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$new_wallet_amount' WHERE pu_id='$pu_id'");
        }

        header('Location: pay_withdrawal_list.php');
    }
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
            
        <div>
            <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ACCOUNT NAME</th>
                        <th>BANK NAME</th>
                        <th>BANK TYPE</th>
                        <th>ACCOUNT NUMBER</th>
                        <th>AMOUNT</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $dt = mysqli_query($con,"SELECT * FROM pay_wthdrawal AS a INNER JOIN pay_users AS b ON a.pu_id=b.pu_id ORDER BY a.pw_id DESC, a.status ASC");
                    while($r = mysqli_fetch_assoc($dt)){
                        $status = intval($r['status']);
                        $status = ( ($status == 0) ? 'processing' : (($status ==1) ? "PAID":"Error, refunded to wallet") );
                        ?>
                            <tr>  
                                <td><?php echo $r['pw_id']?></td>
                                <td><?php echo $r['pu_fullname']?></td>
                                <td><?php echo $r['pu_email']?></td>
                                <td><?php echo $r['account_name']?></td>
                                <td><?php echo $r['bank_name']?></td>
                                <td><?php echo $r['bank_type']?></td>
                                <td><?php echo $r['acount_number']?></td>
                                <td><?php echo "N ".number_format($r['amount'])?></td>
                                <td><?php echo date("Y-m-d @ H:i a",strtotime($r['date']))?></td>
                                <td><?php echo $status?></td>
                                <?php
                                    if( intval($r['status']) > 0 ){
                                        ?>
                                            <td><a class="w3-btn w3-green w3-text-white w3-round disabled w3-disabled" disabled>APPROVED</a></td>
                                            <td><a class="w3-btn w3-green w3-text-white w3-round disabled w3-disabled" disabled>DECLINED</a></td>
                                        <?php
                                    }else{
                                        ?>
                                            <td><a href="pay_withdrawal_list.php?mode=approve&pwid=<?php echo $r['pw_id'];?>" class="w3-btn w3-green w3-text-white w3-round">APPROVED</a></td>
                                            <td><a href="pay_withdrawal_list.php?mode=decline&pwid=<?php echo $r['pw_id'];?>" class="w3-btn w3-green w3-text-white w3-round">DECLINED</a></td>
                                        <?php
                                    }
                                ?>
                            </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>    
                        
        </div>
    </body>
</html>
