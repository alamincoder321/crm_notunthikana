<style scoped>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select.open .dropdown-toggle {
        border-bottom: 1px solid #ccc;
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

    #properties label {
        font-size: 13px;
        margin: 0;
    }

    #properties select {
        border-radius: 3px;
    }

    #properties .add-button {
        padding: 2.5px;
        width: 28px;
        background-color: #298db4;
        display: block;
        text-align: center;
        color: white;
    }

    #properties .add-button:hover {
        background-color: #41add6;
        color: white;
    }

    .table tr td {
        vertical-align: middle !important;
    }

    .form-control {
        margin-bottom: 0;
    }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<div id="properties">
    <form @submit.prevent="saveproperty">
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12 col-md-12">
                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="4" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:26px;margin-bottom:10px;">Notun Thikana</h4>
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:26px;">Rent Product Information</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;">Property ID</td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.Property_Code" readonly>
                        </td>
                        <td style="width: 25%;">Property Category</td>
                        <td style="width: 40%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="categories" style="margin: 0;" v-model="selectedCategory" label="Category_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/property_category', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="4" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Property Address</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">House No: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.house_no" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">House Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.house_name" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Road No: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.road_no" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Dev. Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.developer_name" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Zone: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="zones" style="margin: 0;" v-model="selectedZone" label="Zone_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/zone', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 15%;text-align:left;">Land Size:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.land_size" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Area: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.address" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Building Height:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.building_height" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="4" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Property Information</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">House No: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.house_no" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">House Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.house_name" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Road No: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.road_no" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Dev. Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.developer_name" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Zone: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="zones" style="margin: 0;" v-model="selectedZone" label="Zone_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/zone', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 15%;text-align:left;">Land Size:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.land_size" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Area: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.address" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Building Height:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.building_height" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script>
    $(function() {
        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    });
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#properties',
        data() {
            return {
                property: {
                    Property_SlNo: 0,
                    Property_Code: '',
                    Property_Name: '',
                },
                properties: [],

                categories: [],
                selectedCategory: null,
                zones: [],
                selectedZone: null,
                floors: [],
                selectedFloor: null,
                users: [],
                selectedUser: null,
                employees: [],
                selectedEmployee: null,
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
            }
        },
        filters: {
            dateFormat(datetime, format) {
                return moment(datetime).format(format);
            }
        },
        created() {
            this.getUsers();
            this.getFloors();
            this.getCategory();
            this.getZone();
            this.getEmployees();
            this.getProperty();
        },
        methods: {
            getUsers() {
                axios.get('/get_users').then(res => {
                    if (this.userType == 'm' || this.userType == 'a') {
                        this.users = res.data.filter(item => item.User_SlNo != 1);
                    } else if (this.userType == 'e') {
                        this.users = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
                    }
                })
            },
            getCategory() {
                axios.get('/get_property_category').then(res => {
                    this.categories = res.data;
                })
            },
            getZone() {
                axios.get('/get_zone').then(res => {
                    this.zones = res.data;
                })
            },
            getFloors() {
                axios.get('/get_floor').then(res => {
                    this.floors = res.data;
                })
            },
            getEmployees() {
                axios.get('/get_employees').then(res => {
                    this.employees = res.data;
                })
            },

            getProperty() {
                let filter = {};
                if (this.userType != 'm') {
                    filter.user_id = this.userId;
                }
                axios.post('/get_property', filter).then(res => {
                    this.property.Property_Code = res.data.propertyCode;
                    this.properties = res.data.properties.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            handleFileUpload(event) {
                this.files = event.target.files;
            },

            saveproperty() {
                this.property.categoryId = this.selectedCategory != null ? this.selectedCategory.Category_SlNo : '';
                this.property.floorId = this.selectedFloor != null ? this.selectedFloor.Floor_SlNo : '';
                this.property.employeeId = this.selectedEmployee != null ? this.selectedEmployee.Employee_SlNo : '';
                this.property.user_id = this.selectedUser != null ? this.selectedUser.User_SlNo : '';
                let fd = new FormData();
                fd.append('data', JSON.stringify(this.property));

                let url = '/add_property';
                if (this.property.Property_SlNo != 0) {
                    url = '/update_property';
                }

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.resetForm();
                        this.property.Property_Code = r.propertyCode;
                        this.getProperty();
                    }
                })
            }
        }
    })
</script>