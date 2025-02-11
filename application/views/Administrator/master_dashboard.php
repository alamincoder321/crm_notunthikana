<?php
$companyInfo = $this->db->query("select * from tbl_company c order by c.Company_SlNo desc limit 1")->row();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title><?php echo $companyInfo->Company_Name; ?> || <?php echo $title; ?></title>

	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fonts.googleapis.com.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/fancyBox/css/jquery.fancybox.css?v=2.1.5" media="screen" />
	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-rtl.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css" />
	<script src="<?php echo base_url(); ?>assets/js/ace-extra.min.js"></script>
	<link rel="icon" type="image/x-icon" href="/uploads/company_profile_org/<?= $companyInfo->Company_Logo_org ?>">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />

</head>

<body class="skin-2">
	<!-- Preloader -->
	<div class="preloader">
		<div class="loader"></div>
	</div>
	<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top" style="background:#007ebb !important;border-bottom: 1px solid #e9e9e9;">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="<?php echo base_url(); ?>" class="navbar-brand" style="margin-left: -10px;">
					<small>
						<img src="/uploads/company_profile_org/<?= $companyInfo->Company_Logo_org ?>" alt="" width="25" height="25">
						<?php echo $companyInfo->Company_Name; ?>
					</small>
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<?php
					$userID =  $this->session->userdata('userId');
					$CheckSuperAdmin = $this->db->where('UserType', 'm')->where('User_SlNo', $userID)->get('tbl_user')->row();
					if (isset($CheckSuperAdmin)) :
					?>

					<?php endif; ?>

					<li class="light-blue">
						<div id="clock"></div>
					</li>

					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<?php if ($this->session->userdata('user_image')) { ?>

								<img class="nav-user-photo" src="<?php echo base_url(); ?>uploads/users/<?php echo $this->session->userdata('user_image'); ?>" alt="<?php echo $this->session->userdata('FullName'); ?>" />
							<?php } else { ?>

								<img class="nav-user-photo" src="<?php echo base_url(); ?>uploads/no_image.jpg ?>" alt="<?php echo $this->session->userdata('FullName'); ?>" />
							<?php } ?>
							<span class="user-info">
								<small>Welcome,</small>
								<?php echo $this->session->userdata('FullName'); ?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="<?php echo base_url(); ?>profile">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="<?php echo base_url(); ?>Login/logout">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed sidebar-scroll">
			<script type="text/javascript">
				try {
					ace.settings.loadState('sidebar')
				} catch (e) {}
			</script>

			<?php include('menu.php'); ?>

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="#">Home</a>
						</li>
						<li class="active">Dashboard</li>
					</ul>
				</div>

				<div class="page-content">

					<div id="loader" hidden style="position: fixed; z-index: 1000; margin: auto; height: 100%; width: 100%; background:rgba(255, 255, 255, 0.72);;">
						<img src="<?php echo base_url(); ?>assets/loader.gif" style="top: 30%; left: 50%; opacity: 1; position: fixed;">
					</div>
					<?php echo $content; ?>
				</div>
			</div>
		</div><!-- /.main-content -->

		<div style="padding: 4px 16px;background-color: #007ebb;color:white;position: fixed;right: 0;bottom: 0;z-index: 999;">
			<span style="font-size: 12px;">
				Developed by <span class="blue bolder"><a href="https://bdsofttechnology.com/" target="_blank" style="color: white;text-decoration: underline;font-weight: normal;">BD Soft Technology</a></span>
			</span>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->

	<!-- basic scripts -->
	<!--[if !IE]> -->
	<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

	<!-- page specific plugin scripts -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/buttons.flash.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/buttons.colVis.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.select.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/jquery-ui.custom.min.js"></script>

	<!-- ace scripts -->
	<script src="<?php echo base_url(); ?>assets/js/ace-elements.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/ace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/fancyBox/js/jquery.fancybox.js?v=2.1.5"></script>
	<!-- inline scripts related to this page -->


	<script type="text/javascript">
		$(document).ready(function() {

			$('.fancybox').fancybox({

				padding: 0,

				openEffect: 'elastic',

				openSpeed: 150,

				closeEffect: 'elastic',

				closeSpeed: 150,

				maxWidth: "60%",

				autoSize: true,

				autoScale: true,

				fitToView: true,

				helpers: {

					title: {

						type: 'inside'

					},

					overlay: {

						css: {

							'background': 'rgba(0,0,0,0.3)'

						}

					}

				}

			});

			$('.fancyboxview').fancybox({

				padding: 0,

				openEffect: 'elastic',

				openSpeed: 150,



				closeEffect: 'elastic',

				closeSpeed: 150,

				maxWidth: "95%",

				autoSize: true,

				autoScale: true,

				fitToView: true,



				helpers: {

					title: {

						type: 'inside'

					},

					overlay: {

						css: {

							'background': 'rgba(0,0,0,0.3)'

						}

					}

				}

			});

		});

		window.addEventListener('load', function() {
			const preloader = document.querySelector('.preloader');
			preloader.style.display = 'none';
		});

		// window.onload = displayClock();
		function displayClock() {
			var display = new Date().toLocaleTimeString();
			var dispalyDate = new Date().toDateString();
			document.getElementById("clock").innerText = dispalyDate + ', ' + display;
			setTimeout(displayClock, 1000);
		}
		displayClock();
	</script>

</body>

</html>