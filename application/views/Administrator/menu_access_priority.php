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
                    <li><input type="checkbox" class="access" value="customer" v-model="access"> Rent Client Entry</li>
                    <li><input type="checkbox" class="access" value="customerList" v-model="access"> Rent Client List</li>
                    <li><input type="checkbox" class="access" value="pending_customerList" v-model="access"> Pending Rent Client List</li>
                    <li><input type="checkbox" class="access" value="active_customerList" v-model="access"> Active Rent Client List</li>
                    <li><input type="checkbox" class="access" value="sale_customer" v-model="access"> Sale Client Entry</li>
                    <li><input type="checkbox" class="access" value="sale_customerList" v-model="access"> Sale Client List</li>
                    <li><input type="checkbox" class="access" value="pending_sale_customerList" v-model="access"> Pending Sale Client List</li>
                    <li><input type="checkbox" class="access" value="active_sale_customerList" v-model="access"> Active Sale Client List</li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="property" class="group-head" @click="onClickGroupHeads"> <strong>Property Management</strong>
                <ul ref="property">
                    <li><input type="checkbox" class="access" value="property_entry" v-model="access"> Rent Property Entry </li>
                    <li><input type="checkbox" class="access" value="property_list" v-model="access"> Rent Property List </li>
                    <li><input type="checkbox" class="access" value="sale_property" v-model="access"> Sale Property Entry </li>
                    <li><input type="checkbox" class="access" value="sale_property_list" v-model="access"> Sale Property List </li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="property" class="group-head" @click="onClickGroupHeads"> <strong>Common Section</strong>
                <ul ref="property">
                    <li><input type="checkbox" class="access" value="property_category" v-model="access"> Category Entry </li>
                    <li><input type="checkbox" class="access" value="sqft" v-model="access"> Sqft Entry </li>
                    <li><input type="checkbox" class="access" value="zone" v-model="access"> Zone Entry </li>
                    <li><input type="checkbox" class="access" value="floor" v-model="access"> Floor Entry </li>
                    <li><input type="checkbox" class="access" value="gas" v-model="access"> Gas Entry </li>
                    <li><input type="checkbox" class="access" value="lift" v-model="access"> Lift Entry </li>
                    <li><input type="checkbox" class="access" value="bath" v-model="access"> Generator Entry </li>
                    <li><input type="checkbox" class="access" value="bed" v-model="access"> Bed Entry </li>
                    <li><input type="checkbox" class="access" value="sbed" v-model="access"> S.Bed Entry </li>
                    <li><input type="checkbox" class="access" value="bath" v-model="access"> Bath Entry </li>
                    <li><input type="checkbox" class="access" value="sbath" v-model="access"> S.Bath Entry </li>
                    <li><input type="checkbox" class="access" value="drawing" v-model="access"> Drawing Entry </li>
                    <li><input type="checkbox" class="access" value="balcony" v-model="access"> Balcony Entry </li>
                    <li><input type="checkbox" class="access" value="apt_face" v-model="access"> Apt. Face Entry </li>
                    <li><input type="checkbox" class="access" value="apt_type" v-model="access"> Apt. Type Entry </li>
                    <li><input type="checkbox" class="access" value="apt_status" v-model="access"> Apt. Status Entry </li>
                    <li><input type="checkbox" class="access" value="budget" v-model="access"> Budget Entry </li>
                    <li><input type="checkbox" class="access" value="month" v-model="access"> Month Entry </li>
                    <li><input type="checkbox" class="access" value="condition" v-model="access"> Condition Entry </li>
                    <li><input type="checkbox" class="access" value="member" v-model="access"> Member Entry </li>
                    <li><input type="checkbox" class="access" value="parking" v-model="access"> Parking Entry </li>
                    <li><input type="checkbox" class="access" value="source" v-model="access"> Source Entry </li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
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
            <div class="text-right">
                <button class="btn btn-success" @click="addUserAccess">Save</button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="accountsReports" class="group-head" @click="onClickGroupHeads"> <strong>User Management</strong>
                <ul ref="accountsReports">
                    <li><input type="checkbox" class="access" value="user" v-model="access"> User</li>
                    <li><input type="checkbox" class="access" value="user_activity" v-model="access"> User Activity</li>
                    <li><input type="checkbox" class="access" value="companyProfile" v-model="access"> companyProfile </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-success" @click="addUserAccess">Save</button>
        </div>
    </div> -->
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