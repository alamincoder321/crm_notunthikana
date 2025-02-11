<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$company = $this->db->query("select * from tbl_company")->row();
	?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $company->Company_Name; ?> - Login Page</title>
	<link rel="icon" type="image/x-icon" href="/uploads/company_profile_org/<?= $company->Company_Logo_org ?>">
	<link href="<?php echo base_url(); ?>assets/css/toastr.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<style>
		@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

		* {
			box-sizing: border-box;
		}

		body {
			background: url('/assets/images/login_bg.png');
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			width: 100%;
			height: 100vh;
			font-family: 'Montserrat', sans-serif;
			margin: 0;
		}

		h1 {
			font-weight: bold;
			margin: 0;
			font-size: 1.5rem !important;
		}

		h2 {
			text-align: center;
		}

		p {
			font-size: 14px;
			font-weight: 100;
			line-height: 20px;
			letter-spacing: 0.5px;
			margin: 20px 0 30px;
		}

		span {
			font-size: 12px;
		}

		a {
			color: #333;
			font-size: 14px;
			text-decoration: none;
			margin: 15px 0;
		}

		button {
			border-radius: 20px;
			border: 1px solid #FF4B2B;
			background-color: #FF4B2B;
			color: #FFFFFF;
			font-size: 12px;
			font-weight: bold;
			padding: 12px 45px;
			letter-spacing: 1px;
			text-transform: uppercase;
			transition: transform 80ms ease-in;
			cursor: pointer;
		}

		button:active {
			transform: scale(0.95);
		}

		button:focus {
			outline: none;
		}

		button.ghost {
			background-color: transparent;
			border-color: #FFFFFF;
		}

		form {
			background-color: #FFFFFF;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			padding: 0 50px;
			height: 100%;
			text-align: center;
			margin-top: -12px;
		}

		input {
			background-color: #eee;
			border: 1px solid #b5b5b5;
			padding: 12px 15px;
			margin: 8px 0;
			width: 100%;
			outline: none;
		}

		.container {
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
				0 10px 10px rgba(0, 0, 0, 0.22);
			position: absolute;
			overflow: hidden;
			width: 650px;
			max-width: 100%;
			min-height: 400px;
			left: 50%;
			top: 35%;
			transform: translate(-50%, -50%);
		}

		.form-container {
			position: absolute;
			top: 0;
			height: 100%;
			transition: all 0.6s ease-in-out;
		}

		.sign-in-container {
			left: 0;
			width: 50%;
			z-index: 2;
		}

		.container.right-panel-active .sign-in-container {
			transform: translateX(100%);
		}

		.sign-up-container {
			left: 0;
			width: 50%;
			opacity: 0;
			z-index: 1;
		}

		.container.right-panel-active .sign-up-container {
			transform: translateX(100%);
			opacity: 1;
			z-index: 5;
			animation: show 0.6s;
		}

		@keyframes show {

			0%,
			49.99% {
				opacity: 0;
				z-index: 1;
			}

			50%,
			100% {
				opacity: 1;
				z-index: 5;
			}
		}

		.overlay-container {
			position: absolute;
			top: 0;
			left: 50%;
			width: 50%;
			height: 100%;
			overflow: hidden;
			transition: transform 0.6s ease-in-out;
			z-index: 100;
		}

		.container.right-panel-active .overlay-container {
			transform: translateX(-100%);
		}

		.overlay {
			background: #FF416C;
			background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
			background: linear-gradient(to right, #FF4B2B, #FF416C);
			background-repeat: no-repeat;
			background-size: cover;
			background-position: 0 0;
			color: #FFFFFF;
			position: relative;
			left: -100%;
			height: 100%;
			width: 200%;
			transform: translateX(0);
			transition: transform 0.6s ease-in-out;
		}

		.container.right-panel-active .overlay {
			transform: translateX(50%);
		}

		.overlay-panel {
			position: absolute;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			padding: 0 40px;
			text-align: center;
			top: 0;
			height: 100%;
			width: 50%;
			transform: translateX(0);
			transition: transform 0.6s ease-in-out;
		}

		.overlay-left {
			transform: translateX(-20%);
		}

		.container.right-panel-active .overlay-left {
			transform: translateX(0);
		}

		.overlay-right {
			right: 0;
			transform: translateX(0);
		}

		.container.right-panel-active .overlay-right {
			transform: translateX(20%);
		}

		footer {
			background-color: #222;
			color: #fff;
			font-size: 14px;
			bottom: 0;
			position: fixed;
			left: 0;
			right: 0;
			text-align: center;
			z-index: 999;
		}

		footer p {
			margin: 10px 0;
		}

		footer i {
			color: red;
		}

		footer a {
			color: #3c97bf;
			text-decoration: none;
		}
		i {
            position: absolute;
            right: 10px;
            top: 21px;
            cursor: pointer;
        }
	</style>
</head>

<body>
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form onsubmit="Login(event)">
				<h3 style="font-size: 30px;">Login Form</h3>
				<input type="text" name="username" placeholder="Username" required autofocus autocomplete="off" />
				<p style="margin: 0;position:relative;width:100%;" class="password">
					<input type="password" name="password" placeholder="Password" required autocomplete="off" />
					<i class="fa fa-eye" onclick="passwordShow(event)"></i>
				</p>
				<button type="submit">Login</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p style="margin: 0;
                    font-size: 14px;
                    font-weight: 800;
                    text-transform: uppercase;
                    margin-top: 10px;"><?= $company->Company_Name; ?></p>
					<p>To keep connected with us please login with your username and password</p>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hello, Friend!</h1>
					<p>Enter your username and password start journey with us</p>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<p>
			Developed <i class="fa fa-heart"></i> By
			<a target="_blank" href="https://florin-pop.com">BD Soft Technology</a>
		</p>
	</footer>
	<script>
		const signUpButton = document.getElementById('signUp');
		container.classList.add("right-panel-active");
	</script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
	<script>
		function Login(event) {
			event.preventDefault();
			let formdata = new FormData(event.target);

			$.ajax({
				url: "/Login/procedure",
				method: "POST",
				data: formdata,
				dataType: "JSON",
				processData: false,
				contentType: false,
				success: res => {
					if (res.status) {
						location.href = "/Administrator/"
					} else {
						toastr.error(res.message)
					}
				}
			})
		}

		// show password
		function passwordShow(event) {
			let password = $(".password").find('input').prop('type');
			if (password == 'password') {
				$(".password").find('i').removeProp('class').prop('class', 'fa fa-eye-slash')
				$(".password").find('input').removeProp('type').prop('type', 'text');
			} else {
				$(".password").find('i').removeProp('class').prop('class', 'fa fa-eye')
				$(".password").find('input').removeProp('type').prop('type', 'password');
			}
		}
	</script>
</body>

</html>