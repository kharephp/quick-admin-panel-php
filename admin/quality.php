<?php 
$umessage='';
include('./function/function.php'); 
check_session();
if(isset($_POST['addabout']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	
				$q=$pdo->prepare("INSERT into `about` values(:id,:des)");
				$q->execute(array(':id'=>$id, 
									':des' => $des 
									));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Added Successfully
						   </div>';
	
}
if(isset($_POST['deleteall']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
	$str_rest_refs=implode(",",$arr);
	
	$data=sqlfetch("select * from `about` where id in ($str_rest_refs)");
		foreach($data as $category)
		{
			$img_path='../upload/'.$category['photo'];
			 if(file_exists($img_path))
			 { 
			   unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `about` WHERE id in ($str_rest_refs)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Deleted Successfully
						   </div>';	
	}
	else{
		$umessage='<div class="alert alert-danger" role="alert">
							<strong></strong>Please Select Items to perform this action
						   </div>'; 
	}
}

if(isset($_POST['activate']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
		$str_rest_refs=implode(",",$arr);
		$pdo=getPDOObject();
	$q=$pdo->query("UPDATE `about` SET actstat='1' WHERE id in ($str_rest_refs)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Activated Successfully
						   </div>';	
	}
	else{
		$umessage='<div class="alert alert-danger" role="alert">
							<strong></strong>Please Select Items to perform this action
						   </div>'; 
	}
		
}	

if(isset($_POST['deactivate']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
		$str_rest_refs=implode(",",$arr);
		$pdo=getPDOObject();
	$q=$pdo->query("UPDATE `about` SET actstat='0' WHERE id in ($str_rest_refs)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>DeActivated Successfully
						   </div>';	
	}
	else{
		$umessage='<div class="alert alert-danger" role="alert">
							<strong></strong>Please Select Items to perform this action
						   </div>'; 
	}	
}

if(isset($_POST['editdone']))
{
	extract($_POST);
	
	 
	$pdo=getPDOObject();
		$q=$pdo->prepare("UPDATE `about` SET 
		des=?
		
		WHERE id=?");
				$q->execute(array($des, $pid));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
}

function about_form($pid='0',$des='',$formname='addabout')
{ ?>
	<form action="quality.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
			   
			   
			  
				<textarea class="summernote" name="des" cols="60" rows="10"><?php echo $des; ?></textarea><br />
					<script>
						$(document).ready(function() {
							$('.summernote').summernote({
								height: "300px"
							});
						});
						var postForm = function() {
						var content = $('textarea[name="des"]').html($('.summernote').code());
						}
					</script>
					
					<br><br>
					<input type="submit" name="<?php echo $formname; ?>" class="btn btn-success" />
				</form>
<?php 
}

?>





<?php require('header.php'); ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="#">Quality</a>
        </li>
    </ul>
</div>
<?php echo $umessage; ?>
<?php 
if(isset($_GET['edit']) and ($_GET['edit']=='true'))
{ ?>
<div class="row"> 
	<div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Edit Quality</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
			<?php 
			$pid=$_GET['pid'];
			$productdata=sqlfetch("SELECT * FROM `about` where id='$pid' ");
			foreach($productdata as $product)
			{
				extract($product);
				about_form($pid,$des,$formname='editdone');
			} ?>

            </div>
        </div>
    </div>
</div>

	<?php
}
else{
?>



<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Quality</h2>

                <div class="box-icon">
                   
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped responsive">
					<tbody>
						
						
						<tr>
						
							<th>Quality</th>
							
							
						</tr>
						<?php 
						$count=1;
						$data=sqlfetch("SELECT * FROM `about` where id='3' order by id");
						foreach($data as $menu)
						{ ?>
						<tr>

							<td><?php echo $menu['des']; ?></td>
							
						
							
							<td>
							
								<a class="ajax-link" href="quality.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editcategory">Edit</button>
								</a>
							</td>
						</tr>
						<?php } ?>
						
					
					</tbody>
				 </table>
            </div>
        </div>
    </div>
</div>

<?php } ?>

<?php require('footer.php'); ?>
