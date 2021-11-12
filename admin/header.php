<?php include 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <title><?php echo $siteTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Abhishek Khare">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]
	<script src="ckedit/ckeditor.js"></script>
	<script src="ckedit/sample/js/sample.js"></script>
	<link rel="stylesheet" href="ckedit/sample/css/samples.css">
	<link rel="stylesheet" href="ckedit/sample/toolbarconfigurator/lib/codemirror/neo.css">	
	-->
	<script src="ckedit/ckeditor.js"></script>
	<!-- include libraries(jQuery, bootstrap) 
	-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 


<!-- include summernote css/js
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
-->


	
	
    <!-- The fav icon -->
    <link rel="shortcut icon" href="../images/logo.png">
<script type="text/javascript">
    function toggle(source) {
        var aInputs = document.getElementsByTagName('input');
        for (var i=0;i<aInputs.length;i++) {
            if (aInputs[i] != source && aInputs[i].className == source.className) {
                aInputs[i].checked = source.checked;
            }
        }
    }
 </script>
</head>
<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"> <img alt="<?php echo $logotitle; ?>" src="../images/logo.png" class="hidden-xs"/>
                <span></span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> admin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="adminprofile.php">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <!-- theme selector starts -->
            <div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                    <!--<li><a data-value="cosmo" href="#"><i class="whitespace"></i> Cosmo</a></li>-->
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                    <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                    <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                    <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                    <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                    <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                    <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                </ul>
            </div>
            <!-- theme selector ends -->
            <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="../"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
            </ul>

        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="index.php"><i class="glyphicon glyphicon-th-large"></i><span> Dashboard</span></a></li>
						
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-home"></i><span> Home</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="banner.php"> Banners</a></li>
                                <li> <a class="ajax-link" href="side_banner.php">Side Banners</a></li>
                                <li> <a class="ajax-link" href="legends.php">How We Work</a></li>
                                <li> <a class="ajax-link" href="partner.php">Our Partners</a></li>
                            </ul>
                        </li>
                                <!--
                                <li> <a class="ajax-link" href="category.php"> Category</a></li>
                                <li> <a class="ajax-link" href="featured_media.php">Featured Media</a></li>
                                <li> <a class="ajax-link" href="featured_blog.php">Featured Blog</a></li>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-user"></i><span> Team</span></a>
                            <ul class="nav nav-pills nav-stacked">
								<li> <a class="ajax-link" href="banner.php">Leadership</a></li>
                                <li> <a class="ajax-link" href="team.php">Members</a></li>
                                <li> <a class="ajax-link" href="team_contribution.php">Contribution by Members</a></li>
                            </ul>
                        </li>
								-->
						<!--<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-user"></i><span> Events</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="event_category.php">Event Category</a></li>
                                <li> <a class="ajax-link" href="event.php">Event</a></li>
                            </ul>
                        </li>
                        <li><a class="ajax-link" href="conference.php"><i class="glyphicon glyphicon-picture"></i><span> Conferences</span></a></li>
                        <li><a class="ajax-link" href="launches.php"><i class="glyphicon glyphicon-picture"></i><span> Launches</span></a></li> -->
                        <li class="accordion">
							<a class="ajax-link" href="#"><i class="glyphicon glyphicon-picture"></i><span> Media</span></a>
							<ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="photostream.php">Events</a></li>
                              
                                <li> <a class="ajax-link" href="gallery.php">Gallery</a></li>
                            </ul>
						</li>
						
						<!-- Divider
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-th-large"></i><span>Blog Manager</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="category.php">Category</a></li>
                                <li> <a class="ajax-link" href="blog.php">Blog</a></li>
                                <li> <a class="ajax-link" href="front_slide.php">Front Slide</a></li>
                                <li> <a class="ajax-link" href="comment.php"> Comment</a></li>
                            </ul>
                        </li>
						 -->
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-th-large"></i><span>CMS</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="cms_content.php">CMS Content</a></li>
                                <li> <a class="ajax-link" href="site_info.php">Site Info</a></li>
							</ul>
                        </li>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-th-large"></i><span>Services</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li> <a class="ajax-link" href="category.php">Category</a></li>
                                <li> <a class="ajax-link" href="product.php">Service</a></li>
							</ul>
                        </li>
						
					</ul>
                    <label id="for-is-ajax" for="is-ajax"><input id="is-ajax" checked type="checkbox">Ajax on menu</label>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>
