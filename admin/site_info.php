<?php 
$umessage='';
include('./function/function.php'); 
check_session();
if(isset($_POST['addsite_info']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	$posted_data=$_POST;
	// $sql=$pdo->query("SELECT * FROM `site_info` where  name LIKE '$name' or seo_url LIKE '$seo_url' ");
	// $num=$sql->rowCount();
	@$photos=$_FILES['photo']['name'];
	$Filename='';
	if(1)
	{	
		if($photos){
		$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$posted_data=$_POST;
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok	
		}
				$affected_rows=insert('site_info',$posted_data);
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
	
	$data=sqlfetch("select * from `site_info` where id in ($str_rest_refs)");
		foreach($data as $site_info)
		{
			$img_path='../upload/'.$site_info['photo'];
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `site_info` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `site_info` SET actstat='1' WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `site_info` SET actstat='0' WHERE id in ($str_rest_refs)");
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
	 
			$affected_rows=update('site_info',$posted_data,array('id'=>$pid));
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
}

function site_info_form($pid='0',$phone_1='',$phone_2='',$email_1='',$email_2='',$addr='',$fb_link='',$linkedin_link='',$twitter_link='',$insta_link='',$pinterest_link='',$gplus_link='',$yt_link='',$actstat=1,$fld_order='',$name='',$photo='',$footer_about='',$formname='addsite_info')
{ ?>
	<form action="site_info.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				  <input type="hidden" name="prevphoto" value="<?php echo $photo; ?>" />
			 
			   <br><br>
			<span class="row">
			   <span class="col-md-3">
			   <label>Phone No.1</label>
				<input type="text" name="phone_1" value="<?php echo $phone_1; ?>" required class="form-control" /><br/><br/>
				
				</span>
				<span class="col-md-3">
				<label>Phone No.2</label>
				<input type="text" name="phone_2" value="<?php echo $phone_2; ?>" required class="form-control" /><br/><br/>
				
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
					<label>Email 1</label>
					<input type="text" class="form-control" name="email_1" value="<?php echo $email_1; ?>">
				</span>
				<span class="col-md-3">
					<label>Email 2</label>
					<input type="text" class="form-control" name="email_2" value="<?php echo $email_2; ?>">
				</span>
				<span class="col-md-3">
					<label>Logo</label>
					<label>Photo</label>
					<input type="file" name="photo" >
					<img class="grayscale img-responsive" alt="" src="../upload/<?php echo $photo; ?>" >
				</span>
				
				<span class="col-md-3">
					<label>Address</label>
					<textarea class="form-control" name="addr" ><?php echo $addr; ?></textarea>
				</span>
			</span>
			<span class="row">
				<span class="col-md-3">
					<label>FB Link</label>
						<input type="text" class="form-control" name="fb_link" value="<?php echo $fb_link; ?>">
				</span>
				<span class="col-md-3">
					<label>LinkedIn Link</label>
					<input type="text" class="form-control" name="linkedin_link" value="<?php echo $linkedin_link; ?>">
				</span>
				<span class="col-md-3">
					<label>Twitter Link</label>
					<input type="text" class="form-control" name="twitter_link" value="<?php echo $twitter_link; ?>">
				</span>
				<span class="col-md-3">
					<label>Insta Link</label>
					<input type="text" class="form-control" name="insta_link" value="<?php echo $insta_link; ?>">
				</span>				
			</span>
			<span class="row">
				<span class="col-md-3">
					<label>Google Plus Link</label>
					<input type="text" class="form-control" name="gplus_link" value="<?php echo $gplus_link; ?>">
				</span>
				<span class="col-md-3">
					<label>YouTube Link</label>
					<input type="text" class="form-control" name="yt_link" value="<?php echo $yt_link; ?>">
				</span>
				<span class="col-md-3">
					<label>Website Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
				</span>
				<span class="col-md-3">
					<label>Location Map</label>
						<input type="text" class="form-control" name="pinterest_link" value="<?php echo $pinterest_link; ?>">
				</span>
			</span>
			<span class="row">
				<span class="col-md-6">
					<label>Footer About</label>
					<textarea class="form-control" name="footer_about" ><?php echo $footer_about; ?></textarea>
				</span>
			</span>
			<br>
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
            <a href="#">site_info</a>
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Edit site_info</h2>
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
			$productdata=sqlfetch("SELECT * FROM `site_info` where id='$pid' ");
			foreach($productdata as $product)
			{
				extract($product);
				site_info_form($pid,$phone_1,$phone_2,$email_1,$email_2,$addr,$fb_link,$linkedin_link,$twitter_link,$insta_link,$pinterest_link,$gplus_link,$yt_link,$actstat,$fld_order,$name,$photo,$footer_about,$formname='editdone');
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

<!--
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Add site_info</h2>
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
               <?php //site_info_form(); ?>
               
				</div>
            </div>
        </div>
    </div>
</div>

-->

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>site_info</h2>

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
						$count=1;
						$data=sqlfetch("SELECT * FROM `site_info`  order by fld_order");
						foreach($data as $menu)
						{ ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $menu['name']; ?></td>
							
							<td><img style="max-width:200px; max-height:200px;" src="../upload/<?php echo $menu['photo']; ?>" class="img-responsive" ></td>
							<td><?php echo $menu['fld_order']; ?></td>
						
							<td><?php echo get_active_status_text($menu['actstat']); ?></td>
							<td>
								<input class="xyz" name="ids[]" value="<?php echo $menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="site_info.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editsite_info">Edit</button>
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
