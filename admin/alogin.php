<?php
include('./function/function.php'); 
$umessage='<div class="alert alert-info">
                Please login with your Username and Password.
            </div>';
check_login();
if(isset($_POST['login_me']))
{
	$umessage=login_me();
}
$no_visible_elements = true;
include('header.php'); ?>

    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to <?php echo $siteTitle; ?></h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <?php echo $umessage; ?>
            <form class="form-horizontal" action="alogin.php" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" name="email"	class="form-control" placeholder="Username">
                    </div>
                    <div class="clearfix"></div><br>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" name="pass" class="form-control" placeholder="Password">
                    </div>
                    <div class="clearfix"></div>
					<!--
                    <div class="input-prepend">
                        <label class="remember" for="remember"><input type="checkbox" id="remember"> Remember me</label>
                    </div>
					-->
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" name="login_me" class="btn btn-primary">Login</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
<?php require('footer.php'); ?>