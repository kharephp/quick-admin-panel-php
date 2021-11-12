<?php 

include('./function/function.php'); 
check_session();
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
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo get_total_gallery_count(); ?> Team." class="well top-block" href="./gallery.php">
            <i class="glyphicon glyphicon-hdd blue"></i>

            <div>Gallery</div>
            <div><?php echo get_total_gallery_count(); ?></div>
            <span class="notification"></span>
        </a>
    </div>
	
	
</div>


<?php require('footer.php'); ?>
