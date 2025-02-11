<style>
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

<div id="propertyList">
    <div class="row" style="margin: 0;">
        <div class="col-md-12">
            <form class="form-inline">
                <div class="form-group">
                    <label for="">Code</label>
                    <input type="text" class="form-control" v-model="Property_Code">
                </div>

                <div class="form-group">
                    <label for="">Purpose</label>
                    <select name="purposeId" style="padding: 1px 6px;width:80px;height:26px;" id="purposeId" v-model="purposeId">
                        <option value="">All</option>
                        <option v-for="item in purposes" :value="item.Purpose_SlNo">{{item.Purpose_Name}}</option>
                    </select>
                </div>

                <?php if($this->session->userdata('accountType') != 'u'){?>
                <div class="form-group">
                    <label>EntryBy</label>
                    <v-select v-bind:options="entries" v-model="selectedEntry" label="FullName"></v-select>
                </div>

                <div class="form-group">
                    <label for="user">AssignBy:</label>
                    <v-select :options="users" v-model="selectedUser" label="User_Name"></v-select>
                </div>
                <?php } ?>

                <div class="form-group">
                    <label for="">MOU</label>
                    <select name="purposeId" style="padding: 1px 6px;width:80px;height:26px;" id="MOU_Status" v-model="MOU_Status">
                        <option value="">All</option>
                        <option value="MOU">MOU</option>
                        <option value="NONMOU">NON MOU</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Floor</label>
                    <v-select v-bind:options="floors" v-model="selectedFloor" label="Floor_Name"></v-select>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <v-select v-bind:options="categories" v-model="selectedCategory" label="Category_Name"></v-select>
                </div>

                <div class="form-group">
                    <label>Type</label>
                    <v-select v-bind:options="types" v-model="selectedType" label="Type_Name"></v-select>
                </div>
                <?php if($this->session->userdata('accountType') != 'u'){?>
                    <div class="form-group">
                        <label>Employee</label>
                        <v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label>Area</label>
                    <v-select v-bind:options="areas" v-model="selectedArea" label="District_Name"></v-select>
                </div>
                <div class="form-group">
                    <label>Block</label>
                    <v-select v-bind:options="blocks" v-model="selectedBlock" label="Block_Name"></v-select>
                </div>
                <div class="form-group">
                    <label>Property Status</label>
                    <select class="form-select" style="margin:0;height:26px;width:150px;" v-model="property_status" style="padding:0px;">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="deactive">Deactive</option>
                        <option value="sold">Sold</option>
                        <option value="rented">Rented</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Next_Call_Date</label>
                    <input type="date" class="form-control" v-model="next_call_date">
                </div>

                <div class="form-group">
                    <label for="">Latest_Call_Date</label>
                    <input type="date" class="form-control" v-model="latest_call_date">
                </div>
                <div class="form-group">
                    <label for="">From</label>
                    <input type="date" class="form-control" v-model="dateFrom">
                </div>

                <div class="form-group">
                    <label for="">To</label>
                    <input type="date" class="form-control" v-model="dateTo">
                </div>
                <div class="form-group" style="margin-top: -1px;">
                    <input type="button" value="Show Report" v-on:click="getProperty">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display: none" v-bind:style="{display: properties.length > 0 ? '' : 'none'}">
        <?php if ($this->session->userdata('accountType') == 'm') { ?>
            <div class="col-md-12" style="margin-bottom: 10px;display: flex;justify-content: end;">
                <!-- <a href="" @click.prevent="print" style="margin: 0;"><i class="fa fa-print"></i> Print</a> -->
                <a :href="`/download_property/${dateFrom}/${dateTo}`" style="margin: 0;"><i class="fa fa-file-excel-o"></i> Download</a>
            </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="table-responsive" id="reportTable">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Code</th>
                            <th>Employee_Name</th>
                            <th>Property_Name</th>
                            <th>Property_Address</th>
                            <th>Block_Name</th>
                            <th>Area_Name</th>
                            <th>Purpose_Name</th>
                            <th>Category_Name</th>
                            <th>Property_Type_Name</th>
                            <th>Apt_Size</th>
                            <th>Apt_Size_Range</th>
                            <th>Price</th>
                            <th>Price Per Sq/Ft(Approx)</th>
                            <th>Service_Charge</th>
                            <th>Floor_Name</th>
                            <th>Unit_Number</th>
                            <th>Unit_Per_Floor</th>
                            <th>Total_Unit</th>
                            <th>Building_Height</th>
                            <th>Bed</th>
                            <th>Bath</th>
                            <th>Balcony</th>
                            <th>Servent_Bed</th>
                            <th>Servent_Bath</th>
                            <th>Apt_Condition</th>
                            <th>Facing</th>
                            <th>Parking</th>
                            <th>Gas_Connection</th>
                            <th>List_Name</th>
                            <th>Generator</th>
                            <th>Land_Size</th>
                            <th>Road_Size</th>
                            <th>Loan_Status</th>
                            <th>Viewing_Availability</th>
                            <th>Occupancy_Status</th>
                            <th>Developer_Name</th>
                            <th>Property_Handover_Date</th>
                            <th>Property_Entry_Date</th>
                            <th>Property_Status</th>
                            <th>MOU/Purchase_Date</th>
                            <th>MOU/Purchase_Status</th>
                            <th>Property_Owner_Name</th>
                            <th>Property_Owner_Contact</th>
                            <th>Property_Owner_Email</th>
                            <th>MOU_Percentage</th>
                            <th>Final_Revenue</th>
                            <th>Next_Call_Date</th>
                            <th>Latest_Call_Date</th>
                            <th>Entry_By</th>
                            <th>AssignBy</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(property, sl) in properties" :style="{background: property.Status == 'p' ? '#e39105' : ''}">
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ sl + 1 }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Property_Code }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Employee_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Property_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Property_Address }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Block_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.District_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Purpose_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Category_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Type_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Apt_Size }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Apt_Size_Range }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Price }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.per_sft_rate }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.service_charge }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Floor_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.unit_number }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.unit_per_floor }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.total_unit }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Height_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Bed }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Bath }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Balcony }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.servent_bed }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.servent_bath }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Apt_Condition }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.facing }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.parking }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Gas_Connection }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Lift_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.generator }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Land_Size }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.road_size }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.loan_status }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Availability_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Occupancy_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Developer }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.HandoverDate | dateFormat("YYYY") }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.entry_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.property_status }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.purchase_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.MOU_status }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Owner_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Owner_Contact }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.Owner_Email }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.MOU_percentage }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.final_revenue }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.next_call_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.latest_call_date | dateFormat("DD-MM-YYYY") }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.AddBy }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">{{ property.User_Name }}</td>
                            <td :style="{color: property.Status == 'p' ? 'white !important' : ''}">
                                <?php if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a' || $this->session->userdata('accountType') == 'e') { ?>
                                    <button type="button" class="button edit" @click="showAssignModal(property)" style="background: #1ca63a; border: none; padding: 5px 10px; color: white; border-radius: 5px;">
                                        Assign
                                    </button>
                                <?php } ?>
                                <i class="fa fa-envelope-o" style="cursor: pointer;font-size:20px;" @click="showModal(property)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal form -->
    <div class="modal reportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header" style="display: flex;align-items:center;justify-content:space-between;background: #ceefff;">
                    <h3 style="padding:0;margin: 0; width:80%;text-align:left;" class="modal-title">Report Entry & List</h3>
                    <p style="padding:0;margin: 0; width:20%;font-size:20px;text-align:right;cursor:pointer;" data-dismiss="modal" aria-label="Close" aria-hidden="true"><i class="fa fa-times"></i></p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <form @submit.prevent="updateProperty" style="border: 1px solid rgb(137, 228, 255); padding: 5px;">
                                <div class="form-group row">
                                    <label for="" class="col-md-5">Next Meeting Date:</label>
                                    <div class="col-md-7">
                                        <input type="datetime-local" class="form-control" v-model="property.next_meeting_date" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5">Next Call Date:</label>
                                    <div class="col-md-7">
                                        <input type="date" class="form-control" v-model="property.next_call_date" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5">Latest Call Date:</label>
                                    <div class="col-md-7">
                                        <input type="date" class="form-control" v-model="property.latest_call_date" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5">Property Status:</label>
                                    <div class="col-md-7">
                                        <select class="form-control" style="padding: 0px 3px;" v-model="property.property_status">
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                            <option value="Sold">Sold</option>
                                            <option value="Rented">Rented</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5">MOU/Purchase Date:</label>
                                    <div class="col-md-7">
                                        <input type="date" class="form-control" v-model="property.purchase_date" />
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label for="" class="col-md-5">MOU/Purchase Status:</label>
                                    <div class="col-md-7">
                                        <select class="form-control" style="padding: 0px 3px;" v-model="property.MOU_status">
                                            <option value="MOU">MOU</option>
                                            <option value="NON MOU">NON MOU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5">MOU Percentage:</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" v-model="property.MOU_percentage" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-5"></label>
                                    <div class="col-md-7">
                                        <label for="is_popular">
                                            <input type="checkbox" id="is_popular" false-value='no' true-value="yes" v-model="property.is_popular" /> Is Popular
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary"> Update </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <h3 style="margin: 0px; text-align: center; border-bottom: 1px solid gray; background: #00ffff3d;">Reports Entry</h3>
                            <form @submit.prevent="addReport" style="border: 1px solid #89e4ff;padding: 5px;">
                                <div class="form-group">
                                    <label for="">Latest Update</label>
                                    <textarea class="form-control" rows="5" v-model="report.note"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Report Date</label>
                                            <input type="date" class="form-control" v-model="report.report_date" />
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select class="form-control" v-model="report.property_status" style="padding: 0 5px;">
                                                <option value="First Call">First Call</option>
                                                <option value="Property Visit">Property Visit</option>
                                                <option value="Meeting">Meeting</option>
                                                <option value="Follow Up Call">Follow Up Call</option>
                                                <option value="Viewing">Viewing</option>
                                                <option value="Re Viewing">Re Viewing</option>
                                                <option value="Negotiation Meeting">Negotiation Meeting</option>
                                                <option value="Property Booking">Property Booking</option>
                                                <option value="Sold">Sold</option>
                                                <option value="Booking Cancelled">Booking Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12" style="margin-top: 15px;">
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
                                    <tr v-for="(item, sl) in reports">
                                        <td>{{sl + 1}}</td>
                                        <td>{{item.report_date | dateFormat('DD-MM-YYYY')}}</td>
                                        <td>{{item.User_Name}}</td>
                                        <td>{{item.note}}</td>
                                        <td>{{item.property_status}}</td>
                                        <td>
                                            <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                                <button type="button" class="button edit" @click="editReport(item)">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" class="button" @click="deleteReport(item)">
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
    </div>

    <!-- modal here -->
    <div class="modal assignModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" style="width:90%;margin: 0;">Property Assign on User</h5>
                    <button type="button" style="width: 10%; margin: 0px; display: flex; align-items: center; justify-content: end;" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin: 0;font-size: 20px;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">User:</label>
                        <v-select :options="users" v-model="selectedAssignUser" label="User_Name"></v-select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="assignProperty" class="btn btn-primary">Assign Client</button>
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
        el: '#propertyList',
        data() {
            return {
                Property_Code: '',
                property_status: '',
                MOU_Status: '',
                purposeId: "",
                dateFrom: moment().format("YYYY-MM-DD"),
                dateTo: moment().format("YYYY-MM-DD"),
                next_call_date: "",
                latest_call_date: "",
                properties: [],
                floors: [],
                selectedFloor: null,
                categories: [],
                selectedCategory: null,
                types: [],
                selectedType: null,
                purposes: [],
                selectedPurpose: null,
                employees: [],
                selectedEmployee: null,
                areas: [],
                selectedArea: null,
                blocks: [],
                selectedBlock: null,
                users: [],
                selectedUser: null,
                assignUsers: [],
                selectedAssignUser: null,
                entries: [],
                selectedEntry: null,
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
                employeeId: '<?php echo $this->session->userdata("employeeId"); ?>',
                property: {},
                report: {
                    id: '',
                    property_id: '',
                    report_date: moment().format("YYYY-MM-DD"),
                    note: '',
                    property_status: 'First Call'
                },
                reports: [],
                propertyRow: {},

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
            this.getFloors();
            this.getCategory();
            this.getTypes();
            this.getPurposes();
            this.getEmployees();
            this.getArea();
            this.getBlock();
            this.getUsers();
            this.getEntry();
        },
        methods: {
            getUsers() {
                axios.get('/get_users').then(res => {
                    if (this.userType == 'm' || this.userType == 'a') {
                        this.users = res.data.filter(item => item.User_SlNo != 1);
                        this.assignUsers = res.data.filter(item => item.User_SlNo != 1);
                    } else if (this.userType == 'e') {
                        this.users = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
                        this.assignUsers = res.data.filter(item => item.userId == this.userId || item.UserType == 'e');
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
            getCategory() {
                axios.get('/get_property_category').then(res => {
                    this.categories = res.data;
                })
            },
            getFloors() {
                axios.get('/get_floor').then(res => {
                    this.floors = res.data;
                })
            },
            getTypes() {
                axios.get('/get_propertyType').then(res => {
                    this.types = res.data;
                })
            },
            getPurposes() {
                axios.get('/get_purpose').then(res => {
                    this.purposes = res.data;
                })
            },
            getEmployees() {
                axios.get('/get_employees').then(res => {
                    this.employees = res.data;
                })
            },

            getArea() {
                axios.get('/get_districts').then(res => {
                    this.areas = res.data;
                })
            },

            getBlock() {
                axios.get('/get_block').then(res => {
                    this.blocks = res.data;
                })
            },

            getProperty() {
                let data = {
                    floorId: this.selectedFloor == null ? "" : this.selectedFloor.Floor_SlNo,
                    areaId: this.selectedArea == null ? "" : this.selectedArea.District_SlNo,
                    categoryId: this.selectedCategory == null ? "" : this.selectedCategory.Category_SlNo,
                    blockId: this.selectedBlock == null ? "" : this.selectedBlock.Block_SlNo,
                    typeId: this.selectedType == null ? "" : this.selectedType.Type_SlNo,
                    employeeId: this.selectedEmployee == null ? "" : this.selectedEmployee.Employee_SlNo,
                    user_id: this.userType == 'e' ? this.selectedUser == null ? this.userId : this.selectedUser.User_SlNo : this.userType == 'u' ? this.userId : null,
                    AddBy: this.selectedEntry == null ? "" : this.selectedEntry.FullName,
                    Property_Code: this.Property_Code,
                    purposeId: this.purposeId,
                    MOU_Status: this.MOU_Status,
                    property_status: this.property_status,
                    latest_call_date: this.latest_call_date,
                    next_call_date: this.next_call_date,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                }
                if (this.userType == 'm' || this.userType == 'a') {
                    data.user_id = this.selectedUser == null ? "" : this.selectedUser.User_SlNo;
                }
                if (this.userType == 'u') {
                    data.employee_id = this.employeeId;
                }
                axios.post('/get_property', data).then(res => {
                    this.properties = res.data.properties.filter(item => item.Status != 'd');
                })
            },

            showModal(row) {
                this.property = row;
                this.report.property_id = row.Property_SlNo
                this.getReports(row.Property_SlNo)
                $(".reportModal").modal('show');
            },

            updateProperty() {
                axios.post("/update_single_property", this.property).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.getProperty();
                    $(".reportModal").modal('hide');
                })
            },

            addReport() {
                let formdata = new FormData();
                formdata.append('data', JSON.stringify(this.report))
                var url = '/add_property_report';
                if (this.report.id != '') {
                    url = 'update_property_report';
                }
                axios.post(url, formdata)
                    .then(res => {
                        alert(res.data.message)
                        this.getReports(this.report.property_id);
                        this.getProperty();
                        this.editaccess = false;
                        this.report.id = "";
                        this.report.note = "";
                        this.report.property_status = "Pending";
                    })
            },

            getReports(rowId) {
                axios.post('/get_property_reports', {
                    property_id: rowId
                }).then(res => {
                    this.reports = res.data;
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
            },
            deleteReport(report) {
                this.reportInfo = report;
				if (this.editaccess == false) {
					$(".accessModal").modal('show');
					return;
				}

                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    this.editaccess = false;
                    return;
                }
                axios.post('/delete_property_report', {
                    reportId: report.id
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.editaccess = false;
                        this.getReports(report.property_id);
                    }
                })
            },

            showAssignModal(row) {
                this.propertyRow = row;
                this.selectedAssignUser = {
                    User_SlNo: row.user_id,
                    User_Name: row.User_Name,
                }
                $(".assignModal").modal("show");
            },
            assignProperty() {
                let filter = {
                    property_id: this.propertyRow.Property_SlNo,
                    user_id: this.selectedAssignUser.User_SlNo
                }

                axios.post('/assign_property', filter)
                    .then(res => {
                        alert(res.data.message);
                        this.getProperty();
                        $(".assignModal").modal("hide");
                    })
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