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

    tr td {
        vertical-align: middle !important;
    }
</style>

<div id="propertyList">
    <div class="row" style="display: none" v-bind:style="{display: customers.length > 0 ? '' : 'none'}">
        <div class="col-xs-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="customers" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.status == 'p' ? '#ff6a6a' : ''}">
                            <td>{{ row.Customer_Code }}</td>
                            <td>{{ row.Customer_Name }}</td>
                            <td>{{ row.Customer_Mobile }}</td>
                            <td>{{ row.Zone_Name }}</td>
                            <td>{{ row.Customer_Address }}</td>
                            <td>{{ row.Sqft_Name }}</td>
                            <td>{{ row.bedbath }}</td>
                            <td>{{ row.sbedbath }}</td>
                            <td>{{ row.Budget_Name }}</td>
                            <td>{{ row.floor }}</td>
                            <td>{{ row.Status_Name }}</td>
                            <td>{{ row.Condition_Name }}</td>
                            <td>{{ row.pet_status }}</td>
                            <td>{{ row.apt_face }}</td>
                            <td>{{ row.profession }}</td>
                            <td>{{ row.living_at }}</td>
                            <td>{{ row.others }}</td>
                            <td>{{ row.Source_Name }}</td>
                            <td>{{ row.AddBy }}</td>
                            <td>{{ row.User_Name }}</td>
                            <td>
                                <span v-show="row.Status == 'p'" class="badge badge-danger">Pending</span>
                                <span v-show="row.Status == 'a'" class="badge badge-success">Approved</span>
                            </td>
                            <td>
                                <a href="" :href="`/sale_report/${row.Customer_SlNo}`" class="button edit">
                                    <i class="fa fa-commenting-o" style="font-size: 25px;"></i>
                                </a>
                            </td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" @click="showModal(row)">Assign</button>
                                    <a href="" :href="`/customer/${row.Customer_SlNo}`" class="button edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                <?php } ?>
                                <?php if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a') { ?>
                                    <a href="" class="button" @click.prevent="deleteCustomer(row.Customer_SlNo)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
            </div>
        </div>
    </div>

    <!-- modal here -->
    <div class="modal myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 class="modal-title" style="width:90%;margin: 0;">Client Assign on User</h5>
                    <button type="button" style="width: 10%; margin: 0px; display: flex; align-items: center; justify-content: end;" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin: 0;font-size: 20px;">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">User:</label>
                        <v-select v-bind:options="users" v-model="selectedUser" label="User_Name"></v-select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" @click="assignClient" class="btn btn-primary">Assign Client</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#propertyList',
        data() {
            return {
                columns: [{
                        label: 'Lead_ID',
                        field: 'Customer_Code',
                        align: 'center'
                    },
                    {
                        label: 'Client_Name',
                        field: 'Client_Name',
                        align: 'center'
                    },
                    {
                        label: 'Client_Number',
                        field: 'Customer_Mobile',
                        align: 'center'
                    },
                    {
                        label: 'Zone',
                        field: 'Zone_Name',
                        align: 'center'
                    },
                    {
                        label: 'Area',
                        field: 'Customer_Address',
                        align: 'center'
                    },
                    {
                        label: 'Sft',
                        field: 'Sqft_Name',
                        align: 'center'
                    },

                    {
                        label: 'Bed & Bath',
                        field: 'sbedbath',
                        align: 'center'
                    },
                    {
                        label: 'S.Bed & S.Bath',
                        field: 'sbedbath',
                        align: 'center'
                    },
                    {
                        label: 'Budget',
                        field: 'Budget_Name',
                        align: 'center'
                    },
                    {
                        label: 'Floor',
                        field: 'floor',
                        align: 'center'
                    },
                    {
                        label: 'Property_Status',
                        field: 'Status_Name',
                        align: 'center'
                    },
                    {
                        label: 'Apartment_Condition',
                        field: 'Condition_Name',
                        align: 'center'
                    },
                    {
                        label: 'Pet_Status',
                        field: 'pet_status',
                        align: 'center'
                    },
                    {
                        label: 'Apt. Face',
                        field: 'apt_face',
                        align: 'center'
                    },
                    {
                        label: 'Profession',
                        field: 'profession',
                        align: 'center'
                    },
                    {
                        label: 'Living At',
                        field: 'living_at',
                        align: 'center'
                    },
                    {
                        label: 'Others',
                        field: 'others',
                        align: 'center'
                    },
                    {
                        label: 'Source',
                        field: 'Source_Name',
                        align: 'center'
                    },
                    {
                        label: 'Entry_By',
                        field: 'AddBy',
                        align: 'center'
                    },
                    {
                        label: 'Assign_By',
                        field: 'User_Name',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'status',
                        align: 'center'
                    },
                    {
                        label: 'Message_Entry',
                        field: 'report',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 1000,
                filter: '',

                customers: [],
                clientRow: {},
                users: [],
                selectedUser: null,
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
            }
        },
        created() {
            this.getUsers();
            this.getCustomer();
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

            getCustomer() {
                axios.post('/get_sale_customers').then(res => {
                    this.customers = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            deleteCustomer(rowId) {
                if (!confirm("Are you sure?")) return;
                axios.post('/delete_sale_customer', {
                    propertyId: rowId
                }).then(res => {
                    alert(res.data.message)
                    this.getCustomer();
                })
            },

            showModal(customer) {
                this.clientRow = customer;
                this.selectedUser = {
                    User_SlNo: customer.user_id,
                    User_Name: customer.User_Name,
                }
                $(".myModal").modal("show");
            },
            assignClient() {
                let filter = {
                    Customer_SlNo: this.clientRow.Customer_SlNo,
                    user_id: this.selectedUser.User_SlNo,
                }
                axios.post('/assign_sale_customer', filter)
                    .then(res => {
                        alert(res.data.message);
                        this.getCustomers();
                        $(".myModal").modal("hide");
                    })
            },
        }
    })
</script>