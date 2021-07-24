<?php
    session_start();
    include("../include/connectdb.php");
    $p = new db();
    $con = $p->con();
    
    function cs($data){
        return strip_tags(trim($data),"<br>,<b>,<i>,<em>,<style>,<strong>,<hr>,<p>,<div>,<span><form><input><textarea><button>");
    }
    
    if(isset($_POST['messageus'])){     
        $cname = cs($_POST['name']);
        $cemail = cs($_POST['email']);
        $ctel = cs($_POST['tel']);
        $cmsg = cs($_POST['message']);      
        
        $email = "mosesopadonu@yahoo.com , opadonuseyi01@gmail.com , opadonuwumi@gmail.com";
        
        $hd = "From:femquen@customer\r\n"; 
        $hd .= "MIME-Version:1.0\r\n";
        $hd .= "Content-type:text/html\r\n"; 
        $hd .= "CC:opadonumoses@yahoo.com\r\n"; 
        $hd .= "BCC:opadonuwumi@gmail.com\r\n";
        
        $subj = "Message to Femquen FROM $cname @FEMQUEN Contact Us";
        
        $message = "<h1 style='text-align:center;'>Message FROM $cname @ $cemail</h1>";
        $message .= "Dear FEMQUEN, (customer phone: $ctel) ";
        $message .= "<p>";
        $message .= $cmsg;
        $message .= "</p>";
        $message .= "<div style='text-align:right;'>$cname @ $cemail</div>";
        
        if(mail($email,$subj,$message,$hd)){
            echo "Request Sent, You will Get A Call From Our Marketting Director As Soon As Possible. If you don't Get any contact from us within the next 24hours, please {call,sms,whatsapp} <a target='_blank' href='tel:+2348075350985'>+2348075350985</a>.. Thank You.";
        }else{
            echo "You will Get A Call From Our Marketting Director As Soon As Possible. If you don't Get any contact from us within the next 24hours, please {call,sms,whatsapp} <a target='_blank' href='tel:+2348075350985'>+2348075350985</a>.. Thank You.";
        }
    }
?>