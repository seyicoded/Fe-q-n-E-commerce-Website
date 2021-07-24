<?php
    include 'paystack.php';
    include 'autoload.php';
    
    session_start();
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();
    
    //o_id--o_code
    
    //view_all_payment.php
    
    if(isset($_GET['o_id'])){
        $o_id = ($p->sqlr($con,$p->xssr($_GET['o_id'])));
        $o_code = ($p->sqlr($con,$p->xssr($_GET['o_code'])));
        
        $r1 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM transaction WHERE o_id='$o_id'"));
        $r2 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM ordered WHERE o_id='$o_id'"));
        
        $p1 = ($r2['price']);    
        $p1 = str_ireplace(",","",$p1);
        $amount = round($p1)."00";
                                               
        
        $email = $r2['email'];
        $reference = md5($r1['reference'].rand(0,1000).rand(0,1000).rand(0,1000));
        
        //echo $amount."--".$email."--".$reference;
        //exit();
        
        if(mysqli_query($con,"UPDATE transaction SET reference='$reference' WHERE o_id='$o_id'")){
            
        }else{
            header("location:view-purchase.php?e=2");
        }
        
        
        $recipients = "opadonuseyi01@gmail.com,$email";
            $subject = 'Invoice Information for payment';
            $message = '<b style="color:red;">Please note that this is not a confirmation of payment but just an invoice incase of any issue, it will be require of you</b>';
            $message .= " <br>
                    <table>
                        <tbody>
                            <tr>
                                <td>Order ID</td>
                                <td>$o_code</td>
                            </tr>
                            
                            <tr>
                                <td>Amount</td>
                                <td>$amount</td>
                            </tr>
                            
                            <tr>
                                <td>payer email</td>
                                <td>$email</td>
                            </tr>
                            
                            <tr>
                                <td>Reference No.</td>
                                <td>$reference</td>
                            </tr>
                            
                        </tbody>
                    </table>
            ";
            
            $from = "notifier@femquen.com";
            
           $headers = "MIME-Version: 1.0\nContent-type: text/html; charset=utf-8\nFrom: {$from}\nDate: ".date(DATE_RFC2822)."\r\nX-Mailer: PHP/". phpversion(); 
            
            if(mail($recipients, $subject, $message, $headers)){
                //starting
                
                $paystack = new Yabacon\Paystack("sk_test_5223648297076aa3dd6f2fe837745ed13247784e");
                
                try
                {
                  $tranx = $paystack->transaction->initialize([
                    'amount'=>$amount,       // in kobo
                    'email'=>$email,         // unique to customers
                    'reference'=>$reference, // unique to transactions
                  ]);
                } catch(\Yabacon\Paystack\Exception\ApiException $e){
                  print_r($e->getResponseObject());
                  die($e->getMessage());
                }
                // store transaction reference so we can query in case user never comes back
                // perhaps due to network issue
                
                //its bring error when trying to save
                //save_last_transaction_reference($tranx->data->reference);

                // redirect to page so User can pay
                header('Location: ' . $tranx->data->authorization_url);
                
                
                //stopping
            }else{
                header("location:view-purchase.php?e=3");
            }
         
        
        //echo $amount."--".$email;
        
        
        
    }else{
        header("location:view-purchase.php?e=1");
    }
    
    
    //$amount = 1500900;
    //$email = "opadonuseyi01z".rand(0,100000)."@gmail.com";
    //$reference = md5("test1".rand(0,1000).rand(0,100).rand(0.100).rand(0,100));
    //$reference = 12341;
    
    /*
    
    $paystack = new Yabacon\Paystack("sk_test_ccd352beab7681391e8921670486abd0217f04f8");
    
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$amount,       // in kobo
        'email'=>$email,         // unique to customers
        'reference'=>$reference, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
    // store transaction reference so we can query in case user never comes back
    // perhaps due to network issue
    
    //its bring error when trying to save
    //save_last_transaction_reference($tranx->data->reference);

    // redirect to page so User can pay
    header('Location: ' . $tranx->data->authorization_url);
    
    */
    
?>