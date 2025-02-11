<style scoped>
    .v-select {
        margin-bottom: 5px;
        float: right;
        min-width: 200px;
        margin-left: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 25px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }
</style>
<div id="customerListReport">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 5px 0;">
        <div class="col-md-12">
            <form class="form-inline" @submit.prevent="getCustomers">
                <div class="form-group">
                    <label>Search Type</label>
                    <select class="form-select" @change="onChangeType" style="padding: 1px 6px;width:150px;height:26px;" v-model="searchType">
                        <option value="">All</option>
                        <option value="customer">By Client</option>
                        <option value="mobile">By Mobile</option>
                        <option value="Pending">Pending</option>
                        <option value="Active">Active</option>
                        <option value="Land">Land</option>
                    </select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' ? '' : 'none'}">
                    <label>Employee</label>
                    <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
                </div>
                <div class="form-group" v-if="userType != 'u'">
                    <label>EntryBy</label>
                    <v-select v-bind:options="entries" v-model="selectedEntry" label="FullName"></v-select>
                </div>
                <div class="form-group" v-if="userType != 'u'">
                    <label>AssignBy</label>
                    <v-select v-bind:options="users" v-model="selectedUser" label="User_Name"></v-select>
                </div>
                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'mobile' ? '' : 'none'}">
                    <label>Mobile</label>
                    <input type="text" class="form-control" v-model="Customer_Mobile" />
                </div>
                <div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'customer' ? '' : 'none'}">
                    <label>Client</label>
                    <v-select v-bind:options="customers1" v-model="selectedCustomer" label="Customer_Name"></v-select>
                </div>

                <div class="form-group">
                    <label for="">Client. Type</label>
                    <select name="Customer_Type" style="padding: 1px 6px;width:80px;height:26px;" id="type" v-model="Customer_Type">
                        <option value="">All</option>
                        <option value="Sale">Sale</option>
                        <option value="Rent">Rent</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Next_Call_Date</label>
                    <input type="date" class="form-control" v-model="next_call_date">
                </div>

                <div class="form-group">
                    <label for="">Next_Meeting_Date</label>
                    <input type="date" class="form-control" v-model="next_meeting_date">
                </div>
                <div class="form-group">
                    <label for="">From</label>
                    <input type="date" class="form-control" v-model="dateFrom">
                </div>

                <div class="form-group">
                    <label for="">To</label>
                    <input type="date" class="form-control" v-model="dateTo">
                </div>

                <div class="form-group" style="margin-top: -1px">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
    </div>
    <div style="display:none;margin-top:3px;" v-bind:style="{display: customers.length > 0 ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;display: flex;justify-content: space-between;">
                <a href="" @click.prevent="print" style="margin: 0;display:none;"><i class="fa fa-print"></i> Print</a>
                <a v-if="userType == 'a' || userType == 'm'" :href="`/download_customer/${dateFrom}/${dateTo}`" style="margin: 0;"><i class="fa fa-file-excel-o"></i> Download</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="printContent">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <th>Sl</th>
                            <th>Client_Id</th>
                            <th>Client_Entry_Date</th>
                            <th>Client_Name</th>
                            <th>Client_Type</th>
                            <th>Property</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Area</th>
                            <th>Client_Stage</th>
                            <th>Source</th>
                            <th>Employee</th>
                            <th>Status</th>
                            <th>User_Status</th>
                            <th>Next_Meeting_Date</th>
                            <th>Next_Call_Date</th>
                            <th>Entry_By</th>
                            <th>AssignBy</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, sl) in customers" :style="{background: customer.status == 'p' ? '#D15B47' : ''}">
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ sl + 1 }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Code }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.AddTime | dateFormat('DD-MM-YYYY') }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Name }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Type }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Property_Name }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Mobile }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Email }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Customer_Address }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.District_Name }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.type_name }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.source_name }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.Employee_Name }}</td>
                                <td v-html="statusText(customer.status)"></td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}" v-html="customer.customer_status"></td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.next_meeting_date | dateFormat('DD-MM-YYYY') }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.latest_call_date | dateFormat('DD-MM-YYYY') }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.AddBy }}</td>
                                <td :style="{color: customer.status == 'p' ? 'white !important' : ''}">{{ customer.User_Name }}</td>
                                <td><a href="javascript:" @click="modalOpen(customer)"><i style="font-size: 20px;" class="fa fa-envelope-o"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="display:none;text-align:center;" v-bind:style="{display: customers.length > 0 ? 'none' : ''}">
        No records found
    </div>

    <div class="modal" tabindex="-1" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="display: flex;align-items:center;justify-content:space-between;background: #ceefff;">
                    <h3 style="padding:0;margin: 0; width:80%;text-align:left;" class="modal-title"> {{ customer.Customer_Code }} - {{ customer.Customer_Name }}</h3>
                    <p style="padding:0;margin: 0; width:20%;font-size:20px;text-align:right;cursor:pointer;" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i class="fa fa-times"></i></p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <img :src="`/${customer.image_name ? customer.image_name : '/uploads/nouserImage.jpg'}`" style="width: 120px; height: 100px; border: 1px solid gray; border-radius: 5px;" alt="">
                        </div>
                        <div class="col-md-10 col-xs-12">
                            <form @submit.prevent="updateCustomer">
                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Meeting Date:</label>
                                    <div class="col-md-9">
                                        <input type="datetime-local" class="form-control" v-model="customer.next_meeting_date">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Next Call Date:</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" v-model="customer.latest_call_date">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Client Status:</label>
                                    <div class="col-md-9">
                                        <input type="radio" name="client_status" value="Active" v-model="customer.customer_status"> Active
                                        <input type="radio" name="client_status" value="Deactive" v-model="customer.customer_status"> Deactive
                                        <input type="radio" name="client_status" value="Sale" v-model="customer.customer_status"> Sale
                                        <input type="radio" name="client_status" value="Rent" v-model="customer.customer_status"> Rent
                                        <input type="radio" name="client_status" value="Land" v-model="customer.customer_status"> Land
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label col-md-3">Stage:</label>
                                    <div class="col-md-9">
                                        <v-select v-bind:options="types" style="width:100%;" v-model="selectedType" label="type_name"></v-select>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-md-12 text-right">
                                        <input type="submit" class="btn btn-success btn-sm" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12">
                            <form @submit.prevent="saveReport" style="border: 1px solid gray;margin-top: 15px;">
                                <h3 style="margin: 0px; text-align: center; border-bottom: 1px solid gray; background: #00ffff3d;">Reports Entry</h3>
                                <div class="row" style="margin-top: 10px;margin-bottom:15px;">
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-4">Report Date:</label>
                                            <div class="col-md-8">
                                                <input type="date" class="form-control" v-model="report.report_date" required @change="getReports">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-4"> Followup Step:</label>
                                            <div class="col-md-8">
                                                <input type="radio" name="status" value="Pending" v-model="report.client_status"> Pending
                                                <input type="radio" name="status" value="Active" v-model="report.client_status"> Active
                                                <input type="radio" name="status" value="Following" v-model="report.client_status"> Following
                                                <input type="radio" name="status" value="Prospect" v-model="report.client_status"> Prospect
                                                <input type="radio" name="status" value="Visiting" v-model="report.client_status"> Visiting
                                                <input type="radio" name="status" value="Meeting" v-model="report.client_status"> Meeting
                                                <input type="radio" name="status" value="Done" v-model="report.client_status"> Done
                                            </div>
                                        </div>

                                        <div class="form-group clearfix" style="display: none;">
                                            <label class="control-label col-md-4">File:</label>
                                            <div class="col-md-8">
                                                <input type="file" @change="previewImage" />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-4">Client Commu.:</label>
                                            <div class="col-md-8">
                                                <textarea v-model="report.note" cols="15" rows="5" style="height: unset; width: 100%;"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <div class="col-md-7 col-md-offset-4">
                                                <input type="submit" class="btn btn-success btn-sm" value="Save">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive" id="printContent" style="margin-top: 4px;">
                        <h3 class="text-center" style="margin: 0px; border-bottom: 1px solid gray;border-top: 1px solid gray; background: #00ffff3d;">Reports List</h3>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <th>Sl</th>
                                <th>Report Date</th>
                                <th>User</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="(report, sl) in reports">
                                    <td>{{sl+1}}</td>
                                    <td>{{report.report_date | dateFormat('DD-MM-YYYY')}}</td>
                                    <td>{{report.User_Name}}</td>
                                    <td>{{report.note}}</td>
                                    <td>{{report.client_status}}</td>
                                    <td>
                                        <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                            <button type="button" class="button edit" @click="editReport(report)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="button" @click="deleteReport(report.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- access modal here -->
    <div class="modal accessModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" style="width:95%;margin: 0;">Management permission needed...</h5>
                    <button type="button" style="width: 5%; margin: 0px; display: flex; align-items: center; justify-content: end;" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin: 0;font-size: 20px;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="password" class="form-control" v-model="otp" placeholder="otp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="editAccess" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#customerListReport',
        data() {
            return {
                searchType: '',
                Customer_Type: '',
                dateFrom: moment().format("YYYY-MM-DD"),
                dateTo: moment().format("YYYY-MM-DD"),
                next_call_date: "",
                next_meeting_date: "",
                Customer_Mobile: '',
                customers: [],
                customers1: [],
                selectedCustomer: null,
                customer: {},
                reports: [],
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
                status: '<?= $status ?>',
                categories: [],
                selectedCategory: null,

                // reports entry
                report: {
                    id: 0,
                    report_date: moment().format('YYYY-MM-DD'),
                    client_id: null,
                    employee_id: null,
                    report_status: 'Pending',
                    user_id: null,
                    note: '',
                    client_status: 'Pending',
                },
                selectedFile: null,
                employees: [],
                selectedEmployee: null,
                entries: [],
                selectedEntry: null,
                users: [],
                selectedUser: null,
                types: [],
                selectedType: null,

                otp: '',
				editaccess: false,
				reportInfo: {}

            }
        },
        filters: {
            dateFormat(dt, format) {
                return dt == null || dt == '' ? "" : moment(dt).format(format);
            }
        },
        created() {
            this.getUsers();
            this.getEntry();
            this.getCategories();
            this.getEmployees();
            this.getCustomers();
            this.getCustomerList();
            this.getTypes();
        },
        methods: {
            statusText(txt) {
                if (txt == 'a') {
                    txt = "<span class='badge badge-success'>Active</span>"
                } else {
                    txt = "<span class='badge badge-danger'>Pending</span>"
                }
                return txt;
            },
            getTypes() {
                axios.get('/get_types').then(res => {
                    this.types = res.data;
                })
            },
            getUsers() {
                axios.get('/get_users').then(res => {
                    if (this.userType == 'm' || this.userType == 'a') {
                        this.users = res.data.filter(item => item.User_SlNo != 1);
                    } else if (this.userType == 'e') {
                        this.users = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
                    }
                })
            },
            getEntry() {
                axios.get('/get_users').then(res => {
                    if (this.userType == 'm' || this.userType == 'a') {
                        this.entries = res.data.filter(item => item.User_SlNo != 1);
                    } else if (this.userType == 'e') {
                        this.entries = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
                    }
                })
            },
            getCustomerList() {
                axios.post('/get_customers', {
                    user_id: this.userType == 'u' || this.userType == 'e' ? this.userId : null
                }).then(res => {
                    this.customers1 = res.data;
                })
            },
            getCategories() {
                axios.get('/get_categories').then(res => {
                    this.categories = res.data;
                })
            },
            getEmployees() {
                axios.get('/get_employees').then(res => {
                    this.employees = res.data;
                })
            },
            onChangeType() {
                this.selectedCategory = null;
                this.selectedUser = null;
                this.selectedEntry = null;
                this.selectedCustomer = null;
                this.selectedTypes = null;
                this.Customer_Mobile = '';
            },
            async modalOpen(customer) {
                this.customer = customer;
                this.selectedType = {
                    id: customer.type_id,
                    type_name: customer.type_name
                }
                await this.getReports();
                $('#exampleModal').modal('show');
            },
            async getReports() {
                let filter = {
                    client_id: this.customer.Customer_SlNo,
                }

                let url = '/get_reports';

                await axios.post(url, filter)
                    .then(res => {
                        this.reports = res.data;
                    })
            },
            getCustomers() {
                let filter = {
                    category_id: this.selectedCategory == null ? '' : this.selectedCategory.ProductCategory_SlNo,
                    customerId: this.selectedCustomer == null ? '' : this.selectedCustomer.Customer_SlNo,
                    employeeId: this.selectedEmployee == null ? '' : this.selectedEmployee.Employee_SlNo,
                    Customer_Mobile: this.Customer_Mobile,
                    customerType: this.Customer_Type,
                    user_id: this.userType == 'e' ? this.selectedUser == null ? this.userId : this.selectedUser.User_SlNo : this.userType == 'u' ? this.userId : null,
                    AddBy: this.selectedEntry == null ? '' : this.selectedEntry.FullName,
                    next_call_date: this.next_call_date,
                    next_meeting_date: this.next_meeting_date,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                if(this.userType == 'm' || this.userType == 'a'){
                    filter.user_id = this.selectedUser == null ? "" : this.selectedUser.User_SlNo;
                }
                if (this.searchType == 'Active' || this.searchType == 'Pending' || this.searchType == 'Sale' || this.searchType == 'Rent' || this.searchType == 'Land') {
                    filter.customer_status = this.searchType
                }
                axios.post('/get_customers', filter).then(res => {
                    this.customers = res.data;
                })
            },            
            async updateCustomer() {
                let customer = {
                    Customer_SlNo: this.customer.Customer_SlNo,
                    Customer_Mobile: this.customer.Customer_Mobile,
                    next_meeting_date: this.customer.next_meeting_date,
                    latest_call_date: this.customer.latest_call_date,
                    customer_status: this.customer.customer_status,
                    client_status: this.customer.client_status,
                    type_id: this.selectedType == null ? "" : this.selectedType.id
                }

                let fd = new FormData();
                fd.append('data', JSON.stringify(customer));

                axios.post('/update_customer', fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.getCustomers();
                })
            },


            saveReport() {
                if (this.report.note == '') {
                    alert("Message is empty");
                    return;
                }
                this.report.client_id = this.customer.Customer_SlNo;
                this.report.employee_id = this.selectedEmployee ? this.selectedEmployee.Employee_SlNo : null;
                this.report.user_id = this.userId;

                let url = '/add_report';
                if (this.report.id != 0) {
                    url = '/update_report';
                }

                let fd = new FormData();
                fd.append('image', this.selectedFile);
                fd.append('data', JSON.stringify(this.report));

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.getCustomers();
                    let findIndex = this.customers.findIndex(item => item.Customer_SlNo == this.report.client_id);
                    this.modalOpen(this.customers[findIndex]);

                    this.report = {
                        id: 0,
                        report_date: moment().format('YYYY-MM-DD'),
                        client_id: null,
                        employee_id: null,
                        report_status: 'Pending',
                        client_status: 'Pending',
                        user_id: null,
                        note: '',
                    }
                    this.editaccess = false;
                })
            },

            editReport(report) {
                this.reportInfo = report;
				if (this.editaccess == false) {
					$(".accessModal").modal('show');
					return;
				}

                let keys = Object.keys(this.report);
                keys.forEach(key => {
                    this.report[key] = report[key];
                })

                if (report.employee_id) {
                    this.selectedEmployee = {
                        Employee_SlNo: report.employee_id,
                        display_name: report.Employee_Name
                    }
                } else {
                    this.selectedEmployee = null;
                }

                this.selectedFile = null;
            },
            deleteReport(reportId) {
                this.reportInfo = reportId;
				if (this.editaccess == false) {
					$(".accessModal").modal('show');
					return;
				}
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    this.editaccess = false;
                    return;
                }
                axios.post('/delete_report', {
                    reportId: reportId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.editaccess = false;
                        this.getReports();
                    }
                })
            },

            previewImage() {
                if (event.target.files.length > 0) {
                    this.selectedFile = event.target.files[0];
                } else {
                    this.selectedFile = null;
                }
            },


            async printCustomerList() {
                let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">Client List</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#printContent').innerHTML}
							</div>
						</div>
                    </div>
                `;

                let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                printWindow.document.write(`
                    <?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
                `);

                printWindow.document.body.innerHTML += printContent;
                printWindow.focus();
                await new Promise(r => setTimeout(r, 1000));
                printWindow.print();
                printWindow.close();
            },

            editAccess() {
				axios.post('/check_otp', {
					otp: this.otp
				}).then(res => {
					this.editaccess = res.data.status;
					if (this.editaccess) {
						$(".accessModal").modal('hide');
						this.otp = "";
						if (typeof(this.reportInfo) == 'object') {
							this.editReport(this.reportInfo);
						} else {
							this.deleteReport(this.reportInfo);
						}
					} else {
						alert(res.data.message);
					}
				})
			}
        }
    })
</script>