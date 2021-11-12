<?php 

include('function/function.php');
$umessage='';
if(isset($_POST['addcategory']))
{
	$fld_id=0;
	$fld_category=$_POST['fld_category'];
	$fld_cat_code=$_POST['fld_cat_code'];
	$fld_status=$_POST['fld_status'];
	$des=$_POST['des'];
	$pdo=getPDOObject();
	$sql=$pdo->query("SELECT * FROM `tbl_data` where fld_cat_code='$fld_cat_code'");
	$num=$sql->rowCount();
	
	if(!$num)
	{
	$Filename=date('dmyhis').basename( $_FILES['photo']['name']);		
				$target = "../upload/".$Filename;
				move_uploaded_file($_FILES['photo']['tmp_name'], $target);    //Tells you if its all ok
				$q=$pdo->prepare("INSERT into `tbl_data` values(:fld_id,:fld_category,:fld_cat_code,:fld_status,:Filename,:des)");
				$q->execute(array(':fld_id'=>$fld_id, ':fld_category' => $fld_category , ':fld_cat_code' => $fld_cat_code , ':fld_status' => $fld_status , ':Filename' => $Filename , ':des' => $des));	
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
	
	$data=sqlfetch("select * from `pages` where id in ($str_rest_refs)");
		foreach($data as $category)
		{
			$img_path='../upload/'.$category['photo'];
			 if(file_exists($img_path))
			 { 
			   unlink($img_path);
			 }
		}
	
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `pages` WHERE id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `tbl_data` SET fld_status='1' WHERE fld_id in ($str_rest_refs)");
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
	$q=$pdo->query("UPDATE `tbl_data` SET fld_status='0' WHERE fld_id in ($str_rest_refs)");
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

?>

<?php require('header.php'); ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="./">Home</a>
        </li>
        <li>
            <a href="#">Sellers</a>
        </li>
    </ul>
</div>

<?php echo $umessage; ?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Category</h2>

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
						
						<form action="pages.php" method="post">
						<tr>
						
							<td></td>
							<td></td>
							<td></td>
							<td><input type="submit" class="btn btn-success pull-right" name="activate" value="Activate"/></td>
							<td><input type="submit" class="btn label-default pull-right " name="deactivate" value="Deactivate"/></td>
							<td><input type="submit" class="btn btn-danger pull-right" name="deleteall" value="Delete"></td>
							<td>Select * <input type="checkbox" class="xyz" onclick="toggle(this)" ></td>
						</tr>
						
						<tr>
						
							<th>S. No.</th>
							<th>Name</th>
							<th>Metatitle</th>
							<th>Email</th>
							<th>ACTION</th>
						</tr>
						<?php 
						$count=1;
						$data=sqlfetch("SELECT * FROM `pages` order by id");
						foreach($data as $menu)
						{ ?>
						<tr>
							<td><?php echo $count++; ?> </td>
							<td><?php echo $menu['name']; ?></td>
							<td><?php echo $menu['metatitle']; ?></td>
							<td><?php echo $menu['fld_order']; ?></td>
							
							<td>
								<input class="xyz" name="ids[]" value="<?=$menu['id']; ?>" type="checkbox"/> 
								<a class="ajax-link" href="editpage.php?id=<?=$menu['id']; ?>">
								<button type="button" class="btn btn-xs btn-danger pull-right" name="editcategory">Edit</button>
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
    <!--/span-->

</div><!--/row-->

<?php require('footer.php'); ?>

