<?php  

include('../function/function.php');

 if(isset($_POST['str']) && $_POST['str']=="getstatelist"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from state where coun_id='$catid'"); 
		foreach($data as $country)
		{
	 ?>
    <tr>
                            <td><?php echo $country['name']; ?></td>
                           
                            <td>
								<input class="xyzstate" name="ids[]" value="1" type="checkbox"> 
								<a class="ajax-link" href="locationedit.php?type=coun&id=<?php echo $country['id']; ?>">
								<button type="button" class="btn btn-xs btn-info pull-right" name="editcategory">Edit</button>
								</a>
							</td>
                        </tr>
                       
 <?php   
	
	}
	
	}
	
	if(isset($_POST['str']) && $_POST['str']=="getstateoption"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from state where coun_id='$catid'"); 
		echo '<option value="">States</option>';
		foreach($data as $state)
		{
	 ?>
						
    <option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
	
 <?php  
	}
	
	}
	
	if(isset($_POST['str']) && $_POST['str']=="getcityoption"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from cities where state_id='$catid'"); 
	 echo '<option value="">Cities</option>';
	 
		foreach($data as $state)
		{
	 ?>
						
    <option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
	
 <?php  
	}
	
	}

?>