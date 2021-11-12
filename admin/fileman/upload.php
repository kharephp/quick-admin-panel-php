<?php 
include('../function/function.php');
header('Content-Type:application/json');
if(isset($_FILES['upload'])){
	
	//rawfiles
	$Filename=date('dmyhis').basename( $_FILES['upload']['name']);
	$target = "../../rawfiles/".$Filename;
	$q=move_uploaded_file($_FILES['upload']['tmp_name'], $target);    //Tells you if its all ok	
	
	echo json_encode(array(
		"uploaded"=>'1',
		"fileName"=>$Filename,
		"url"=>SITE_URL."rawfiles/".$Filename
	));
}