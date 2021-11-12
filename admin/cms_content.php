<?php 
$umessage='';
include('./function/function.php'); 
check_session();
if(isset($_POST['addcms_content']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	$posted_data=$_POST;
	$sql=$pdo->query("SELECT * FROM `cms_content` where  name LIKE '$name' or seo_url LIKE '$seo_url' ");
	$num=$sql->rowCount();
	@$photos=$_FILES['photo']['name'];
	$Filename='';
	if(!$num)
	{	
		if($photos){
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$posted_data=$_POST;
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
		}
				$affected_rows=insert('cms_content',$posted_data);
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
	
	$data=sqlfetch("select * from `cms_content` where id in ($str_rest_refs)");
		foreach($data as $cms_content)
		{
			@$img_path='../upload/'.$cms_content['photo'];
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `cms_content` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `cms_content` SET actstat='1' WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `cms_content` SET actstat='0' WHERE id in ($str_rest_refs)");
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
	$Filename=$prevphoto;
	@$photos=$_FILES['photo']['name'];
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
	 
			$affected_rows=update('cms_content',$posted_data,array('id'=>$pid));
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
}

function cms_content_form($pid='0',$name='',$des='',$fld_order='0',$actstat='',$metatitle='',$metakeyword='',$metades='',$seo_url='',$formname='addcms_content')
{ ?>
	<form action="cms_content.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				  <input type="hidden" name="prevphoto" value="<?php //echo $photo; ?>" />
			 
			   <br><br>
			<span class="row">
			   <span class="col-md-3">
			   <label>Name</label>
				<input type="text" name="name" value="<?php echo $name; ?>" required class="form-control" /><br/><br/>
				
				</span>
				<!--<span class="col-md-3">
				<label>Photo</label>
				<input type="file" name="photo" >
				<img class="grayscale img-responsive" alt="" src="../upload/<?php //echo $photo; ?>" >
				
				</span>-->
				<span class="col-md-3">
					<label>URL</label>
						<input type="text" class="form-control" required name="seo_url" value="<?php echo $seo_url; ?>">
				</span>
				<span class="col-md-3">
				<label>Status</label>
					<div class="controls">
						<select name="actstat" id="selectError" data-rel="chosen">
							<option <?php if(($actstat)=='1')echo 'selected'; ?> value="1">Active</option>
							<option <?php if(($actstat)=='0')echo 'selected'; ?> value="0">Inactive</option>
						</select>
					</div>
				</span>
				<span class="col-md-3">
						<label>Sort Order</label>
						<input type="number" class="form-control" name="fld_order" value="<?php echo $fld_order; ?>">
					</span>
			</span>
			<span class="row">
				<span class="col-md-3">
					<label>Meta Title</label>
						<input type="text" class="form-control" name="metatitle" value="<?php echo $metatitle; ?>">
				</span>
				<span class="col-md-3">
					<label>Meta Keywords</label>
						<input type="text" class="form-control" name="metakeyword" value="<?php echo $metakeyword; ?>">
				</span>
				<span class="col-md-3">
					<label>Meta Keywords</label>
						<textarea class="form-control" name="metades" ><?php echo $metades; ?></textarea>
				</span>
			</span>
			<span class="row">
				<span class="col-md-12">
				<textarea class="des" id="des" name="des" cols="60" rows="10"><?php echo $des; ?></textarea><br />
					<script>
						// $(document).ready(function() {
							// $('.summernote').summernote({
								// height: "200px"
							// });
						// });
						// var postForm = function() {
						// var content = $('textarea[name="des"]').html($('.summernote').code());
						// }
						CKEDITOR.replace('des',{
							//uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
							// filebrowserBrowseUrl: '<?=SITE_URL_ADMIN;?>fileman/browse.php',
							// filebrowserImageBrowseUrl: '<?=SITE_URL_ADMIN;?>fileman/browse.php',
							filebrowserUploadUrl: '<?=SITE_URL_ADMIN;?>fileman/upload.php',
							filebrowserImageUploadUrl: '<?=SITE_URL_ADMIN;?>fileman/upload.php'
						});
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
<div>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="#">cms_content</a>
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Edit cms_content</h2>
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
			$productdata=sqlfetch("SELECT * FROM `cms_content` where id='$pid' ");
			foreach($productdata as $product)
			{
				extract($product);
				cms_content_form($pid,$name,$des,$fld_order,$actstat,$metatitle,$metakeyword,$metades,$seo_url,$formname='editdone');
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Add cms_content</h2>
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
               <?php cms_content_form(); ?>
               
				</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>cms_content</h2>

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
							<th>Photo</th>
							
							
							<th>Sort Order</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php 
						include('../function/paging.class.php');
						$count=1;
						$data=sqlfetch("SELECT * FROM `cms_content`  order by fld_order");
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
						
							<td><?php echo get_active_status_text($menu['actstat']); ?></td>
							<td>
								<input class="xyz" name="ids[]" value="<?php echo $menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="cms_content.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editcms_content">Edit</button>
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

<?php require('footer.php'); ?>