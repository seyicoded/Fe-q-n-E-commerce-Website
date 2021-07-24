<?php
    session_start();
    include("../include/connectdb.php");
    $p = new db();
    $con = $p->con();
    
    if(isset($_POST['purchase'])){
        //$pid = $p->sqlr($con,$p->xssr($_POST['pid']));
        $pname = $p->sqlr($con,$p->xssr($_POST['p_name']));
        $pprice = $p->sqlr($con,$p->xssr($_POST['p_price']));
        $pquantity = $p->sqlr($con,$p->xssr($_POST['p_quantity']));
        $uname = $p->sqlr($con,$p->xssr($_POST['u_name']));
        $uphone = $p->sqlr($con,$p->xssr($_POST['u_phone']));
        $uemail = $p->sqlr($con,$p->xssr($_POST['u_email']));
        $uaddr = $p->sqlr($con,$p->xssr($_POST['u_address']));
        
        //echo "$pname $pprice $pquantity $uname $uphone $uemail $uaddr";
                                  
        
        $email = "mosesopadonu@yahoo.com , opadonuseyi01@gmail.com , opadonuwumi@gmail.com";
        
        $hd = "From:femquen@customer\r\n"; 
        $hd .= "MIME-Version:1.0\r\n";
        $hd .= "Content-type:text/html\r\n"; 
        $hd .= "CC:opadonumoses@yahoo.com\r\n"; 
        $hd .= "BCC:opadonuwumi@gmail.com\r\n";     
        
        $subj = "Purchase of $pname by $uname";
        
        $message = "<h1 style='text-align:center;'>A Purchase For $pname Has been Required</h1>";
        $message .= "information is below, <br>";
        $message .= "<p>";
        $message .= "
                <table style='width:100%;'>
                
                    <thead>
                        <tr>
                            <td>Info</td>
                            <td>Data</td>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                        <tr>
                            <td>Product Name</td>
                            <td>$pname</td>
                        </tr>
                        
                        <tr>
                            <td>Product Price</td>
                            <td>$pprice</td>
                        </tr>
                        
                        <tr>
                            <td>Product Quantity</td>
                            <td>$pquantity</td>
                        </tr>
                        
                        <tr>
                            <td>Customer Name</td>
                            <td>$uname</td>
                        </tr>
                        
                        <tr>
                            <td>Customer Phone</td>
                            <td><a target='_blank' href='tel:$uphone'>$uphone</a></td>
                        </tr>
                        
                        <tr>
                            <td>Customer Email</td>
                            <td>$uemail</td>
                        </tr>
                        
                        <tr>
                            <td>Customer Address</td>
                            <td>$uaddr</td>
                        </tr>
                        
                    </tbody>
                
                </table>
                
                <br>
                <br>
                <br>
        ";
        $message .= "</p>";
        $message .= "<div style='color:red;'>Please Call Customer and continue Purchase</div> <br>";
        
        if(mail($email,$subj,$message,$hd)){
            echo "Purchase Sent.. You will Get A Call From Our Marketting Director As Soon As Possible. If you don't Get any contact from us within the next 24hours, please {                  call,sms,whatsapp} <a target='_blank' href='tel:+2348075350985'>+2348075350985</a> or 
            <a target='_blank' href='tel:+2349014665886'>+2349014665886</a>, &nbsp; <a target='_blank' href='+2349070739750'>+2349070739750</a>
            .. Thank You.";
        }else{
            echo "Can't place request now but you can get it still, Just {call,sms,whatsapp} <a target='_blank' href='tel:+2348075350985'>+2348075350985</a> or
            <a target='_blank' href='tel:+2349014665886'>+2349014665886</a>, &nbsp; <a target='_blank' href='+2349070739750'>+2349070739750</a>
            .. Thank You.";
        }
        
        
    }
    
    if(isset($_POST['view_more'])){
        $ln = $p->sqlr($con,$p->xssr( base64_decode($_POST['ln']) ));
        $wh =  " WHERE p_id > $ln ";
        $q1 = ((( base64_decode($_POST['sl1']) )));
        $q2 = ((( base64_decode($_POST['sl2']) )));
        
        $q = $q1.$wh.$q2;
        
        //echo $query_text;
        $sql = mysqli_query($con,$q);
        echo mysqli_error($con);
        $num = mysqli_num_rows($sql);
        if($num ==0){
            $sa['exist'] = false;
        }else{
            $sa['exist'] = true;
            $last_id_loaded = 0;
            $msg = "";
            for($i = 1 ; $i <= $num ; $i++){
                                        $r = mysqli_fetch_assoc($sql);
                                                
                                        $p = ($i >= 5) ? "1": $i;
                                        $ii = ((intval($p) * 2) + 5) . "00";
                                        
                                        $random_num = rand(100,1000)+rand(100,100)+(rand(100,100) * rand(2,20)) + (rand(1,2000) * 2);;
                                        
                                        
                                        $msg .= '<div class="w3-col s12 m6 l3 wow fadeInDown" data-wow-duration="1200ms" data-wow-delay="'.$ii.'ms">' ;
                                        $msg .= '<div class="w3-card-4 w3-round" style="margin: 6%;">' ;
                                        $msg .= '<div id="image-box">';
                                        $msg .= '<div id="loader-'.$random_num.'" style="height: 300px; width: 100%; position: relative;">';
                                        $msg .= '<img src="media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">';
                                        $msg .= '</div>';
                                        $msg .= '<img id="image-'.$random_num.'" onload="show_image(\''.$random_num.'\')" src="media/image/product/'.$r['p_image'].'" alt="'.$r['p_name'].'" class="w3-round" style="width: 100%; height: 300px; display: none;">' ;
                                        $msg .= "</div>";
                                        $msg .= '<div id="content-box">';
                                        $msg .= '<h4 class="w3-center" style="padding:8% 0px; font-weight: 900">'.$r['p_name'].'</h4>';
                                        $msg .= '<div class="w3-card-4 w3-margin w3-padding content-box-inner">'.substr($r['p_desc'],0,270)."........".'</div>' ;
                                        $msg .= '<div style="width: 100%; padding: 2%;">';
                                        $msg .= '<a href="product.php?mode=info&pid='.$r['p_id'].'&p_name='.$r['p_name'].'"><button class="w3-card-4 w3-btn w3-blue w3-round" style=" font-weight: bold; display: inline-block; width: 48%; margin-right:2%; ">DISCOVER</button></a>';
                                        $msg .= '<a href="product.php?mode=get&pid='.$r['p_id'].'&p_name='.$r['p_name'].'"><button class="w3-card-4 w3-btn w3-green w3-round" style=" font-weight: bold; display: inline-block; width: 48%;">BUY NOW</button></a>';
                                        $msg .= "</div><br></div></div></div>";
                                        
                                        
                                        $last_id_loaded = $r['p_id'];
            }
            
            //$msg= '';
            //$sa['msg'] = base64_encode($msg);
            $sa['msg'] = ($msg);
            $sa['ln'] = base64_encode($last_id_loaded);
            $sa['sl1'] = base64_encode($q1);
            $sa['sl2'] = base64_encode($q2);
        }
        
        try{
            echo json_encode($sa);
            //echo '{"exist":'.$sa['exist'].',"msg":'.$msg.',"ln":'.$sa['ln'].',"sql_txt":'.$sa['sql_txt'].'}';
        }
        catch(Exception $e){
            echo $e;
        }
        
    }
    
    if(isset($_POST['check_search'])){
        $txt = $p->sqlr($con,$p->xssr($_POST['txt']));
        
        $sql = mysqli_query($con,"SELECT * FROM product WHERE p_name LIKE '%$txt%' || p_desc LIKE '%$txt%' || p_content LIKE '%$txt%'");
        while($r = mysqli_fetch_assoc($sql)){
            ?>
                <option value="<?php echo $r['p_name'];?>"><?php echo $r['p_desc'];?></option>
            <?php
        }
        
    }
    
    if(isset($_POST['display_search_result'])){
        $txt = $p->sqlr($con,$p->xssr($_POST['search_text']));
        
        //start
        
        $ln = 0;
        $wh =  " WHERE p_id > $ln ";
        $q1 = "SELECT * FROM product";
        $q2 = " && (p_name LIKE '%$txt%' || p_desc LIKE '%$txt%' || p_content LIKE '%$txt%') ORDER BY p_id ASC LIMIT 12";
        
        $q = $q1.$wh.$q2;
        
        //echo $query_text;
        $sql = mysqli_query($con,$q);
        echo mysqli_error($con);
        $num = mysqli_num_rows($sql);
        if($num ==0){
            $sa['exist'] = false;
        }else{
            $sa['exist'] = true;
            $last_id_loaded = 0;
            $msg = "";
            for($i = 1 ; $i <= $num ; $i++){
                                        $r = mysqli_fetch_assoc($sql);
                                                
                                        $p = ($i >= 5) ? "1": $i;
                                        $ii = ((intval($p) * 2) + 5) . "00";
                                        
                                        $random_num = rand(100,1000)+rand(100,100)+(rand(100,100) * rand(2,20)) + (rand(1,2000) * 2);
                                        
                                        
                                        $msg .= '<div class="w3-col s12 m6 l3 wow fadeInDown" data-wow-duration="1200ms" data-wow-delay="'.$ii.'ms">' ;
                                        $msg .= '<div class="w3-card-4 w3-round" style="margin: 6%;">' ;
                                        $msg .= '<div id="image-box">';
                                        $msg .= '<div id="loader-'.$random_num.'" style="height: 300px; width: 100%; position: relative;">';
                                        $msg .= '<img src="media/image/resource/i.gif" style=" position: absolute; top:48%; left: 46%;">';
                                        $msg .= '</div>';
                                        $msg .= '<img id="image-'.$random_num.'" onload="show_image(\''.$random_num.'\')" src="media/image/product/'.$r['p_image'].'" alt="'.$r['p_name'].'" class="w3-round" style="width: 100%; height: 300px; display: none;">' ;
                                        $msg .= "</div>";
                                        $msg .= '<div id="content-box">';
                                        $msg .= '<h4 class="w3-center" style="padding:8% 0px; font-weight: 900">'.$r['p_name'].';</h4>';
                                        $msg .= '<div class="w3-card-4 w3-margin w3-padding content-box-inner">'.substr($r['p_desc'],0,270)."........".'</div>' ;
                                        $msg .= '<div style="width: 100%; padding: 2%;">';
                                        $msg .= '<a href="product.php?mode=info&pid='.$r['p_id'].'&p_name='.$r['p_name'].'"><button class="w3-card-4 w3-btn w3-blue w3-round" style=" font-weight: bold; display: inline-block; width: 48%; margin-right:2%; ">DISCOVER</button></a>';
                                        $msg .= '<a href="product.php?mode=get&pid='.$r['p_id'].'&p_name='.$r['p_name'].'"><button class="w3-card-4 w3-btn w3-green w3-round" style=" font-weight: bold; display: inline-block; width: 48%;">BUY NOW</button></a>';
                                        $msg .= "</div><br></div></div></div>";
                                        
                                        
                                        $last_id_loaded = $r['p_id'];
            }
            
            //$msg= '';
            $sa['msg'] = base64_encode($msg);
            $sa['ln'] = base64_encode($last_id_loaded);
            $sa['sl1'] = base64_encode($q1);
            $sa['sl2'] = base64_encode($q2);
        }
        
        try{
            echo json_encode($sa);
            //echo '{"exist":'.$sa['exist'].',"msg":'.$msg.',"ln":'.$sa['ln'].',"sql_txt":'.$sa['sql_txt'].'}';
        }
        catch(Exception $e){
            echo $e;
        }
        
        //stop
    }
?>