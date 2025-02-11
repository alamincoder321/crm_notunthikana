<style>
    #userAccess * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
    }

    #userAccess h2 {
        font-size: 16px;
        font-weight: bold;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        text-transform: uppercase;
        padding: 5px;
    }

    #userAccess ul {
        list-style: none;
        margin-left: 17px;
    }
</style>
<div id="userAccess">
    <div class="row">
        <div class="col-md-12 text-center">
            <div>
                <h2>User Access</h2>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <input type="checkbox" @click="checkAll" id="selectAll"> <strong style="font-size: 16px;">Select All</strong>
        </div>
    </div>
    <div class="row" id="accessRow">
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="sales" class="group-head" @click="onClickGroupHeads"> <strong>Client Management</strong>
                <ul ref="sales">
                    <li><input type="checkbox" class="access" value="customer" v-model="access"> Client Entry</li>
                    <li><input type="checkbox" class="access" value="customerlist/All" v-model="access"> Client List</li>
                    <li><input type="checkbox" class="access" value="report_entry" v-model="access"> Report Entry</li>
                    <li><input type="checkbox" class="access" value="report_list" v-model="access"> Report List</li>
                    <li><input type="checkbox" class="access" value="next_call_reminder" v-model="access"> Call Reminder </li>
                    <li><input type="checkbox" class="access" value="meeting_reminder" v-model="access"> Meeting Reminder</li>
                    <li><input type="checkbox" class="access" value="meeting_report" v-model="access"> Meeting Report</li>
                    <li><input type="checkbox" class="access" value="area" v-model="access"> Add Area</li>
                    <li><input type="checkbox" class="access" value="source" v-model="access"> Add Source</li>
                    <li><input type="checkbox" class="access" value="type" v-model="access"> Add Client Stage</li>
                    <li><input type="checkbox" class="access" value="category" v-model="access"> Add Category</li>
                    <li><input type="checkbox" class="access" value="sms" v-model="access"> Send SMS</li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="land" class="group-head" @click="onClickGroupHeads"> <strong>Land Management</strong>
                <ul ref="land">
                    <li><input type="checkbox" class="access" value="land_entry" v-model="access"> Land Entry </li>
                    <li><input type="checkbox" class="access" value="landRecord" v-model="access"> Land Record </li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="property" class="group-head" @click="onClickGroupHeads"> <strong>Property Management</strong>
                <ul ref="property">
                    <li><input type="checkbox" class="access" value="property_entry" v-model="access"> Property Entry </li>
                    <li><input type="checkbox" class="access" value="property_list" v-model="access"> Property List </li>
                    <li><input type="checkbox" class="access" value="property_report_list" v-model="access"> Property Report List </li>
                    <li><input type="checkbox" class="access" value="property_report_reminder" v-model="access"> Property Report Reminder</li>
                    <li><input type="checkbox" class="access" value="popular_property" v-model="access"> Popular Property</li>
                    <li><input type="checkbox" class="access" value="floor" v-model="access"> Floor Entry </li>
                    <li><input type="checkbox" class="access" value="propertyType" v-model="access"> Property Type Entry </li>
                    <li><input type="checkbox" class="access" value="purpose" v-model="access"> Purpose Entry </li>
                    <li><input type="checkbox" class="access" value="property_category" v-model="access"> Property Category Entry </li>
                    <li><input type="checkbox" class="access" value="block" v-model="access"> Block Entry </li>
                    <li><input type="checkbox" class="access" value="lift" v-model="access"> Lift Entry </li>
                    <li><input type="checkbox" class="access" value="building_height" v-model="access"> Building Height Entry </li>
                    <li><input type="checkbox" class="access" value="occupancy" v-model="access"> Occupancy Entry </li>
                    <li><input type="checkbox" class="access" value="viewing_availability" v-model="access"> Availability Entry </li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="activity" class="group-head" @click="onClickGroupHeads"> <strong>Activity Management</strong>
                <ul ref="activity">
                    <li><input type="checkbox" class="access" value="activity_entry" v-model="access"> Activity Entry </li>
                    <li><input type="checkbox" class="access" value="activity_report" v-model="access"> Activity Report </li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="hrPayroll" class="group-head" @click="onClickGroupHeads"> <strong>HR & Payroll</strong>
                <ul ref="hrPayroll">
                    <li><input type="checkbox" class="access" value="salary_payment" v-model="access"> Salary Payment</li>
                    <li><input type="checkbox" class="access" value="employee" v-model="access"> Add Employee</li>
                    <li><input type="checkbox" class="access" value="emplists/all" v-model="access"> All Employee List</li>
                    <li><input type="checkbox" class="access" value="emplists/active" v-model="access"> Active Employee List</li>
                    <li><input type="checkbox" class="access" value="emplists/deactive" v-model="access"> Deactive Employee List</li>
                    <li><input type="checkbox" class="access" value="designation" v-model="access"> Add Designation</li>
                    <li><input type="checkbox" class="access" value="depertment" v-model="access"> Add Department</li>
                    <li><input type="checkbox" class="access" value="month" v-model="access"> Add Month</li>
                    <li><input type="checkbox" class="access" value="salary_payment_report" v-model="access"> Salary Payment Report</li>
                </ul>
            </div>

        </div>

        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="accountsReports" class="group-head" @click="onClickGroupHeads"> <strong>User Management</strong>
                <ul ref="accountsReports">
                    <li><input type="checkbox" class="access" value="user" v-model="access"> User</li>
                    <li><input type="checkbox" class="access" value="user_activity" v-model="access">User Activity</li>
                    <li><input type="checkbox" class="access" value="notice" v-model="access"> Notice </li>
                    <li><input type="checkbox" class="access" value="graph" v-model="access"> Business View </li>
                    <li><input type="checkbox" class="access" value="companyProfile" v-model="access"> companyProfile </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-success" @click="addUserAccess">Save</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#userAccess',
        data() {
            return {
                userId: parseInt('<?php echo $userId; ?>'),
                access: []
            }
        },
        mounted() {
            let accessCheckboxes = document.querySelectorAll('.access');
            accessCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', () => {
                    this.makeChecked();
                })
            })
        },
        async created() {
            await axios.post('/get_user_access', {
                userId: this.userId
            }).then(res => {
                let r = res.data;
                if (r != '') {
                    this.access = JSON.parse(r);
                }
            })
            this.makeChecked();
        },
        methods: {
            makeChecked() {
                groups = document.querySelectorAll('.group');
                groups.forEach(group => {
                    let groupHead = group.querySelector('.group-head');
                    let accessCheckboxes = group.querySelectorAll('ul li input').length;
                    let checkedAccessCheckBoxes = group.querySelectorAll('ul li input:checked').length;
                    if (accessCheckboxes == checkedAccessCheckBoxes) {
                        groupHead.checked = true;
                    } else {
                        groupHead.checked = false;
                    }
                })

                let selectAllCheckbox = document.querySelector('#selectAll');
                let totalAccessCheckboxes = document.querySelectorAll('.access').length;
                let totalCheckedAccessCheckBoxes = document.querySelectorAll('.access:checked').length;

                if (totalAccessCheckboxes == totalCheckedAccessCheckBoxes) {
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.checked = false;
                }
            },
            async onClickGroupHeads() {
                let groupHead = event.target;
                let ul = groupHead.parentNode.querySelector('ul');
                let accessCheckboxes = ul.querySelectorAll('li input');

                if (groupHead.checked) {
                    accessCheckboxes.forEach(checkbox => {
                        this.access.push(checkbox.value);
                    })
                } else {
                    accessCheckboxes.forEach(checkbox => {
                        let ind = this.access.findIndex(a => a == checkbox.value);
                        this.access.splice(ind, 1);
                    })
                }
                this.access = this.access.filter((v, i, a) => a.indexOf(v) === i);
                await new Promise(r => setTimeout(r, 200));
                this.makeChecked();
            },
            async checkAll() {
                if (event.target.checked) {
                    let accessCheckboxes = document.querySelectorAll('.access');
                    accessCheckboxes.forEach(checkbox => {
                        this.access.push(checkbox.value)
                    })
                } else {
                    this.access = [];
                }
                this.access = this.access.filter((v, i, a) => a.indexOf(v) === i);
                await new Promise(r => setTimeout(r, 200));
                this.makeChecked();
            },
            addUserAccess() {
                let data = {
                    userId: this.userId,
                    access: this.access
                }
                axios.post('/add_user_access', data).then(res => {
                    let r = res.data;
                    alert(r.message);
                })
            }
        }
    })
</script>