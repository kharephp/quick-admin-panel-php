<?php 
$umessage='';
include('./function/function.php'); 
check_session();
if(isset($_POST['addcomment']))
{
	$id=0;
	extract($_POST);
	$type=1;
	$pdo=getPDOObject();
	$posted_data=$_POST;
	// $sql=$pdo->query("SELECT * FROM `comment` where  name LIKE '$name' or seo_url LIKE '$seo_url' ");
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
				$affected_rows=insert('comment',$posted_data);
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
	
	$data=sqlfetch("select * from `comment` where id in ($str_rest_refs)");
		foreach($data as $comment)
		{
			$img_path='../upload/'.$comment['photo'];
			 if(file_exists($img_path))
			 { 
			   @unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `comment` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `comment` SET actstat='1' WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `comment` SET actstat='0' WHERE id in ($str_rest_refs)");
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
	 
			$affected_rows=update('comment',$posted_data,array('id'=>$pid));
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
}

function comment_form($pid='0',$name='',$email='',$des='',$actstat='',$bid=0,$formname='addcomment')
{ ?>
	<form action="comment.php" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
				  <input type="hidden" name="prevphoto" value="<?php echo $photo; ?>" />
			 
			   <br><br>
			<span class="row">
			   <span class="col-md-3">
			   <label>Name</label>
				<input type="text" name="name" value="<?php echo $name; ?>" required class="form-control" /><br/><br/>
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
						<label>Email ID</label>
						<input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
					</span>
				<span class="col-md-3">
					<label>Blog</label>
					 <div class="controls">
					<select name="bid" id="selectError" data-rel="chosen">
					<option>SELECT Blog</option>
						<?php
						$categories=sqlfetch("SELECT * FROM `blog` where actstat='1' order by fld_order");
						foreach($categories as $category)
						{
							$select='';
							if(($bid==($category['id'])))
								$select='selected';
							echo '<option '.$select.' value="'.$category['id'].'">'.$category['name'].'</option>';
						}
						?>
					</select>
								</div>	
			   </span>
			</span>
			
			<span class="row">
				<span class="col-md-12">
				<textarea class="form-control" name="des" cols="60" rows="5"><?php echo $des; ?></textarea><br />
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
            <a href="#">comment</a>
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Edit comment</h2>
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
			$productdata=sqlfetch("SELECT * FROM `comment` where id='$pid' ");
			foreach($productdata as $product)
			{
				extract($product);
				comment_form($pid,$name,$photo,$des,$fld_order,$actstat,$icon,$color,$seo_url,$formname='editdone');
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
                <h2><i class="glyphicon glyphicon-info-sign"></i> Add comment</h2>
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
               <?php comment_form(); ?>
               
				</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>comment</h2>

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
							<th>Name (Email)</th>
							<th>Blog</th>
							<td>Dated</td>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php 
						include('../function/paging.class.php');
						$count=1;
						$data=sqlfetch("SELECT * FROM `comment`  order by dated desc");
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
							<td><b><?php echo $menu['name']; ?>, (<?=$menu['email'];?>)</b>
							<br><?=substr(strip_tags($menu['des']),0,30);?>...</td>
							<td><a href="blog.php?pid=<?=$menu['bid'];?>&edit=true"><?php echo get_blog_name($menu['bid']); ?></td>
							
							<td><?php echo $menu['dated']; ?></td>
							<td><?php echo get_active_status_text($menu['actstat']); ?></td>
							<td>
								<input class="xyz" name="ids[]" value="<?php echo $menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="comment.php?&pid=<?php echo $menu['id']; ?>&edit=true">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editcomment">Edit</button>
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
