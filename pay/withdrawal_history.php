<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");
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
</head>
<body>

    <?php
        include("include/signedHeader.php");
    ?>

    <div id="content">
        <div class="w3-margin">
        <table class="w3-card-4 w3-table w3-bordered w3-striped w3-border w3-hoverable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account Number</th>
                    <th>Account Name</th>
                    <th>Bank Name</th>
                    <th>Bank Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $puid = $pu_r['pu_id'];
                    $data = mysqli_query($con,"SELECT * FROM pay_wthdrawal WHERE pu_id='$puid' ORDER BY pw_id DESC");
                    while($r = mysqli_fetch_assoc($data)){
                        $status = intval($r['status']);
                        $status = ( ($status == 0) ? 'processing' : (($status ==1) ? "PAID":"Error, refunded to wallet") );
                        ?>
                            <tr>
                                <td><?php echo $r['pw_id'];?></td>
                                <td><?php echo $r['acount_number'];?></td>
                                <td><?php echo $r['account_name'];?></td>
                                <td><?php echo $r['bank_name'];?></td>
                                <td><?php echo $r['bank_type'];?></td>
                                <td><?php echo "N".number_format($r['amount']);?></td>
                                <td><?php echo $status;?></td>
                                <td><?php echo date("Y-m-d",strtotime($r['date']));?></td>
                            </tr>
                        <?php
                    }

                ?>
            </tbody>
        </table>
        </div>
    </div>

    <?php
        include('../include/footer.php');
    ?>
</body>
</html>
