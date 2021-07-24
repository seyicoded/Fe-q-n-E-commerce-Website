<?php
	include('connectdb.php');
	$p = new db();
	$con = $p-> con();
	
	$s = mysqli_query($con,"SELECT * FROM product");
	while( $r = mysqli_fetch_assoc($s) ){
		$old_p = intval(str_ireplace(",","",$r['p_price']));
		$new_p = $old_p + 800 ;
		$id = $r['p_id'];
		
		$ins_new_pr = number_format($new_p);
		
		if(mysqli_query($con,"UPDATE product SET p_price='$ins_new_pr' WHERE p_id='$id'")){
			echo "old price=$old_p, new price = ".$ins_new_pr.", id = $id updated<br>";
		}else{
			echo "old price=$old_p, new price = ".$ins_new_pr.", id = $id error<br>";
		}
		
		//echo "old price=$old_p, new price = ".$ins_new_pr.", id = $id<br>";
	}
?>