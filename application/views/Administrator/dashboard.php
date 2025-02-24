<?php $this->load->view('Administrator/dashboard_style'); ?>
<style scoped>
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

	.card {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: 130px;
		border: 1px solid #ccc;
		border-radius: 4px;
		text-align: center;
		box-sizing: border-box;
		padding: 8px 5px;
	}

	.card strong {
		font-size: 22px;
		color: #000;
	}

	.card p {
		margin: 0;
		font-size: 22px;
		color: #000;
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



$today_rent_lead = $this->db->query("select count(*) as count from tbl_customer where status != 'd' and DATE_FORMAT(AddTime, '%Y-%m-%d') = ?", [date('Y-m-d')])->row()->count;
$total_rent_lead = $this->db->query("select count(*) as count from tbl_customer where status != 'd'")->row()->count;
$today_sale_lead = $this->db->query("select count(*) as count from tbl_sale_customer where status != 'd' and DATE_FORMAT(AddTime, '%Y-%m-%d') = ?", [date('Y-m-d')])->row()->count;
$total_sale_lead = $this->db->query("select count(*) as count from tbl_sale_customer where status != 'd'")->row()->count;

$pending_rent_lead = $this->db->query("select count(*) as count from tbl_customer where status = 'p'")->row()->count;
$active_rent_lead = $this->db->query("select count(*) as count from tbl_customer where status = 'a'")->row()->count;
$pending_sale_lead = $this->db->query("select count(*) as count from tbl_sale_customer where status = 'p'")->row()->count;
$active_sale_lead = $this->db->query("select count(*) as count from tbl_sale_customer where status = 'a'")->row()->count;

//rent
$call_rent_schedule = $this->db->query("select count(*) as count from tbl_rent_report where Status != 'd' and call_schedule is not null")->row()->count;
$visit_rent_schedule = $this->db->query("select count(*) as count from tbl_rent_report where Status != 'd' and visit_schedule is not null")->row()->count;
$reject_rent_report = $this->db->query("select count(*) as count from tbl_rent_report where Status != 'd' and report_status = 'j'")->row()->count;
$success_rent_report = $this->db->query("select count(*) as count from tbl_rent_report where Status != 'd' and report_status = 'a'")->row()->count;
//sale
$call_sale_schedule = $this->db->query("select count(*) as count from tbl_sale_report where Status != 'd' and call_schedule is not null")->row()->count;
$visit_sale_schedule = $this->db->query("select count(*) as count from tbl_sale_report where Status != 'd' and visit_schedule is not null")->row()->count;
$reject_sale_report = $this->db->query("select count(*) as count from tbl_sale_report where Status != 'd' and report_status = 'j'")->row()->count;
$success_sale_report = $this->db->query("select count(*) as count from tbl_sale_report where Status != 'd' and report_status = 'a'")->row()->count;



$module = $this->session->userdata('module');
if ($module == 'dashboard' or $module == '') { ?>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="col-md-12 header" style="height: 130px;box-shadow:none;">
				<img src="<?php echo base_url(); ?>assets/images/headerbg.jpg" style="border-radius: 20px;border: 1px solid #007ebb;box-shadow: 0px 5px 0px 0px #007ebb;" class="img img-responsive center-block">
			</div>
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="col-md-3">
						<?php
						$date = date('Y-m-d');
						?>
						<a style="text-decoration: none;" href="/customerList/<?= $date; ?>">
							<div class="card">
								<strong>Today Rent Lead</strong>
								<p><?= $today_rent_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a style="text-decoration: none;" href="/customerList">
							<div class="card">
								<strong>Total Rent Lead</strong>
								<p><?= $total_rent_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a style="text-decoration: none;" href="/sale_customerList/<?= $date; ?>">
							<div class="card">
								<strong>Today Sale Lead</strong>
								<p><?= $today_sale_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3">
						<a style="text-decoration: none;" href="/sale_customerList">
							<div class="card">
								<strong>Total Sale Lead</strong>
								<p><?= $total_sale_lead; ?></p>
							</div>
						</a>
					</div>

					<!-- report section -->
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="/pending_customerList">
							<div class="card">
								<strong>Pending Rent Lead</strong>
								<p><?= $pending_rent_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="/active_customerList">
							<div class="card">
								<strong>Active Rent Lead</strong>
								<p><?= $active_rent_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="pending_sale_customerList">
							<div class="card">
								<strong>Pending Sale Lead</strong>
								<p><?= $pending_sale_lead; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="active_sale_customerList">
							<div class="card">
								<strong>Active Sale Lead</strong>
								<p><?= $active_sale_lead; ?></p>
							</div>
						</a>
					</div>

					<!-- report section -->
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Rent Call Schedule</strong>
								<p><?= $call_rent_schedule; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Rent Visit Schedule</strong>
								<p><?= $visit_rent_schedule; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Reject Rent</strong>
								<p><?= $reject_rent_report; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;margin-bottom:8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Successful Rent</strong>
								<p><?= $success_rent_report; ?></p>
							</div>
						</a>
					</div>

					<div class="col-md-3" style="margin-top: 8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Sale Call Schedule</strong>
								<p><?= $call_sale_schedule; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Sale Visit Schedule</strong>
								<p><?= $visit_sale_schedule; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Reject Sale</strong>
								<p><?= $reject_sale_report; ?></p>
							</div>
						</a>
					</div>
					<div class="col-md-3" style="margin-top: 8px;">
						<a style="text-decoration: none;" href="">
							<div class="card">
								<strong>Successful Sale</strong>
								<p><?= $success_sale_report; ?></p>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 header"></div>
		</div>
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
									Rent Property Entry
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
									Rent Property List
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (array_search("sale_property", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>sale_property">
								<div class="logo">
									<i class="menu-icon fa fa-plus-square-o"></i>
								</div>
								<div class="textModule">
									Sale Property Entry
								</div>
							</a>
						</div>
					</div>
				<?php endif; ?>

				<?php if (array_search("sale_property_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<div class="col-md-2 col-xs-6 custom-padding ">
						<div class="col-md-12 section20">
							<a href="<?php echo base_url(); ?>sale_property_list">
								<div class="logo">
									<i class="menu-icon fa fa-list"></i>
								</div>
								<div class="textModule">
									Sale Property List
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