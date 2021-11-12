<?php  

include('../function/function.php');

 if(isset($_POST['str']) && $_POST['str']=="getsubcategory"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from tbl_sub_category where fld_cat_code='$catid'"); 
	 
		foreach($data as $scrow)
		{
	 ?>
	 <input onChange="getsub2(this.name)" class="subcategory" type="checkbox" value="<?php echo $scrow['fld_sub_cat_code']; ?>" name="subcategory[]"/> <?php echo $scrow['fld_sub_cat']; ?> &nbsp;&nbsp;&nbsp;
                       
 <?php   
	
	}
	
	}
	
	if(isset($_POST['str']) && $_POST['str']=="getsubcat2"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from tbl_sub_cat_2 where fld_sub_cat_code in ($catid) "); 
		foreach($data as $scrow)
		{
	 ?>
	 
	 <input onChange="getsub3(this.name)" class="subcat2" type="checkbox" value="<?php echo $scrow['fld_sub_cat_2_code']; ?>" name="subcat2[]"/> <?php echo $scrow['fld_sub_cat_2']; ?> &nbsp;&nbsp;&nbsp;
	
 <?php  
	}
	
	}
	
	if(isset($_POST['str']) && $_POST['str']=="getsubcat3"){
    
   $catid =	trim($_POST['catid']);
   
     $data=sqlfetch("select * from tbl_sub_cat_3 where fld_sub_cat_2_code in ($catid) "); 
		foreach($data as $scrow)
		{
	 ?>
	 <input class="subcat3" type="checkbox" value="<?php echo $scrow['fld_sub_cat_3_code']; ?>" name="fld_category[]"/> <?php echo $scrow['fld_sub_cat_3']; ?> &nbsp;&nbsp;&nbsp;
 <?php  
	}
	
	}

?>