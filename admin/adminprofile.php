<?php 

include('./function/function.php'); 
check_session();

$umessage='';
if(isset($_POST['adduser']))
{
	$id='';
	extract($_POST);
	$pdo=getPDOObject();
	$q=$pdo->prepare("INSERT into `admin` values(:id,:name, :username, :password, :role,  CURRENT_TIMESTAMP, :phone, :actstat,'','' )");
	$q->execute(array(':id'=>$id,
						':name' => $name ,
						':username' => $username , 
						':password' => $password , 
						':role' => $role , 
						':phone' => $phone , 
						':actstat' => $actstat
						));
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Added Successfully
						   </div>';
	if($q)
		$umessage='Added Successfully';
}

if(isset($_POST['editdone']))
{
		extract($_POST);
		$pdo=getPDOObject();
	$q=$pdo->prepare("UPDATE `admin` SET username=? , password=?,name=?,phone=?,role=?,actstat=? WHERE id=? ");
				$q->execute(array( $username , $password ,$name , $phone, $role, $actstat , $id));	
				$affected_rows = $q->rowCount();
				if($affected_rows)
					$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Updated Successfully
						   </div>';
	
	
	
}
if(isset($_POST['delete']))
{
	
	$id=$_POST['id'];
	$pdo=getPDOObject();
	$q=$pdo->query("DELETE FROM `admin` WHERE id in ($id)");
	if($q)
	$umessage='<div class="alert alert-success" role="alert">
							<strong></strong>Deleted Successfully
						   </div>';	
	
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
<?php echo $umessage; ?>
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
	
	<?php 
	if(isset($_POST['Edit']))
	{
		echo '<div class="panel-body1">
				<h3>Editing</h3>
			';
		
		$id=$_POST['id'];
		
		$query="SELECT * FROM admin where id='$id'";
		$admindata=sqlfetch($query);
		foreach($admindata as $data)
		{ 
		extract($data);
		?>
		
		<form method="post" action=""> 
	<tr>
<input type="hidden" name="id" value="<?php echo $id; ?>">
		<td><input name="username" value="<?php echo $username; ?>" required type="email" placeholder="username"  /></td>
		<td><input name="password" value="<?php echo $password; ?>" required type="text" placeholder="password"  /></td>
		<td><input name="name" value="<?php echo $name; ?>" required type="text" placeholder="name"  /></td>
		<td><input name="role" value="<?php echo $role; ?>" required type="text" placeholder="role"  /></td>
		<td>
			
				<select name="actstat" id="selectError" data-rel="chosen">
					<option <?php if($actstat=='1')echo 'selected'; ?> value="1">Active</option>
					<option <?php if($actstat=='0')echo 'selected'; ?> value="0">Deactive</option>
				</select>
			
		</td>
		<td><input name="phone" value="<?php echo $phone; ?>" required type="text" placeholder="Phone"  /></td>
	</tr>
	<tr>
		<td><input name="editdone" type="submit" value="Update"/>  
	<tr>
	</form>
	<?php 
		}
	echo '</div>';
		
	}
	else{
		?>
		<h1>Users</h1>
		 <div class="panel-body1">
		 
					   <h4>Add New</h4>
					   					   <table class="table">
						 
						  <tbody>
	<form method="post" action=""> 
	<tr>

		<td><input name="username" required type="email" placeholder="Email-ID"  /></td>
		<td><input name="password" required type="text" placeholder="password"  /></td>
		<td><input name="name" required type="text" placeholder="name"  /></td>
		<td><input name="role" required type="text" placeholder="role"  /></td>
		<td>
			<div class="controls">
				<select name="actstat" id="selectError" data-rel="chosen">
					<option value="1">Active</option>
					<option value="0">Deactive</option>
				</select>
			</div>
		</td>
		<td><input name="phone" required type="text" placeholder="Phone"  /></td>
	</tr>
	<tr>
		
		<td><input name="adduser" type="submit" value="ADD" /> 
	<tr>
	</form>		  	
	</tbody>
						</table>
						
						</div>
						
						<div class="panel-body1">
	
					   
					   
					   <table class="table">
						 <thead>
							<tr>
							  <th>#</th>
							  <th>UserName</th>
		<th>Password</th>
		<th>Name</th>
		<th>Role</th>
		<th>Status</th>
		<th>Phone</th>
			
							</tr>
						  </thead>
						  <tbody>
	
	<?php  
	
	$query="SELECT * FROM admin order by id desc";
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$query="SELECT * FROM admin where id='$id' ";
	}
	$admindata=sqlfetch($query);
	foreach($admindata as $data)
	{
		echo '<tr>';
		echo 	'<td><a href="detail.php?cid='.$data['id'].'">'.$data['id'].'</td>';
		echo 	'<td><a href="detail.php?cid='.$data['id'].'">'.$data['username'].'</td>';
		echo 	'<td>'.$data['password'].'</td>';
		echo 	'<td>'.$data['name'].'</td>';
		echo 	'<td>'.$data['role'].'</td>';
		echo 	'<td>'.get_active_status_text($data['actstat']).'</td>';
		echo 	'<td>'.$data['phone'].'</td>';
		echo 	'<td>
		
					<form action="" method="post">
					<input type="hidden" name="id" value="'.$data['id'].'" >
					<input type="submit" class="btn btn-xs btn-primary" name="Edit" value="Edit">
					</form>
				</td>';
		echo 	'<td>
		
					<form action="" method="post">
					<input type="hidden" name="id" value="'.$data['id'].'" >
					<input type="submit" class="btn btn-xs btn-danger" name="delete" value="Delete">
					</form>
				</td>';

		echo '</tr>';
		
		
	}
	
	?>
	
	</tbody>
						</table>
						
						</div>
		<?php
	}
	?>
	
	</div>
	
	
            </div>
        </div>
    </div>
</div>


<?php require('footer.php'); ?>
