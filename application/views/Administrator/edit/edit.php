<?php
$BRANCHid = $this->session->userdata('BRANCHid');
?>
<style>
    .password i {
        position: absolute;
        right: 10px;
        top: 6px;
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="txtFirstName"> Full Name </label>
                    <label class="col-md-1 control-label">:</label>
                    <div class="col-md-6">
                        <input type="text" name="txtFirstName" id="txtFirstName" value="<?php echo $selected->FullName; ?>" class="form-control" />
                        <input name="id" type="hidden" id="id" value="<?php echo $selected->User_SlNo; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="user_email"> User Email </label>
                    <label class="col-md-1 control-label">:</label>
                    <div class="col-md-6">
                        <input type="email" name="user_email" id="user_email" value="<?php echo $selected->UserEmail; ?>" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="type"> User Type </label>
                    <label class="col-md-1 control-label">:</label>
                    <div class="col-md-6">
                        <select style="padding:0px 2px;" class="chosen-select form-control" name="type" id="type">
                            <?php if ($this->session->userdata('accountType') == 'm') { ?>
                                <option value="a" <?= ($selected->UserType == 'a') ? 'selected' : false; ?>>Admin</option>
                            <?php } ?>
                            <option value="e" <?= ($selected->UserType == 'e') ? 'selected' : false; ?>>Entry User</option>
                            <option value="u" <?= ($selected->UserType == 'u') ? 'selected' : false; ?>>User</option>
                        </select>
                        <div id="brand_" class="col-md-12"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="username"> User name </label>
                    <label class="col-md-1 control-label">:</label>
                    <div class="col-md-6">
                        <input type="text" id="username" name="username" readonly onchange="check_username()" value="<?php echo $selected->User_Name; ?>" class="form-control" />
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
                        <input type="hidden" id="oldpassword" value="<?php echo $selected->User_Password; ?>" name="Password" />
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
                        <button type="button" onclick="Updatesubmit()" name="btnSubmit" title="Update" class="btn btn-md btn-success pull-left">
                            Update
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-12">
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>

        <div class="table-header">
            User Information
        </div>
    </div>

    <div class="col-md-12" style="margin-top:5px;margin-bottom:5px;">

    </div>



    <div class="col-md-12">
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
													br.Brunch_name
												FROM tbl_user u
												LEFT JOIN tbl_brunch br ON br.brunch_id = u.userBrunch_id
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

                                <td>
                                    <div class="hidden-md hidden-md action-buttons">
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
</script>
<script type="text/javascript">
    function Updatesubmit() {
        var username = $("#username").val();
        if (username == "") {
            $("#username").css("border-color", "red");
            return false;
        } else {
            $("#username").css("border-color", "green");
        }
        var assword = $("#assword").val();
        var rePassword = $("#rePassword").val();

        if (assword != "" && rePassword == "") {
            $("#rePassword").css("border-color", "red");
            return false;
        } else {
            $("#rePassword").css("border-color", "green");
        }

        if (assword != "" && rePassword != "") {
            if (assword != rePassword) {
                $('#mes').html('Your password and confirm password do not match').css('color', 'red');
                return false;
            } else {
                $('#mes').html('Your password and confirm password matched').css('color', 'green');
                setTimeout(function() {
                    $.fancybox.close();
                }, 1200);
            }
        }

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
        var type = $("#type").val();
        if (type == "") {
            $("#type").css("border-color", "red");
            return false;
        } else {
            $("#type").css("border-color", "green");
        }

        var id = $("#id").val();
        var oldpassword = $("#oldpassword").val();

        var inputdata = 'id=' + id + '&username=' + username + '&user_email=' + user_email + '&rePassword=' + rePassword + '&txtFirstName=' + txtFirstName + '&Brunch=' + 1 + '&type=' + type + '&oldpassword=' + oldpassword;
        var urldata = "<?php echo base_url(); ?>userUpdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function(data) {
                let r = JSON.parse(data);
                alert(r.message);
                if (r.success) {
                    window.location = "<?php echo base_url(); ?>user";
                }
            }
        });
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