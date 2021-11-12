<?php 

include('function/function.php');
$umessage='';
if(isset($_POST['editpage']))
{
	extract($_POST);
	
	$pdo=getPDOObject();
	$sql=$pdo->query("SELECT * FROM `pages` where id='$id'");
	$num=$sql->rowCount();
	if($num)
	{
		$q=$pdo->prepare("UPDATE `pages` SET name=? , des=?,metatitle=?,metakeyword=?,metades=?,fld_order=?,headup=?, headdown=? WHERE id=? ");
				$q->execute(array( $name , $des ,$metatitle , $metakeyword, $metades, $fld_order , $headup, $headdown, $id));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
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
            <a href="#">Menus</a>
        </li>
    </ul>
</div>

<?php echo $umessage; ?>
<?php 
$id=$_GET['id'];
$data=sqlfetch("SELECT * FROM `pages` where id='$id'"); 
if(is_array($data))
	foreach($data as $page)
	{
		extract($page);
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Page Editor</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content row">
				<div class="col-md-12">
				
				
               <form action="" method="post" enctype="multipart/form-data">
			   <label>Page Name</label>
				<input type="text" value="<?php echo $name; ?>" name="name" required class="form-control" /><br><br>
				<input type="hidden" value="<?php echo $id; ?>" name="id"  />
				<label>Description</label>
				<textarea class="summernote" name="des" cols="60" rows="10"><?php echo $des; ?></textarea><br />
					<script>
						$(document).ready(function() {
							$('.summernote').summernote({
								height: "500px"
							});
						});
						var postForm = function() {
						var content = $('textarea[name="des"]').html($('.summernote').code());
						}
					</script>
					
					
					<br><br>
					<label>Heading Upline </label>
					<input name="headup" value="<?php echo $headup; ?>" type="text" class="form-control"  /><br><br>
					<label>Heading Down Line</label>
					<input name="headdown" type="text" value="<?php echo $headdown; ?>" class="form-control"  /><br><br>
					<label>Meta Title</label>
					<input name="metatitle" type="text" value="<?php echo $metatitle; ?>" class="form-control"  /><br><br>
					
					<label>Meta Keyword</label>
					<input name="metakeyword" type="text" value="<?php echo $metakeyword; ?>" class="form-control" /><br><br>
					
					<label>Meta Description</label>
					<textarea name="metades" class="form-control" ><?php echo $metades; ?></textarea><br><br>
					
					<label>Order</label>
					<input name="fld_order" value="<?php echo $fld_order; ?>" required min="0" value="0" type="number" class="form-control" /><br><br>
					
					<input type="submit" name="editpage" class="btn btn-warning" />
				</form>
               
				</div>
            </div>
        </div>
    </div>
</div>
	<?php } ?>
<?php require('footer.php'); ?>
