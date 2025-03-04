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

$module = $this->session->userdata('module');
if ($module == 'dashboard' or $module == '') {
?>
	<ul class="nav nav-list">
		<li class="active">
			<!-- module/dashboard -->
			<a href="<?php echo base_url(); ?>">
				<i class="menu-icon fa fa-th"></i>
				<span class="menu-text"> Dashboard </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>module/propertyManagement">
				<i class="menu-icon fa fa-university"></i>
				<span class="menu-text" style="font-size: 12px;"> Property Management </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>module/ClientManagement">
				<i class="menu-icon fa fa-male" style="font-size:23px;"></i>
				<span class="menu-text"> Client Management </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<!--  -->
			<a href="<?php echo base_url(); ?>module/UserManagement">
				<i class="menu-icon fa fa fa-user-plus" style="font-size: 16px;"></i>
				<span class="menu-text"> User Management </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<!-- module/HRPayroll -->
			<a href="<?php echo base_url(); ?>module/HRPayroll">
				<i class="menu-icon fa fa-users"></i>
				<span class="menu-text"> Human Resources </span>
			</a>
			<b class="arrow"></b>
		</li>

		<?php if (array_search("companyProfile", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>companyProfile">
					<i class="menu-icon fa fa-university"></i>
					<span class="menu-text"> Company Profile </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>
		
		<?php if (array_search("cs_customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>cs_customer">
					<i class="menu-icon fa fa-user"></i>
					<span class="menu-text"> CS Entry </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

	</ul>
<?php } elseif ($module == 'UserManagement') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-th"></i>
				<span class="menu-text"> Dashboard </span>
			</a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/UserManagement" style="background:gray !important;" class="module_title">
				<span>UserManagement</span>
			</a>
		</li>

		<?php if (array_search("user", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>user">
					<i class="menu-icon fa fa-user-plus"></i>
					<span class="menu-text"> User Entry </span>
				</a>
			</li>
		<?php endif; ?>



		<?php if (array_search("user_activity", $access) > -1 || isset($CheckSuperAdmin) && $this->session->userdata('BRANCHid') == 1) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>user_activity">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> User Activity</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($this->session->userdata('BRANCHid') == 1 && (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>companyProfile">
					<i class="menu-icon fa fa-bank"></i>
					<span class="menu-text"> Company Profile </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

	</ul>

<?php } elseif ($module == 'ClientManagement') { ?>
	<ul class="nav nav-list">

		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-th"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/ClientManagement" style="background:gray !important;" class="module_title">
				<span> Client Management </span>
			</a>
		</li>

		<?php if (array_search("customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>customer">
					<i class="menu-icon fa fa-male"></i>
					<span class="menu-text"> Rent Lead Entry </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>


		<?php if (array_search("customerList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>customerList">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> Rent Lead List </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>
		<?php if (array_search("sale_customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sale_customer">
					<i class="menu-icon fa fa-male"></i>
					<span class="menu-text"> Sale Lead Entry </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>


		<?php if (array_search("sale_customerList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sale_customerList">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> Sale Lead List </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>
	</ul>
<?php } elseif ($module == 'propertyManagement') { ?>
	<ul class="nav nav-list">

		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-th"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/propertyManagement" style="background:gray !important;" class="module_title">
				<span style="font-size: 14px;"> Property Management </span>
			</a>
		</li>

		<?php if (array_search("property_entry", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>property_entry">
					<i class="menu-icon fa fa-plus-square-o"></i>
					<span class="menu-text"> Rent Property Entry </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>
		<?php if (array_search("property_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>property_list">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> Rent Property List </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("sale_property", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sale_property">
					<i class="menu-icon fa fa-plus-square-o"></i>
					<span class="menu-text"> Sale Property Entry </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("sale_property_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sale_property_list">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> Sale Property List </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

	</ul>

<?php } elseif ($module == 'HRPayroll') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-th"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/HRPayroll" style="background:gray !important;" class="module_title">
				<span>Human Resources</span>
			</a>
		</li>

		<?php if (array_search("salary_payment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>salary_payment">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text"> Salary Payment </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("employee", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>employee">
					<i class="menu-icon fa fa-users"></i>
					<span class="menu-text"> Add Employee </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("designation", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>designation">
					<i class="menu-icon fa fa-binoculars"></i>
					<span class="menu-text"> Add Designation </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("depertment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>depertment">
					<i class="menu-icon fa fa-plus-square"></i>
					<span class="menu-text"> Add Department </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("month", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>month">
					<i class="menu-icon fa fa-calendar"></i>
					<span class="menu-text"> Add Month </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("emplists/all", $access) > -1
			|| array_search("emplists/active", $access) > -1
			|| array_search("emplists/deactive", $access) > -1
			|| array_search("salary_payment_report", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> Report </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("emplists/all", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/all">
								<i class="menu-icon fa fa-caret-right"></i>
								All Employee List
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("emplists/active", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/active">
								<i class="menu-icon fa fa-caret-right"></i>
								Active Employee List
							</a>
							<b class="arrow"></b>
						</li>
						<?php endif; ?><?php if (array_search("emplists/deactive", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/deactive">
								<i class="menu-icon fa fa-caret-right"></i>
								Deactive Employee List
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("salary_payment_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salary_payment_report">
								<i class="menu-icon fa fa-caret-right"></i>
								Salary Payment Report
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>

	</ul>
<?php } ?>