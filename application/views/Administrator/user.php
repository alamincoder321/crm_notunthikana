<style>
	.password i {
		position: absolute;
		right: 10px;
		top: 6px;
		cursor: pointer;
	}
</style>
<span id="Edit_Product_form">
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="form-horizontal">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label" for="txtFirstName"> Full Name </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" name="txtFirstName" id="txtFirstName" placeholder="Full Name" value="" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="user_email"> User Email </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="email" name="user_email" id="user_email" onchange="check_email()" placeholder="User Email" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="type"> User Type </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<select style="padding:0px 2px;" class="chosen-select form-control" name="type" id="type">
								<option value="">Select User Type</option>
								<?php if ($this->session->userdata('accountType') == 'm') { ?>
									<option value="a">Admin</option>
								<?php } ?>
								<option value="e">Entry User</option>
								<option value="u">User</option>
							</select>
							<div id="type" class="col-md-12"></div>
						</div>
					</div>
					<?php
					$employees = $this->db->query("select * from tbl_employee where status = 'a'")->result();
					?>
					<div class="form-group">
						<label class="col-md-4 control-label" for="employeeId"> Hunter </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<select style="padding:0px 2px;" class="form-control" name="employeeId" id="employeeId">
								<option value="">Select Hunter</option>
								<?php foreach ($employees as $item) { ?>
									<option value="<?= $item->Employee_SlNo; ?>"><?= $item->Employee_Name; ?></option>
								<?php } ?>
							</select>
							<div id="employeeId" class="col-md-12"></div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label" for="username"> User name </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<input type="text" id="username" name="username" onchange="check_username()" placeholder="User name" class="form-control" />
							<div id="usermes" class="col-md-12"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="Password"> Password </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<p style="margin: 0;position:relative;width:100%;" class="password">
								<input type="password" id="assword" name="Password" placeholder="Password" class="form-control" required autocomplete="off" />
								<i class="fa fa-eye" onclick="passwordShow(event)"></i>
							</p>
							<div id="usermes" class="col-md-12"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="rePassword"> Re-Password </label>
						<label class="col-md-1 control-label">:</label>
						<div class="col-md-6">
							<p style="margin: 0;position:relative;width:100%;" class="password">
								<input type="password" id="rePassword" name="rePassword" placeholder="Re-Password" oninput="password()" class="form-control" required autocomplete="off" />
								<i class="fa fa-eye" onclick="passwordShow(event)"></i>
							</p>
							<div id="mes" class="col-md-12"></div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for=""> </label>
						<label class="col-md-1 control-label"></label>
						<div class="col-md-6 text-right">
							<button type="button" onclick="submit()" name="btnSubmit" title="Save" class="btn btn-md btn-success pull-left">
								Save
								<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</span>



<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>

		<div class="table-header">
			User Information
		</div>
	</div>

	<div class="col-xs-12" style="margin-top:5px;margin-bottom:5px;">

	</div>



	<div class="col-xs-12">
		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<span id="saveResult">
			<div class="table-responsive">
				<table id="dynamic-table" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Sl</th>
							<th>Name</th>
							<th class="hidden-480">Username</th>
							<th>User Email</th>
							<th>Type</th>
							<th>Status</th>
							<th>Under Leading</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$clauses = "";
						if ($this->session->userdata('accountType') == 'e' || $this->session->userdata('accountType') == 'u') {
							$userId = $this->session->userdata('userId');
							$clauses .= " and u.User_SlNo != 1";
							$clauses .= " and u.userId = '$userId'";
						}
						$query = $this->db->query("SELECT
													u.User_SlNo,
													u.User_ID,
													u.FullName,
													u.User_Name,
													u.UserEmail,
													u.userBrunch_id,
													u.UserType,
													u.status AS userstatus,
													br.brunch_id,
													br.Brunch_name,
													au.User_Name as underLeading
												FROM tbl_user u
												LEFT JOIN tbl_brunch br ON br.brunch_id = u.userBrunch_id
												INNER JOIN tbl_user au ON au.User_SlNo = u.userId 
												WHERE 1 = 1 $clauses");
						$results = $query->result();
						foreach ($results as $key => $row) {
						?>

							<tr>
								<td>
									<?php echo $key + 1; ?>
								</td>
								<td>
									<a href="#"><?php echo $row->FullName; ?></a>
								</td>
								<td class="hidden-480"><?php echo $row->User_Name; ?></td>
								<td><?php echo $row->UserEmail; ?></td>

								<td class="hidden-480">
									<span class="label label-md label-info arrowed arrowed-righ">
										<?php if ($row->UserType == 'm') {
											echo "Super Admin";
										} elseif ($row->UserType == 'a') {
											echo "Admin";
										} elseif ($row->UserType == 'e') {
											echo "Entry User";
										} else {
											echo "User";
										} ?>
									</span>
								</td>

								<td class="hidden-480">
									<?php if ($row->userstatus == 'a') { ?>
										<span class="label label-md label-info arrowed arrowed-righ" title="Active">
											Active
										</span>
									<?php } else { ?>
										<span class="label label-md label-danger arrowed arrowed-righ" title="Deactive">
											Deactive
										</span>
									<?php } ?>
								</td>

								<td><?php echo $row->underLeading; ?></td>


								<td>
									<div class="hidden-md hidden-xs action-buttons">
										<a class="blue" href="<?php echo base_url() . 'userEdit/' . $row->User_SlNo; ?>" onclick="return confirm('Are you sure you want to edit this user?');">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
										<?php if ($row->userstatus == 'a') { ?>
											<a class="red" href="<?php echo base_url() . 'userDeactive/' . $row->User_SlNo; ?>" onclick="return confirm('Are you sure you want to deactive this user?');" title="Deactive">
												<i class="ace-icon fa fa-arrow-circle-down bigger-130"></i>
											</a>
										<?php } else { ?>
											<a class="green" href="<?php echo base_url() . 'userActive/' . $row->User_SlNo; ?>" onclick="return confirm('Are you sure you want to active this user?');" title="Active">
												<i class="ace-icon fa fa-arrow-circle-up bigger-130"></i>
											</a>
										<?php } ?>

										<?php if ($row->UserType == 'u' || $row->UserType == 'e') { ?>
											<a title="User Access" class="blue" href="<?php echo base_url() . 'access/' . $row->User_SlNo; ?>">
												<i class="ace-icon fa fa-users bigger-130"></i>
											</a>
										<?php } ?>
									</div>
								</td>
							</tr>

						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</span>

	</div><!-- /.col -->
</div><!-- /.row -->


<script type="text/javascript">
	function password() {
		var pass = $("#assword").val();
		var passre = $("#rePassword").val();
		//alert(pass+passre);
		if (pass != passre) {
			$('#mes').html('Your password and confirm password do not match').css('color', 'red');
			return false;
		} else {
			$('#mes').html('Your password and confirm password matched').css('color', 'green');
			setTimeout(function() {
				$.fancybox.close();
			}, 1200);
		}

	}

	function onblurPassword() {
		var pass = $("#Password").val();
		var passre = $("#rePassword").val();
		//alert(pass+passre);
		if (pass != passre) {
			$('#mes').html('Your password and confirm password do not match').css('color', 'red');
			return false;
		} else {
			$('#mes').html('Your password and confirm password matched').css('color', 'green');
			//setTimeout( function() {$.fancybox.close(); },1200);
		}

	}
</script>

<script type="text/javascript">
	function submit() {
		var txtFirstName = $("#txtFirstName").val();
		if (txtFirstName == "") {
			$("#txtFirstName").css("border-color", "red");
			return false;
		} else {
			$("#txtFirstName").css("border-color", "green");
		}

		var user_email = $("#user_email").val();
		if (user_email == "") {
			$("#user_email").css("border-color", "red");
			return false;
		} else {
			$("#user_email").css("border-color", "green");
		}
		var username = $("#username").val();
		if (username == "") {
			$("#username").css("border-color", "red");
			return false;
		} else {
			$("#username").css("border-color", "green");
		}
		var assword = $("#assword").val();
		if (assword == "") {
			$("#assword").css("border-color", "red");
			return false;
		} else {
			$("#assword").css("border-color", "green");
		}
		var rePassword = $("#rePassword").val();
		if (rePassword == "") {
			$("#rePassword").css("border-color", "red");
			return false;
		} else {
			$("#rePassword").css("border-color", "green");
		}
		if (assword != rePassword) {
			$('#mes').html('Your password and confirm password do not match').css('color', 'red');
			return false;
		} else {
			$('#mes').html('Your password and confirm password matched').css('color', 'green');
			setTimeout(function() {
				$.fancybox.close();
			}, 1200);
		}
		// var Brunch= $("#Brunch").val();
		// if(Brunch==""){
		//     $("#Brunch").css("border-color","red");
		//     return false;
		// }else{
		//     $("#Brunch").css("border-color","green");
		// }
		var type = $("#type").val();
		if (type == "") {
			$("#type").css("border-color", "red");
			return false;
		} else {
			$("#type").css("border-color", "green");
		}

		var employeeId = $("#employeeId").val();
		if (employeeId == "") {
			$("#employeeId").css("border-color", "red");
			// return false;
		} else {
			$("#employeeId").css("border-color", "green");
		}


		var inputdata = 'employeeId=' + employeeId + '&username=' + username + '&rePassword=' + rePassword + '&txtFirstName=' + txtFirstName + '&user_email=' + user_email + '&Brunch=' + 1 + '&type=' + type;
		var urldata = "<?php echo base_url(); ?>userInsert";
		$.ajax({
			type: "POST",
			url: urldata,
			data: inputdata,
			success: function(data) {
				let r = JSON.parse(data);
				alert(r.message);
				if (r.success) {
					location.reload();
				}
			}
		});
	}
</script>

<script type="text/javascript">
	function check_username() {
		var username = document.getElementById("username").value;
		if (username) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Administrator/user_management/check_user_name/',
				data: {
					username: username,
				},
				success: function(response) {
					$('#usermes').html(response);
					if (response) {
						return true;
					} else {
						return false;
					}
				}
			});
		} else {
			$('#mes').html("");
			return false;
		}
	}

	function check_email() {
		var user_email = document.getElementById("user_email").value;
		if (user_email) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Administrator/user_management/check_email/',
				data: {
					user_email: user_email,
				},
				success: function(response) {
					$('#emailmes').html(response);
					if (response) {
						return true;
					} else {
						return false;
					}
				}
			});
		} else {
			$('#mes').html("");
			return false;
		}
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