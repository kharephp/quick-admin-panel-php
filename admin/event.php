<?php 
$umessage='';
include('./function/function.php'); 
check_session();
if(isset($_POST['addevent']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	$posted_data=$_POST;
	// if(is_array($event_cat) and count($event_cat))
	// $posted_data['event_cat']=implode(',',$event_cat);
	if(isset($_POST['gallery_id'])){
	if(is_array($gallery_id) and count($gallery_id))
	$posted_data['gallery_id']=implode(',',$gallery_id);
	}
	else
	{
	$posted_data['gallery_id']='';
	}
	
	$sql=$pdo->query("SELECT * FROM `event` where  name LIKE '$name' or seo_url LIKE '$seo_url' ");
	$num=$sql->rowCount();
	$photos=$_FILES['photo']['name'];
	$Filename='';
	if(!$num)
	{	
		if($photos){
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$posted_data=$_POST;
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
		}
				$affected_rows=insert('event',$posted_data);
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
	
	$data=sqlfetch("select * from `event` where id in ($str_rest_refs)");
		foreach($data as $event)
		{
			$img_path='../upload/'.$event['photo'];
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `event` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `event` SET actstat='1' WHERE id in ($str_rest_refs)");
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

if(isset($_POST['featured']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
		$str_rest_refs=implode(",",$arr);
		$pdo=getPDOObject();
	$q=$pdo->query("UPDATE `event` SET featured='1' WHERE id in ($str_rest_refs)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Featured Successfully
						   </div>';	
	}
	else{
		$umessage='<div class="alert alert-danger" role="alert">
							<strong></strong>Please Select Items to perform this action
						   </div>'; 
	}
		
}	

if(isset($_POST['unfeatured']))
{
	$arr=$_POST['ids'];
	if(count($arr))
	{
		$str_rest_refs=implode(",",$arr);
		$pdo=getPDOObject();
	$q=$pdo->query("UPDATE `event` SET featured='0' WHERE id in ($str_rest_refs)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>UnFeatured Successfully
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
	$q=$pdo->query("UPDATE `event` SET actstat='0' WHERE id in ($str_rest_refs)");
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
	$posted_data=$_POST;
	
	if(isset($_POST['gallery_id'])){
		if(is_array($gallery_id) and count($gallery_id))
		$posted_data['gallery_id']=implode(',',$gallery_id);
	}
	else
	{
		$posted_data['gallery_id']='';
	}
	
	$Filename=$prevphoto;
	$photos=$_FILES['photo']['name'];
	if($photos!='')
	{	$Filename='';
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$posted_data['photo']=$Filename;
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
				$img_path='../upload/'.$prevphoto;
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
				
		}
	 
			$affected_rows=update('event',$posted_data,array('id'=>$pid));
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
}

function event_form($pid='0',$name='',$photo='',$type='',$des='',$location='',$fld_order='0',$actstat='',$dated='',$seo_url='',$gallery_id='',$event_cat=0,$start_date='',$end_date='',$formname='addevent')
{ ?>
	<form action="event.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				  <input type="hidden" name="prevphoto" value="<?php echo $photo; ?>" />
			 
			   <br><br>
			<span class="row">
			   <span class="col-md-2">
			   <label>Name</label>
				<input type="text" name="name" value="<?php echo $name; ?>" required class="form-control" /><br/><br/>
				
				</span>
				<span class="col-md-2">
					<label>Location</label>
					<input type="text" name="location" value="<?php echo $location; ?>" required class="form-control" /><br/><br/>
				</span>
				
				<span class="col-md-2">
				<label>Photo</label>
				<input type="file" name="photo" >
				<img class="grayscale img-responsive" alt="" src="../upload/<?php echo $photo; ?>" >
				
				</span>
				<span class="col-md-2">
				<label>Status</label>
					<div class="controls">
						<select name="actstat" id="selectError" data-rel="chosen">
							<option <?php if(($actstat)=='1')echo 'selected'; ?> value="1">Active</option>
							<option <?php if(($actstat)=='0')echo 'selected'; ?> value="0">Inactive</option>
						</select>
					</div>
				</span>
				<span class="col-md-2">
						<label>Sort Order</label>
						<input type="number" class="form-control" name="fld_order" value="<?php echo $fld_order; ?>">
					</span>
				<span class="col-md-2">
					<label>URL</label>
						<input type="text" class="form-control" required name="seo_url" value="<?php echo $seo_url; ?>">
				</span>
				
			</span>
			<span class="row">
				<span class="col-md-3">
					<label>Event Category</label>
					<select name="event_cat" class="form-control" data-rel="chosen">
						<option value="">Select Event Category</option>
						<?php
						$event_category_sql=sqlfetch("SELECT * FROM event_category where actstat='1'");
						if(count($event_category_sql))
						{
							foreach($event_category_sql as $event_category)
							{ 
							$select='';
							if($event_cat==$event_category['id'])
								$select='selected';
							?>
							<option <?=$select;?> value="<?=$event_category['id'];?>"><?=$event_category['name'];?></option>
							<?php
							}
						}
						?>
					</select>
				</span>
				<span class="col-md-3">
					<label>Media Galleries</label>
					<select name="gallery_id[]" multiple class="form-control" data-rel="chosen">
						<?php
						$media_gallery_arr=explode(',',$gallery_id);
						
						$event_category_sql=sqlfetch("SELECT * FROM media_gallery where actstat='1'");
						if(count($event_category_sql))
						{
							foreach($event_category_sql as $event_category)
							{ 
							$select='';
							if(in_array($event_category['id'],$media_gallery_arr))
								$select='selected';
							?>
							<option <?=$select;?> value="<?=$event_category['id'];?>"><?=$event_category['name'];?></option>
							<?php
							}
						}
						?>
					</select>
				</span>
				<span class="col-md-3">
					<label>Starting Date</label>
					<input type="text" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
				</span>
				<span class="col-md-3">
					<label>Ending Date</label>
					<input type="text" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
				</span>
			</span>
			<span class="row">
				<span class="col-md-12">
				<textarea class="summernote" name="des" cols="60" rows="10"><?php echo $des; ?></textarea><br />
					<script>
						// $(document).ready(function() {
							// $('.summernote').summernote({
								// height: "200px"
							// });
						// });
						// var postForm = function() {
						// var content = $('textarea[name="des"]').html($('.summernote').code());
						// }
						CKEDITOR.replace('des');
					</script>
				</span>
			</span>
					
				
					<span class="col-md-4">
					<input type="submit" value="Submit" name="<?php echo $formname; ?>" class="btn btn-success" />
					
					</span>
				</form>
	
<?php 
}


?>



<?php require('header.php'); ?>
<link rel="stylesheet" type="text/css" href="./build/jquery.datetimepicker.css"/>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="#">event</a>
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
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Edit event</h2>
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
			$productdata=sqlfetch("SELECT * FROM `event` where id='$pid' ");
			foreach($productdata as $product)
			{
				extract($product);
				event_form($pid,$name,$photo,$type,$des,$location,$fld_order,$actstat,$dated,$seo_url,$gallery_id,$event_cat,$start_date,$end_date,$formname='editdone');
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Add event</h2>
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
               <?php event_form(); ?>
               
				</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>event</h2>

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
							<td>
								<input type="submit" class="btn btn-info pull-left" name="featured" value="Featured"/>
								<input type="submit" class="btn btn-warning pull-right" name="unfeatured" value="UnFeatured"/>
							</td>
							<td><input type="submit" class="btn btn-success pull-right" name="activate" value="Activate"/></td>
							<td><input type="submit" class="btn label-default pull-right " name="deactivate" value="Deactivate"/></td>
							<td><input type="submit" class="btn btn-danger pull-right" name="deleteall" value="Delete"/></td>
							<td>Select * <input type="checkbox" class="xyz" onclick="toggle(this)" ></td>
						</tr>
						
						<tr>
						
							<th>S. No.</th>
							<th>Name</th>
							<th>Photo</th>
							
							
							<th>Sort Order</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php 
						include('../function/paging.class.php');
						$count=1;
						$data=sqlfetch("SELECT * FROM `event`  order by fld_order");
						if(count($data)){
    // Create the pagination object
	
    $pagination = new pagination($data, (isset($_GET['p']) ? $_GET['p'] : 1),20);
    // Decide if the first and last links should show
          $pagination->setShowFirstAndLast(true);
          // You can overwrite the default seperator
          $pagination->setMainSeperator(' | ');
	// Parse through the pagination class
    $productPages = $pagination->getResults();
    // If we have items 
    if (count($productPages) != 0) {
        // Create the page numbers
        // echo $pageNumbers = '<div class="numbers">'.$pagination->getLinks($_GET).'</div>';
        // Loop through all the items in the array
        foreach ($productPages as $menu)
						{ ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $menu['name']; ?></td>
							
							<td><img style="max-width:200px; max-height:200px;" src="../upload/<?php echo $menu['photo']; ?>" class="img-responsive" ></td>
							<td><?php echo $menu['fld_order']; ?></td>
						
							<td><?php echo get_active_status_text($menu['actstat']); ?>
								<?php if($menu['featured']==1){?><label class="label label-info">Featured</label><?php } ?>
							</td>
							<td>
								<input class="xyz" name="ids[]" value="<?php echo $menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="event.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editevent">Edit</button>
								</a>
							</td>
						</tr>
						<?php }
	}
						}
						?>
						
						</form>
					</tbody>
				 
				 </table>
            </div>
        </div>
    </div>
    
</div>

<?php } ?>

<script src="build/jquery.datetimepicker.full.js"></script>

<script>
$('input[name="start_date"]').datetimepicker({
	format:'Y-m-d H:i:s'
});
$('input[name="end_date"]').datetimepicker({
	format:'Y-m-d H:i:s'
});

</script>

<?php require('footer.php'); ?>