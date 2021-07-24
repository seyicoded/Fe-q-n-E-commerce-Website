<?php
    session_start();
    include("../include/connectdb.php");
    $p = new db();
    $con = $p->con();
    
    //$pid = $p->sqlr($con,$p->xssr($_POST['pid']));
    
    function order_code_gen(){
        return "FQP".(rand(0,100) * 2).(rand(0,100) * 2).(rand(0,100) * 2).(rand(0,100) * 2);
    }
    
    function notify_admin_email($full_name,$pname,$price,$phone,$quantity){
        //start
                                     
        $hd = "From:purchase_manager@femquen.com\r\n"; 
        $hd .= "MIME-Version:1.0\r\n";
        $hd .= "Content-type:text/html\r\n";
        
        $ademail = "opadonuseyi01@gmail.com";
        $subj = "$full_name ORDERED $pname $quantity";
        
        $message = "<h1 style='text-align:center;'>PRODUCT ORDERED INFORMATION</h1>";
        $message .= "Dear ADMIN,";
        $message .= "<p>";
        $message .= "$quantity $pname was ordered at $price by $full_name.. phone: $phone";
        $message .= "</p>";
        $message .= "<div style='text-align:right;'>$full_name</div>";
        
        if(mail($ademail,$subj,$message,$hd)){
            
        }else{
            
        }
        
        //stop
    }
    
    if(isset($_POST['add_product_to_purchase'])){
        $pid = $p->sqlr($con,$p->xssr($_POST['pid']));
        $pname = $p->sqlr($con,$p->xssr($_POST['pname']));
        $quantity = $p->sqlr($con,$p->xssr($_POST['quantity']));
        
        $price = $p->sqlr($con,$p->xssr($_POST['price']));
        $price = substr($price,3,strlen($price));
        $price = str_replace(",","",$price);
        $pr = explode(".",$price);
        $price = $pr[0];
        
        $full_name = $p->sqlr($con,$p->xssr($_POST['full_name']));
        $email = $p->sqlr($con,$p->xssr($_POST['email']));
        $phone = $p->sqlr($con,$p->xssr($_POST['phone']));
        $address = $p->sqlr($con,$p->xssr($_POST['address']));
        $mode = $p->sqlr($con,$p->xssr($_POST['mode']));
        
        //echo $pid." ".$pname." ".$quantity." ".$price." ".$full_name." ".$email." ".$phone." ".$address." ".$mode;
        
        //store user data into cookies
        setcookie(md5('signed_data'),base64_encode('true'), time () + (86400 * 365) , '/');
        setcookie(md5('full_name'),base64_encode($full_name), time () + (86400 * 365) , '/');
        setcookie(md5('email'),base64_encode($email), time () + (86400 * 365) , '/');
        setcookie(md5('phone'),base64_encode($phone), time () + (86400 * 365) , '/');
        setcookie(md5('address'),base64_encode($address), time () + (86400 * 365) , '/');
              
        /* from ordered table in db
        db_mode
              0 = bank;
              1 = online;
              
        status     for mode 0
                0 = unpaid
                1 = paid processing
                2 = delivered
                
        status     for mode 1
                0 = unpaid or requery
                1 = paid processing
                2 = delivered
            */
        
        if($mode == "bank"){
            $s['mode'] = "bank";
            
            $db_mode = 0;
            $order_code = order_code_gen();
            $status = 0;
                           
            $sql = "INSERT INTO ordered(p_id,p_name,quantity,price,full_name,phone,email,address,mode,order_code,status) VALUES('$pid','$pname','$quantity','$price','$full_name','$phone','$email','$address','$db_mode','$order_code','$status')";
            if(mysqli_query($con,$sql)){
                $s['done'] = true;
                notify_admin_email($full_name,$pname,$price,$phone,$quantity);
            }else{
                $s['done'] = false;
            }
            
        }elseif($mode == "online"){
            $s['mode'] = "online";
            
            $price = intval($price);
            $s_ch = ( (1.5 * $price) / 100 );
            $sch = ($price >= 2500) ? ($s_ch+=100):($s_ch);
            $price = $price + $sch;
            
            $db_mode = 1;
            $order_code = order_code_gen();
            $status = 0;
            
            $sql = "INSERT INTO ordered(p_id,p_name,quantity,price,full_name,phone,email,address,mode,order_code,status) VALUES('$pid','$pname','$quantity','$price','$full_name','$phone','$email','$address','$db_mode','$order_code','$status')";
            if(mysqli_query($con,$sql)){
                $s['done1'] = true;
                notify_admin_email($full_name,$pname,$price,$phone,$quantity);
                $r = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM ordered WHERE p_id='$pid' AND email='$email' AND order_code='$order_code'"));
                
                //$order_code
                $o_id = $r['o_id'];
                $reference = md5($pname.rand(0,1000).rand(0,1000).rand(0,1000));
                
                $sql = "INSERT INTO transaction(o_id,reference,status) VALUES('$o_id','$reference','$status')";
                if(mysqli_query($con,$sql)){
                    $s['done2'] = true;
                    $s['o_id'] = $o_id;
                    $s['o_code'] = $order_code;
                }else{
                    $s['done2'] = falsee;
                }
                
            }else{
                $s['done1'] = false;
            }
            
            
        }else{
            $s['mode'] = "error";
        }
        
        echo json_encode($s);
    }
?>