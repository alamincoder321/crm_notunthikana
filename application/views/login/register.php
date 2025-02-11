
<!DOCTYPE html>
<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="/assets/login/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/login/css/style.css">
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>uploads/favicon.png">
	<style>
		.typed-cursor{
			color: #fff;
		}
		.login{
			min-height: unset;
		}
		.contant {
			width: 700px;
		}
	</style>
</head>
<body>

<div class="container">

	<div class="contant">
		<!-- <h2 class="headding"><span id="typed"></span></h2> -->
		<div class="login">

			<div class="login-form" style="background-color: #fff;">
				<div class="form">
					<h4 style="color: #0d333b;">Register Please</h4>
					<p style="color:red;text-align:center"><?php if(isset($message)){ echo $message; } ?></p>
					<form method="post" action="<?php echo base_url();?>Login/procedureRegister">
						<div class="form-group">
							<?php echo form_error('user_name'); ?>
							<input type="text" name="user_name" class="form-control" placeholder="Mobile Number">
						</div>
						<div class="form-group">
							<?php echo form_error('password'); ?>
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<div class="form-group">
							<input style="background-color: #0d333b;" type="submit" name="submit" class="btn btn-warning btn-block" value="Register">
							<a href="/Login" class="btn btn-info btn-block">Login</a>
						</div>
					</form>
				</div>
			</div>
				
			<div class="clr"></div>
		</div>
	</div>

</div>
<script src="/assets/login/js/jquery.min.js"></script>
<script src="/assets/login/js/bootstrap.min.js"></script>
<script src="/assets/js/typed.js"></script>
<script>
	$(function(){
		var typed = new Typed('#typed', {
			strings: ['Welcome to Biz Manager'],
			typeSpeed: 100,
			backSpeed: 100,
			loop: true
		});
	});
</script>
</body>
</html>