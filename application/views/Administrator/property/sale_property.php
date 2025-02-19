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
<div id="properties">
    <form @submit.prevent="saveData">
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12 col-md-12">
                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="4" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:26px;margin-bottom:10px;">Notun Thikana</h4>
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:26px;">Sale Product Information</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;">Property Id:</td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.Property_Code" readonly>
                        </td>
                        <td style="width: 25%;">Property Category:</td>
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
                        <td style="width: 15%;text-align:left;">Dev. Name: <sup class="text-danger">*</sup></td>
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
                        <td style="width: 15%;text-align:left;">Land Size: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.land_size" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Area: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.address" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Building Height: <sup class="text-danger">*</sup></td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.building_height" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="6" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Property Information</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Sqft: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="sqfts" style="margin: 0;" v-model="selectedSqft" label="Sqft_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/sqft', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Floor: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="floors" style="margin: 0;" v-model="selectedFloor" label="Floor_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/floor', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Gas: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="gass" style="margin: 0;" v-model="selectedGas" label="Gas_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/gas', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Bed: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="beds" style="margin: 0;" v-model="selectedBed" label="Bed_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/bed', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Unit: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.unit" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 10%;text-align:left;">Lift: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="lifts" style="margin: 0;" v-model="selectedLift" label="Lift_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/lift', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Bath: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="baths" style="margin: 0;" v-model="selectedBath" label="Bath_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/bath', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">S.Bed: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="sbeds" style="margin: 0;" v-model="selectedServantBed" label="Sbed_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/servant_bed', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Generator: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="generators" style="margin: 0;" v-model="selectedGenerator" label="Generator_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/generator', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">S.Bath: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="sbaths" style="margin: 0;" v-model="selectedServantBath" label="Sbath_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/servant_bath', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Drawing/Dining: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="drawings" style="margin: 0;" v-model="selectedDrawing" label="Drawing_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/drawing', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Balcony: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="balconys" style="margin: 0;" v-model="selectedBalcony" label="Balcony_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/balcony', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Apt. Face: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="faces" style="margin: 0;" v-model="selectedFace" label="Face_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/apt_face', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 10%;text-align:left;">Handover: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.handover" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 10%;text-align:left;">Total Unit: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.total_unit" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Others:</td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.others" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 10%;text-align:left;">Parking: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.parking" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 10%;text-align:left;">Loan Status:</td>
                        <td style="width: 20%;">
                            <input type="text" class="form-control" v-model="property.loan_status" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%;text-align:left;">Apt. Type: <sup class="text-danger">*</sup></td>
                        <td style="width: 20%;">
                            <div style="display: flex;align-items: center;justify-content: center;">
                                <div style="width: 90%;">
                                    <v-select :options="types" style="margin: 0;" v-model="selectedType" label="Type_Name"></v-select>
                                </div>
                                <div style="width: 10%;">
                                    <button type="button" onclick="window.open('/apt_type', '_blank')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <td colspan="4"></td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="2" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Owner Information</h4>
                        </td>
                        <td colspan="2" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Manager/Representative</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.owner_name" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Name:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.manager_name" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Number:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.owner_number" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td style="width: 15%;text-align:left;">Number:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.manager_number" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Profession:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.owner_profession" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td colspan="2" style="border: 0;"></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align:left;">Living At:</td>
                        <td style="width: 35%;">
                            <input type="text" class="form-control" v-model="property.living_at" autocomplete="off" placeholder="Typing...">
                        </td>
                        <td colspan="2" style="border: 0;"></td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="2" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">Property Price</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;text-align:left;">Package Price: <sup class="text-danger">*</sup></td>
                        <td style="width: 75%;">
                            <input type="text" class="form-control" v-model="property.package_price" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;text-align:left;">Per Sft Price:</td>
                        <td style="width: 75%;">
                            <input type="text" class="form-control" v-model="property.sft_price" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;text-align:left;">Parking+Utilities:</td>
                        <td style="width: 75%;">
                            <input type="text" class="form-control" v-model="property.utility_price" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr style="background: #d9d9d9;">
                        <td colspan="2" style="padding: 10px 0;">
                            <h4 style="text-align: center;margin:0;font-weight:800;font-size:20px;margin-bottom:10px;">MOU</h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;text-align:left;">Percentage:</td>
                        <td style="width: 75%;">
                            <input type="text" class="form-control" v-model="property.percentage" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%;text-align:left;">Fixed Price:</td>
                        <td style="width: 75%;">
                            <input type="text" class="form-control" v-model="property.fixed_price" autocomplete="off" placeholder="Typing...">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-sm btn-success" style="width: 100%;" v-html="property.Property_SlNo > 0 ? 'Update Property' : 'Save Property'"></button>
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

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#properties',
        data() {
            return {
                property: {
                    Property_SlNo: "<?= $propertyId; ?>",
                    Property_Code: "<?= $propertyCode; ?>",
                    house_no: '',
                    house_name: '',
                    road_no: '',
                    developer_name: '',
                    land_size: '',
                    address: '',
                    building_height: '',
                    unit: '',
                    handover: '',
                    total_unit: '',
                    others: '',
                    parking: '',
                    loan_status: '',
                    owner_name: '',
                    owner_number: '',
                    owner_profession: '',
                    living_at: '',
                    manager_name: '',
                    manager_number: '',
                    package_price: '',
                    sft_price: '',
                    utility_price: '',
                    percentage: '',
                    fixed_price: '',
                },
                properties: [],

                categories: [],
                selectedCategory: null,
                zones: [],
                selectedZone: null,
                floors: [],
                selectedFloor: null,
                gass: [],
                selectedGas: null,
                sqfts: [],
                selectedSqft: null,
                beds: [],
                selectedBed: null,
                sbeds: [],
                selectedServantBed: null,
                baths: [],
                selectedBath: null,
                sbaths: [],
                selectedServantBath: null,
                lifts: [],
                selectedLift: null,
                drawings: [],
                selectedDrawing: null,
                generators: [],
                selectedGenerator: null,
                balconys: [],
                selectedBalcony: null,
                faces: [],
                selectedFace: null,
                types: [],
                selectedType: null,
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
        async created() {
            this.getUsers();
            this.getFloors();
            this.getCategory();
            this.getZone();
            this.getSqft();
            this.getLift();
            this.getGenerator();
            this.getGas();
            this.getBalcony();
            this.getBath();
            this.getBed();
            this.getFace();
            this.getDrawing();
            this.getAptType();
            this.getServantBed();
            this.getServantBath();
            this.getEmployees();

            if (this.property.Property_SlNo != 0) {
                await this.getProperty();
            }
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
            getSqft() {
                axios.get('/get_sqft').then(res => {
                    this.sqfts = res.data;
                })
            },
            getGas() {
                axios.get('/get_gas').then(res => {
                    this.gass = res.data;
                })
            },
            getBed() {
                axios.get('/get_bed').then(res => {
                    this.beds = res.data;
                })
            },
            getServantBed() {
                axios.get('/get_servant_bed').then(res => {
                    this.sbeds = res.data;
                })
            },
            getLift() {
                axios.get('/get_lift').then(res => {
                    this.lifts = res.data;
                })
            },
            getBath() {
                axios.get('/get_bath').then(res => {
                    this.baths = res.data;
                })
            },
            getServantBath() {
                axios.get('/get_servant_bath').then(res => {
                    this.sbaths = res.data;
                })
            },
            getGenerator() {
                axios.get('/get_generator').then(res => {
                    this.generators = res.data;
                })
            },
            getBalcony() {
                axios.get('/get_balcony').then(res => {
                    this.balconys = res.data;
                })
            },
            getDrawing() {
                axios.get('/get_drawing').then(res => {
                    this.drawings = res.data;
                })
            },
            getFace() {
                axios.get('/get_apt_face').then(res => {
                    this.faces = res.data;
                })
            },
            getAptType() {
                axios.get('/get_apt_type').then(res => {
                    this.types = res.data;
                })
            },
            getEmployees() {
                axios.get('/get_employees').then(res => {
                    this.employees = res.data;
                })
            },

            saveData() {
                this.property.category_id = this.selectedCategory != null ? this.selectedCategory.Category_SlNo : '';
                this.property.zone_id = this.selectedZone != null ? this.selectedZone.Zone_SlNo : '';
                this.property.sqft_id = this.selectedSqft != null ? this.selectedSqft.Sqft_SlNo : '';
                this.property.floor_id = this.selectedFloor != null ? this.selectedFloor.Floor_SlNo : '';
                this.property.gas_id = this.selectedGas != null ? this.selectedGas.Gas_SlNo : '';
                this.property.lift_id = this.selectedLift != null ? this.selectedLift.Lift_SlNo : '';
                this.property.generator_id = this.selectedGenerator != null ? this.selectedGenerator.Generator_SlNo : '';
                this.property.bed_id = this.selectedBed != null ? this.selectedBed.Bed_SlNo : '';
                this.property.bath_id = this.selectedBath != null ? this.selectedBath.Bath_SlNo : '';
                if (this.selectedServantBed != null) {
                    this.property.sbed_id = this.selectedServantBed.Sbed_SlNo;
                }
                if (this.selectedServantBath != null) {
                    this.property.sbath_id = this.selectedServantBath.Sbath_SlNo;
                }
                if (this.selectedDrawing != null) {
                    this.property.drawing_id = this.selectedDrawing.Drawing_SlNo;
                }
                if (this.selectedBalcony != null) {
                    this.property.balcony_id = this.selectedBalcony.Balcony_SlNo;
                }
                if (this.selectedFace != null) {
                    this.property.face_id = this.selectedFace.Face_SlNo;
                }
                if (this.selectedType != null) {
                    this.property.type_id = this.selectedType.Type_SlNo;
                }
                let fd = new FormData();
                fd.append('data', JSON.stringify(this.property));

                let url = '/add_sale_property';
                if (this.property.Property_SlNo != 0) {
                    url = '/update_sale_property';
                }

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        if (this.property.Property_SlNo > 0) {
                            location.href = '/sale_property';
                        }
                        this.resetForm();
                        this.property.Property_Code = r.propertyCode;
                    }
                })
            },

            resetForm() {
                this.property = {
                    Property_SlNo: "<?= $propertyId; ?>",
                    Property_Code: "<?= $propertyCode; ?>",
                    house_no: '',
                    house_name: '',
                    road_no: '',
                    developer_name: '',
                    land_size: '',
                    address: '',
                    building_height: '',
                    unit: '',
                    handover: '',
                    total_unit: '',
                    others: '',
                    parking: '',
                    loan_status: '',
                    owner_name: '',
                    owner_number: '',
                    owner_profession: '',
                    living_at: '',
                    manager_name: '',
                    manager_number: '',
                    package_price: '',
                    sft_price: '',
                    utility_price: '',
                    percentage: '',
                    fixed_price: '',
                }
            },
            async getProperty() {
                await axios.post('/get_sale_property', {
                        propertyId: this.property.Property_SlNo
                    })
                    .then(res => {
                        let property = res.data[0];
                        let keys = Object.keys(this.property);
                        keys.forEach(key => {
                            this.property[key] = property[key];
                        })
                        setTimeout(() => {
                            this.selectedCategory = this.categories.find(item => item.Category_SlNo == property.category_id);
                            this.selectedZone = this.zones.find(item => item.Zone_SlNo == property.zone_id);
                            this.selectedSqft = this.sqfts.find(item => item.Sqft_SlNo == property.sqft_id);
                            this.selectedFloor = this.floors.find(item => item.Floor_SlNo == property.floor_id);
                            this.selectedLift = this.lifts.find(item => item.Lift_SlNo == property.lift_id);
                            this.selectedGas = this.gass.find(item => item.Gas_SlNo == property.gas_id);
                            this.selectedBed = this.beds.find(item => item.Bed_SlNo == property.bed_id);
                            this.selectedServantBed = this.sbeds.find(item => item.SBed_SlNo == property.sbed_id);
                            this.selectedBath = this.baths.find(item => item.Bath_SlNo == property.bath_id);
                            this.selectedServantBath = this.sbaths.find(item => item.SBath_SlNo == property.sbath_id);
                            this.selectedGenerator = this.generators.find(item => item.Generator_SlNo == property.generator_id);
                            this.selectedDrawing = this.drawings.find(item => item.Drawing_SlNo == property.drawing_id);
                            this.selectedBalcony = this.balconys.find(item => item.Balcony_SlNo == property.balcony_id);
                            this.selectedFace = this.faces.find(item => item.Face_SlNo == property.face_id);
                            this.selectedType = this.types.find(item => item.Type_SlNo == property.type_id);
                        }, 3000);
                    })
            }
        }
    })
</script>