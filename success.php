<?php
    session_start();
    include 'paystack.php';
    include 'autoload.php';
    include("include/connectdba.php");
    $p = new dba();
    $con = $p->con();

    $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
    if(!$reference){
      die('No reference supplied');
    }
    
    // initiate the Library's Paystack Object
    $paystack = new Yabacon\Paystack('sk_test_5223648297076aa3dd6f2fe837745ed13247784e');
    try
    {
      // verify using the library
      $tranx = $paystack->transaction->verify([
        'reference'=>$reference, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }

    if ('success' === $tranx->data->status) {
      // transaction was successful...
      // please check other things like whether you already gave value for this ref
      // if the email matches the customer who owns the product etc
      // Give value
      
      echo "congrats.... payment made on ref.: ".$_GET['reference'];
      
      $refernce = ($p->sqlr($con,$p->xssr($reference)));
      
      
      
      //validate the its not a dupilcate request
      $r2 = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM transaction WHERE reference='$refernce'"));
      if($r2['status'] != "0" || $r2['status'] != 0){
          header("location:payment-success-message.php?ref=$refernce");
      }
      
      
      
      $status = 1;
      $datee = date("Y-m-d h:i:sa");
      
      $sql_q = "UPDATE transaction SET status='$status',date_of_success='$datee' WHERE reference='$refernce'";
      
      if(mysqli_query($con,$sql_q)){
          $r = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM transaction WHERE reference='$refernce'"));
          
          $one = 1;
          $sqll1 = "UPDATE ordered SET status='$one' WHERE o_id='".$r['o_id']."'";
          if(mysqli_query($con,$sqll1)){
              header("location:payment-success-message.php?ref=$refernce");
          }else{
              header("location:payment-error-message.php?ref=$refernce&error111=true");
          }
          
      }else{
          header("location:payment-error-message.php?ref=$refernce&error1=true");
      }
      
      
    }else{
          header("location:payment-error-message.php?ref=$refernce&error2=true");
    }
?>