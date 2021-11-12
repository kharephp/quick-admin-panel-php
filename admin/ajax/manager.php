<?php  

include('../function/function.php');


 if(isset($_POST['str']) && $_POST['str']=="setcatid"){
		 $catid =	trim($_POST['catid']);
		echo $_SESSION['catid']=$catid;
		exit;
		
 }
 if(isset($_POST['media_gal_str']) && $_POST['media_gal_str']=="setmedia_gal_str"){
		 $media_gal_id =	trim($_POST['media_gal_id']);
		echo $_SESSION['media_gal_id']=$media_gal_id;
		if($_SESSION['media_gal_id']==0)
			unset($_SESSION['media_gal_id']);
		exit;
		
 }
 
 ?>