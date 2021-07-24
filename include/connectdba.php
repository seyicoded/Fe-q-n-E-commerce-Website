<?php
    class dba{
       public function con(){
           return mysqli_connect("localhost","root","","femquen");
       } 

       public function php(){
            return ".php";
        }

        public function secret_key(){
            return "sk_test_5223648297076aa3dd6f2fe837745ed13247784e";
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
           return strip_tags(trim($data),"<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<p>,<span>,<div>,<img>,<li>,<ul>,<ol>,<dd>,<dl>,<dt>,<table>,<tbody>,<thead>,<tfoot>,<tr>,<th>,<td>,<style>, <b>,<strong>,<i>,<em>,<sub>,<sup>,<u>,<skroke>,<a>,<s>,<u>,<br>,<hr>,<blockquote>");
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
    
    
    function get_post_time($old){
            //get now time info
            $now_y = date("Y");
            $now_m = date("m");
            $now_d = date("d");
            $now_H = date("H");
            $now_i = date("i");
            $now_s = date("s");
            
            //get given time info
            $given_y = date("Y",strtotime($old));
            $given_m = date("m",strtotime($old));
            $given_d = date("d",strtotime($old));
            $given_H = date("H",strtotime($old));
            $given_i = date("i",strtotime($old));
            $given_s = date("s",strtotime($old));
            
            if(intval($given_y) != intval($now_y)){
                return (intval($now_y) - intval($given_y) . " yrs ago")."";
            }
            
            if(intval($given_m) != intval($now_m)){
                return (intval($now_m) - intval($given_m) . " months ago")."";   
            }
            
            if(intval($given_d) != intval($now_d)){
                return (intval($now_d) - intval($given_d)  . " days ago")."";   
            } 
            
            if(intval($given_H) != intval($now_H)){
                return (intval($now_H) - intval($given_H)  . " hours ago")."";   
            }else{
                return " moment ago";
            }
            
            
        }
        
        function get_file_url_path(){
            $a ="http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
            $b = split("/",$a);
            
            $l = count($b);
            $filepath = "";
                
            for($i = 0; $i < $l-1 ;$i++){
                $filepath .= $b[$i]."/";
            }    
            return $filepath; 
        }
            
?>