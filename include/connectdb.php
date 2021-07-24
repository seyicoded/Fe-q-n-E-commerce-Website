<?php
    class db{
        public function con(){
            return mysqli_connect("localhost","root","","femquen");
        } 
       
        public function php(){
            return ".php";
        }

       public function xssr($data){
           return htmlspecialchars(trim($data));
       }
       
       public function xssrs($data){
           return strip_tags(trim($data));
       }
       
       public function validate_login_state($cid,$con){
           $r1 = mysqli_query($con,"SELECT * FROM client_info WHERE c_id='$cid'");
           if(mysqli_num_rows($r1) > 0 ){
               $s['state'] = true;
               $rdt = mysqli_fetch_assoc($r1);
               $s['rdt'] = $rdt;
           }else{
               $s['state'] = false;
           }
           
           return json_encode($s);
       }
       
       public function xssrcontent($data){
           return strip_tags(trim($data),"<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<p>,<span>,<div>,<img>,<li>,<ul>,<ol>,<dd>,<dl>,<dt>,<table>,<tbody>,<thead>,<tfoot>,<tr>,<th>,<td>,<style>, <b>,<strong>,<i>,<em>,<sub>,<sup>,<u>,<skroke>,<a>,<s>");
       }
       
       public function sqlr($con,$data){
          return mysqli_real_escape_string($con,$data) ;
       }
       /*
       *what to encrypt
       * reversable information and the key should be the generated cap so in that case 'cap & username' would not be encrypted and password encryption will be
       * irreversible
       *  
       */
       public function nja_encrypt($str,$key){
            return base64_encode($key.$str.$key);
        }
        public function nja_decrypt($str,$key){
            $str = base64_decode($str);
            $h = substr($str,strlen($key),strlen($str));
            $r = substr($h,0, (intval(strlen($h)) - intval(strlen($key))));
            
            return $r;
            //return trim($str,$key);
        }
    }
        
        function customError($errno, $errstr) {
          error_log("Error: [$errno] $errstr",1,
          "opadonuseyi01@gmail.com","From: site@9jahoodz.com");
        }

        //set error handler
        //set_error_handler("customError",E_USER_WARNING);
        //set_error_handler("customError",E_USER_ERROR);
        //set_error_handler("customError",E_USER_NOTICE);
?>