<?php
    session_start();
    include("../include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    $php = $p->php();
    include("include/validateUser.php");

    if(!isset($_GET['p_id'])){
        echo "false 0";
        return "false 0";
    }

    $user_id =  $puid;
    $p_id =  intval($p->sqlr($con, $p->xssr($_GET['p_id'])));

    // check if it's a sponsor post
    if( (mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM post WHERE p_type='sponsor' AND p_id='$p_id'"))) == 0 ){
        echo "false 1";
        return "false 1";
    }else{
        // check if it's today
        $dtt_date = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM post WHERE p_type='sponsor' AND p_id='$p_id'"))['date'];

        if( (date("Y-m-d", strtotime('today'))) != (date("Y-m-d", strtotime($dtt_date))) ){
            echo "false 11";
            return "false 11";
        }
    }

    // check if user has already been paid
    if( (mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_read_post_user_reward_logger WHERE user_id='$user_id' AND p_id='$p_id'"))) != 0 ){
        echo "false 2";
        return "false 2";
    }

    // credit user 4% of his total package price
    // get user detail
    $package_id = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM subscription_linker WHERE puser_id='$user_id'"))['package_id'];
    $package_amount = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_package WHERE p_id='$package_id'"))['p_price'];

    $package_amount = intval($package_amount);

    $amount_to_add_4_pect = floor( (4 * $package_amount) / 100 );

    // get user wallet
    $user_wallet = intval(mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pay_users WHERE pu_id='$user_id'"))['pu_wallet']);

    $new_user_wallet = intval($amount_to_add_4_pect) + $user_wallet;

    // update wallet amount
    if( mysqli_query($con, "UPDATE pay_users SET pu_wallet = '$new_user_wallet' WHERE pu_id='$user_id'") ){
        if(mysqli_query($con, "INSERT INTO pay_read_post_user_reward_logger(user_id, p_id, amount) VALUES('$user_id', '$p_id', '$amount_to_add_4_pect')")){
            echo "true";
            return true;
        }else{
            echo "false 4";
            return 'false 4';
        }
    }else{
        echo "false 3";
        return 'false 3';
    }


?>