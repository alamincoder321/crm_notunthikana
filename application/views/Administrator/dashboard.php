<?php $this->load->view('Administrator/dashboard_style'); ?>
<style>
	.module-title {
		text-align: center !important;
		font-size: 18px !important;
		font-weight: bold !important;
		font-style: italic !important;
	}

	.module-title span {
		font-size: 18px !important;
		font-weight: bold;
	}
</style>
<?php

$userID =  $this->session->userdata('userId');
$CheckSuperAdmin = $this->db->where('UserType', 'm')->where('User_SlNo', $userID)->get('tbl_user')->row();

$CheckAdmin = $this->db->where('UserType', 'a')->where('User_SlNo', $userID)->get('tbl_user')->row();

$userAccessQuery = $this->db->where('user_id', $userID)->get('tbl_user_access');
$access = [];
if ($userAccessQuery->num_rows() != 0) {
	$userAccess = $userAccessQuery->row();
	$access = json_decode($userAccess->access);
}

$companyInfo = $this->db->query("select * from tbl_company c order by c.Company_SlNo desc limit 1")->row();


$module = $this->session->userdata('module');
if ($module == 'dashboard' or $module == '') { ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<!-- Header Logo -->
			<div class="col-md-12 header" style="height: 130px;box-shadow:none;">
				<!-- style="border-radius: 20px;border: 1px solid #007ebb;box-shadow: 0px 5px 0px 0px #007ebb;" -->
				<img src="<?php echo base_url(); ?>assets/images/headerbg.jpg" style="border-radius: 20px;border: 1px solid #007ebb;box-shadow: 0px 5px 0px 0px #007ebb;" class="img img-responsive center-block">
			</div>
			<div class="col-md-10 col-md-offset-1">

				<div class="col-md-3 col-xs-6 section4">
					<div class="col-md-12 section122" style="background-color:#e6e6ff;" onmouseover="this.style.background = '#b9b9ff'" onmouseout="this.style.background = '#e6e6ff'">
						<a href="<?php echo base_url(); ?>module/propertyManagement">
							<div class="logo">
								<i class="fa fa-university"></i>
							</div>
							<div class="textModule">
								Property Management
							</div>
						</a>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 section4">
					<div class="col-md-12 section122" style="background-color:#e1e1ff;" onmouseover="this.style.background = '#d2d2ff'" onmouseout="this.style.background = '#e1e1ff'">
						<a href="<?php echo base_url(); ?>module/ClientManagement">
							<div class="logo">
								<i class="fa fa-male"></i>
							</div>
							<div class="textModule">
								Client Management
							</div>
						</a>
					</div>
				</div>

				<!-- module/AccountsModule -->
				<div class="col-md-3 col-xs-6 section4">
					<div class="col-md-12 section122" style="background-color:#A7ECFB;" onmouseover="this.style.background = '#85e6fa'" onmouseout="this.style.background = '#A7ECFB'">
						<a href="<?php echo base_url(); ?>module/UserManagement">
							<div class="logo">
								<i class="fa fa-user-plus"></i>
							</div>
							<div class="textModule">
								User Management
							</div>
						</a>
					</div>
				</div>

				<!-- module/HRPayroll -->
				<div class="col-md-3 col-xs-6 section4">
					<div class="col-md-12 section122" style="background-color:#ecffd9;" onmouseover="this.style.background = '#cfff9f'" onmouseout="this.style.background = '#ecffd9'">
						<a href="<?php echo base_url(); ?>module/HRPayroll">
							<div class="logo">
								<i class="fa fa-users"></i>
							</div>
							<div class="textModule">
								Human Resources
							</div>
						</a>
					</div>
				</div>

				<div class="col-md-3 col-xs-6 section4">
					<div class="col-md-12 section122" style="background-color:#d8ebeb;" onmouseover="this.style.background = '#bddddd'" onmouseout="this.style.background = '#d8ebeb'">
						<a href="<?php echo base_url(); ?>graph">
							<div class="logo">
								<i class="fa fa-bar-chart"></i>
							</div>
							<div class="textModule">
								Business View
							</div>
						</a>
					</div>
				</div>
			</div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div>

<?php } elseif ($module == 'UserManagement') { ?>

	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<!-- Header Logo -->
				<div class="col-md-12 header">
					<h3> UserManagement </h3>
				</div>
				<?php if (array_search("sms", $access) > -1 || (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>sms">
								<div class="logo">
									<i class="menu-icon fa fa-mobile"></i>
								</div>
								<div class="textModule">
									Send SMS
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("user", $access) > -1 || (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>user">
								<div class="logo">
									<i class="menu-icon fa fa-user-plus"></i>
								</div>
								<div class="textModule">
									User Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("user_activity", $access) > -1 || (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>user_activity">
								<div class="logo">
									<i class="menu-icon fa fa-list"></i>
								</div>
								<div class="textModule">
									User Activity
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($this->session->userdata('BRANCHid') == 1 && (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>companyProfile">
								<div class="logo">
									<i class="menu-icon fa fa-bank"></i>
								</div>
								<div class="textModule">
									Company Profile
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (isset($CheckSuperAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>database_backup">
								<div class="logo">
									<i class="menu-icon fa fa-database"></i>
								</div>
								<div class="textModule">
									Database Backup
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php } elseif ($module == 'ClientManagement') { ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="col-md-12 header">
					<h3> Client Management </h3>
				</div>

				<?php if (array_search("customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>customer">
								<div class="logo">
									<i class="menu-icon fa fa-male"></i>
								</div>
								<div class="textModule">
									Rent Lead Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("customerList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>customerList">
								<div class="logo">
									<i class="menu-icon fa fa-list"></i>
								</div>
								<div class="textModule">
									Rent Lead List
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("sale_customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>sale_customer">
								<div class="logo">
									<i class="menu-icon fa fa-male"></i>
								</div>
								<div class="textModule">
									Sale Lead Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("sale_customerList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>sale_customerList">
								<div class="logo">
									<i class="menu-icon fa fa-list"></i>
								</div>
								<div class="textModule">
									Sale Lead List
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php } elseif ($module == 'propertyManagement') { ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<!-- Header Logo -->
				<div class="col-md-12 header">
					<h3> Property Management </h3>
				</div>
				<?php if (array_search("property_entry", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>property_entry">
								<div class="logo">
									<i class="menu-icon fa fa-plus-square-o"></i>
								</div>
								<div class="textModule">
									Property Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>

				<?php if (array_search("property_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>property_list">
								<div class="logo">
									<i class="menu-icon fa fa-list"></i>
								</div>
								<div class="textModule">
									Property List
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>

				<?php if (array_search("floor", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>floor">
								<div class="logo">
									<i class="menu-icon fa fa-building-o"></i>
								</div>
								<div class="textModule">
									Floor Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("property_category", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>property_category">
								<div class="logo">
									<i class="menu-icon fa fa-plus-square"></i>
								</div>
								<div class="textModule">
									Category Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php } elseif ($module == 'HRPayroll') { ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<!-- Header Logo -->
				<div class="col-md-12 header">
					<h3> Human Resources </h3>
				</div>
				<?php if (array_search("salary_payment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>salary_payment">
								<div class="logo">
									<i class="menu-icon fa fa-money"></i>
								</div>
								<div class="textModule">
									Salary Payment
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("employee", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>employee">
								<div class="logo">
									<i class="menu-icon fa fa-users"></i>
								</div>
								<div class="textModule">
									Add Employee
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("emplists/all", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>emplists/all">
								<div class="logo">
									<i class="menu-icon fa fa-list-ol"></i>
								</div>
								<div class="textModule">
									All Employee List
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("designation", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>designation">
								<div class="logo">
									<i class="menu-icon fa fa-binoculars"></i>
								</div>
								<div class="textModule">
									Add Designation
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("depertment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>depertment">
								<div class="logo">
									<i class="menu-icon fa fa-plus-square"></i>
								</div>
								<div class="textModule">
									Add Department
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>

				<?php if (array_search("month", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>month">
								<div class="logo">
									<i class="menu-icon fa fa-calendar"></i>
								</div>
								<div class="textModule">
									Add Month
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>

				<?php if (array_search("salary_payment_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>salary_payment_report">
								<div class="logo">
									<i class="menu-icon fa fa-money"></i>
								</div>
								<div class="textModule" style="line-height: 13px; margin-top: 0;">
									Salary Payment Report
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php } ?>