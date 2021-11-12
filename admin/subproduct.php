<?php 
$umessage='';
include('./function/function.php'); 
check_session();

if(isset($_POST['del_photo']))
{
	$arr=$_POST['sub_id'];
	if(count($arr))
	{
	$str_rest_refs=$arr;
	
	$data=sqlfetch("select * from `prodimg` where id in ($str_rest_refs)");
		foreach($data as $images)
		{
			$img_path='../upload/'.$images['name'];
			 if(file_exists($img_path))
			 {
			   unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `prodimg` WHERE id in ($str_rest_refs)");
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
if(isset($_POST['pp_photo']))
{
	extract($_POST);
	$pdo=getPDOObject();
	$q=$pdo->prepare("UPDATE `subproduct` SET photo=?  WHERE id=?");
	$q->execute(array( $sub_name , $pid));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
	
	
}
if(isset($_POST['add_photo']))
{
	extract($_POST);
	$pid=$_GET['pid'];
	$id=0;
	$file=$_FILES['photo']['name'];
	$pdo=getPDOObject();
	if($file!='')
	{
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok
				$q=$pdo->prepare("INSERT into `prodimg` values(:id, :pid, :name)");
				$q->execute(array(':id'=>$id, ':pid'=>$pid, ':name'=>$Filename));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
				$umessage='<div class="alert alert-success" role="alert">
						<strong></strong>Updated Successfully
					   </div>';
	}
}


if(isset($_POST['addsubproduct']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	$sql=$pdo->query("SELECT * FROM `subproduct` where  name LIKE '$name'");
	$num=$sql->rowCount();
	$photos=$_FILES['photo']['name'];
	$Filename='';
	if(!$num)
	{	
		if($photos){
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
		}
				$q=$pdo->prepare("INSERT into `subproduct` values(:id,:name, :photo,:des, :fld_order, :actstat, :subcat, :pcode)");
				$q->execute(array(':id'=>$id, 
									
									':name' => $name ,
									':photo' => $Filename ,
									':des' => $des ,
									':fld_order' => $fld_order ,
									':actstat' => $actstat,
									':subcat' => $subcat,
									':pcode' => $pcode
									));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Added Successfully
						   </div>';
	}
	else
	{
		$umessage='<div class="alert alert-danger" role="alert">Duplicate Entry!!! Code Already Exists </div> ';
	}
	
}

if(isset($_POST['deleteall']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
	$str_rest_refs=implode(",",$arr);
	
	$data=sqlfetch("select * from `subproduct` where id in ($str_rest_refs)");
		foreach($data as $subproduct)
		{
			$img_path='../upload/'.$subproduct['photo'];
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `subproduct` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `subproduct` SET actstat='1' WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `subproduct` SET actstat='0' WHERE id in ($str_rest_refs)");
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
	$Filename=$prevphoto;
	$photos=$_FILES['photo']['name'];
	if($photos!='')
	{	$Filename='';
		
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
				$img_path='../upload/'.$prevphoto;
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
				
		}
	 
	$pdo=getPDOObject();
		$q=$pdo->prepare("UPDATE `subproduct` SET 
		
		
		name=?,
		photo=?,
		des=?,
		fld_order=?,
		actstat=?,
		subcat=?,
		pcode=?
		
		WHERE id=?");
				$q->execute(array( $name, $Filename , $des,$fld_order,$actstat, $subcat,$pcode, $pid));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
}

function subproduct_form($pid='0',$name='',$photo='',$des='',$fld_order='0',$actstat='', $subcat='0', $pcode='0',$formname='addsubproduct')
{ ?>
	<form action="subproduct.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				 <input type="hidden" name="des" value="<?php echo $des; ?>" />
				  <input type="hidden" name="prevphoto" value="<?php echo $photo; ?>" />
			 
			   <br><br>
			   <span class="row">
			   <span class="col-md-4">
					<label>Project</label>
					 <div class="controls">
					<select name="subcat" id="selectError" data-rel="chosen">
					<option>SELECT Project</option>
						<?php 
						$products=sqlfetch("SELECT * FROM `product` order by fld_order");
						foreach($products as $product)
						{
							$select='';
							if(($subcat==($product['id'])))
								$select='selected';
							echo '<option '.$select.' value="'.$product['id'].'">'.$product['name'].'</option>';
						}
						?>
					</select>
								</div>	
			   </span>
			   <span class="col-md-4">
			   <label>Name</label>
				<input type="text" name="name" value="<?php echo $name; ?>" required class="form-control" /><br/><br/>
				
				</span>
				<span class="col-md-4">
				<label>Photo</label>
				<input type="file" name="photo" >
				<img class="grayscale img-responsive" alt="" src="../upload/<?php echo $photo; ?>" >
				
				</span>
				</span>
				<span class="row">
				<span class="col-md-4">
				<label>Status</label>
					<div class="controls">
						<select name="actstat" id="selectError" data-rel="chosen">
							<option <?php if(($actstat)=='1')echo 'selected'; ?> value="1">Active</option>
							<option <?php if(($actstat)=='0')echo 'selected'; ?> value="0">Inactive</option>
						</select>
					</div>
				</span>
				<span class="col-md-4">
						<label>Sort Order</label>
						<input type="number" class="form-control" name="fld_order" value="<?php echo $fld_order; ?>">
					</span>
				<span class="col-md-4">
						<label>Project Code</label>
						<input type="text" class="form-control" name="pcode" value="<?php echo $pcode; ?>">
				</span>
				</span>
				<!--
				<span class="col-md-12">
				<label>Description</label>	
				<textarea class="summernote" name="des" cols="60" rows="10"><?php echo $des; ?></textarea><br />
					<script>
						$(document).ready(function() {
							$('.summernote').summernote({
								height: "200px"
							});
						});
						var postForm = function() {
						var content = $('textarea[name="des"]').html($('.summernote').code());
						}
					</script>
				</span>
					-->
				
					<span class="col-md-4">
					<input type="submit" value="Submit" name="<?php echo $formname; ?>" class="btn btn-success" />
					
					</span>
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
            <a href="#">Project Images</a>
        </li>
    </ul>
</div>
<?php echo $umessage; ?>
<?php 
if(isset($_GET['edit']) and ($_GET['edit']=='true'))
{ 
$productid=$_GET['pid'];
?>

<div class="row"> 
	<div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Manage Photos</h2>

                <div class="box-icon">
                   
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
			</div>
				<div class="box-content">
					<?php 
							$sub_image_data=sqlfetch("SELECT * FROM prodimg where pid='$productid'");
							if(count($sub_image_data))
								foreach($sub_image_data as $sub_image)
								{ ?>
									<span> 
									<img src="../upload/<?php echo $sub_image['name']; ?>" height="100" width="100">
									<form action="" method="post">
										<input type="hidden" name="sub_id" value="<?php echo $sub_image['id']; ?>" />
										<input type="hidden" name="sub_name" value="<?php echo $sub_image['name']; ?>" />
										<input type="hidden" name="pid" value="<?php echo $productid; ?>">
										<input type="submit" name="del_photo" class="btn btn-danger" value="Del">
										<input type="submit" name="pp_photo" class="btn btn-success" value="PP">
									</form>
									</span>
									
									<?php 
								}
							?>
							<br>
							<br>
							<span>
								<label>Add New Image</label>
										<form action="" enctype="multipart/form-data" method="post">
											<input type="hidden" name="pid" value="<?php echo $productid; ?>" />
											<input  name="photo" type="file"/>
											<input type="submit" name="add_photo" value="Add">
										</form>
									</span>
				</div>
				
            	
		</div>
	</div>
</div>


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Edit Project Images</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-down"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content row" >
				<div class="col-md-12">
               <?php 
			$pid=$_GET['pid'];
			$subproductdata=sqlfetch("SELECT * FROM `subproduct` where id='$pid' ");
			foreach($subproductdata as $subproduct)
			{
				extract($subproduct);
				subproduct_form($pid,$name,$photo,$des,$fld_order,$actstat,$subcat,$pcode,$formname='editdone');
			} ?>
               
				</div>
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
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Add Project Images</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-down"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content row" >
				<div class="col-md-12">
               <?php subproduct_form(); ?>
               
				</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Project Images</h2>

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
						
						<form action="" method="post">
						<tr>
						
						
							
							
							<td></td>
							<td></td>
							<td><input type="submit" class="btn btn-success pull-right" name="activate" value="Activate"/></td>
							<td><input type="submit" class="btn label-default pull-right " name="deactivate" value="Deactivate"/></td>
							<td><input type="submit" class="btn btn-danger pull-right" name="deleteall" value="Delete"/></td>
							<td>Select * <input type="checkbox" class="xyz" onclick="toggle(this)" ></td>
						</tr>
						
						<tr>
						
							<th>S. No.</th>
							<th>Name</th>
							<th>Project</th>
							<th>Photo</th>
							
							
							<th>Sort Order</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php 
						$count=1;
						$data=sqlfetch("SELECT * FROM `subproduct`  order by fld_order");
						foreach($data as $menu)
						{ ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $menu['name']; ?></td>
							<td><?php echo get_product_name($menu['subcat']); ?></td>
							
							<td><img src="../upload/<?php echo $menu['photo']; ?>" class="img-responsive" ></td>
							<td><?php echo $menu['fld_order']; ?></td>
						
							<td><?php echo get_active_status_text($menu['actstat']); ?></td>
							<td>
								<input class="xyz" name="ids[]" value="<?php echo $menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="subproduct.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editsubproduct">Edit</button>
								</a>
							</td>
						</tr>
						<?php } ?>
						
						</form>
					</tbody>
				 
				 </table>
            </div>
        </div>
    </div>
    
</div>

<?php } ?>

<?php require('footer.php'); ?>
