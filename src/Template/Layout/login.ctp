<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>AdEx - Login</title>
	<!-- Stylesheets -->
	<link href="<?php echo HTTP_ROOT;?>css/style.css" rel="stylesheet">
	<link href="<?php echo HTTP_ROOT;?>fonts/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo HTTP_ROOT;?>css/bootstrap.min.css">
	<!--Favicon-->
	<link rel="icon" href="<?php echo HTTP_ROOT;?>images/favicon.png" type="image/x-icon">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body style="background:#658EBB !important;">
	<div class="login" style="background:#2C2C2C">
		<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>
			<img style="width:150px" src="<?php echo HTTP_ROOT;?>img/logo_adex.png"/>
			<img style="width: 150px;height: 120px;float: right;margin-top: 18px;" src="<?php echo HTTP_ROOT;?>img/APAPLogo.svg"/>
			<!-- <h4>Sign In</h4>
			<p class="mt-4"><input type="text" class="form-control" placeholder="Email, Phone, Skype"></p>
			<p><a href="#">Can't access your account?</a></p> -->
			<p style="margin-top: 29%;"><a class="btn btn-primary" style="color:#fff" href="<?php echo HTTP_ROOT;?>users/myAuth">Login with your AdEx office 365 account</a></p>
			<!-- <p class="text-right"><a class="btn btn-primary" onclick="checkUserName()" href="javascript:void(0);">Next</a></p> -->
		</form>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/popper.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/bootstrap.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/bootstrap-notify/bootstrap-notify.js"></script>
	<script>$('.dropdown-toggle').dropdown()</script>
	<?php echo $this->Flash->render();?>
</body>
</html>