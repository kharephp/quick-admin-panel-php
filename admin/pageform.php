 <?php 

include('./function/function.php'); 
check_session();

if(isset($_POST['addpage']))
{
	$id=0;
	$name=$_POST['name'];
	$des=$_POST['des'];
	$metatitle=$_POST['metatitle'];
	$metakeyword=$_POST['metakeyword'];
	$metades=$_POST['metades'];
	$fld_order=$_POST['fld_order'];
	$headup=$_POST['headup'];
	$headdown=$_POST['headdown'];
	$pdo=getPDOObject();
	$sql=$pdo->query("SELECT * FROM `pages` where name='$name'");
	$num=$sql->rowCount();
	
	if(!$num)
	{
	
				
				$q=$pdo->prepare("INSERT into `pages` values(:id,:name,:des,:metatitle,:metakeyword,:metades,:fld_order, :headup, :headdown)");
				$q->execute(array(':id'=>$id, ':name' => $name , ':des' => $des , ':metatitle' => $metatitle , ':metakeyword' => $metakeyword , ':metades' => $metades , ':fld_order' => $fld_order, ':headup' => $headup, ':headdown' => $headdown));	
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


?>


<?php require('header.php'); ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Introduction</h2>

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
				
				
               <form action="pageform.php" method="post" enctype="multipart/form-data">
			   <label>Page Name</label>
				<input type="text" name="name" required class="form-control" /><br><br>
				<label>Description</label>
				<textarea class="summernote" name="des" cols="60" rows="10"></textarea><br />
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
					<input name="headup" type="text" class="form-control"  /><br><br>
					<label>Heading Down Line</label>
					<input name="headdown" type="text" class="form-control"  /><br><br>
					<label>Meta Title</label>
					<input name="metatitle" type="text" class="form-control"  /><br><br>
					
					<label>Meta Keyword</label>
					<input name="metakeyword" type="text" class="form-control" /><br><br>
					
					<label>Meta Description</label>
					<textarea name="metades"  class="form-control" ></textarea><br><br>
					
					<label>Order</label>
					<input name="fld_order" required min="0" value="0" type="number" class="form-control" /><br><br>
					
					<input type="submit" name="addpage" class="btn btn-success" />
				</form>
               
				</div>
            </div>
        </div>
    </div>
</div>


<?php require('footer.php'); ?>
