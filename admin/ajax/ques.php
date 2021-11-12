<?php  

include('../function/function.php');

 if(isset($_POST['str']) && $_POST['str']=="getques")
 {
   $catid =	$_POST['catid'];
     $data=sqlfetch("select * from `qna` where catid='$catid'"); 
		
		if(count($data))
			
		foreach($data as $scrow)
		{
	 ?>
						<tr>
							<td><input type="checkbox" value="<?php echo $scrow['id']; ?>" name="question[]" ></td>
							<td><?php echo $scrow['name']; ?></td>
						</tr>                   
 <?php   
	
	}
	else
		echo 'No data';
	
	}
	
	if(isset($_POST['str']) && $_POST['str']=="getques2"){
    $pid=$_POST['pid'];
   $catid =	$_POST['catid'];
     $data=sqlfetch("select * from `qna` where catid='$catid'"); 
		
		$checkd='';
		$data2=sqlfetch("SELECT * FROM test where id='$pid'");
		foreach($data2 as $test)
		{
			$checkd=$test['ques'];
		}
		$checkdata=explode(',',$checkd);
	
		if(count($data))
		foreach($data as $scrow)
		{
			
			$check='';
			if(in_array($scrow['id'],$checkdata))
			$check='checked';
	 ?>
						<tr>
							<td><input <?php echo $check; ?> type="checkbox" value="<?php echo $scrow['id']; ?>" name="question[]" ></td>
							<td><?php echo $scrow['name']; ?></td>
						</tr>                   
 <?php   
	
	}
	else
		echo 'No data';
	
	}

?>