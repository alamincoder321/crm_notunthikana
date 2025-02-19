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
    <!-- <div class="row" style="margin: 0px; border-bottom: 1px solid gray; margin-bottom: 15px; padding-bottom: 3px;">
        <div class="col-xs-12">
            <form class="form-inline">
                <div class="form-group">
                    <label for="">SearchType</label>
                    <select style="padding: 1px 6px;width:80px;height:26px;">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="form-group" style="margin-top: -1px;">
                    <input type="button" value="Show Report" v-on:click="getProperty">
                </div>
            </form>
        </div>
    </div> -->

    <div class="row" style="display: none" v-bind:style="{display: properties.length > 0 ? '' : 'none'}">
        <div class="col-xs-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="properties" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr :style="{background: row.Status == 'p' ? '#ff6a6a' : ''}">
                            <td>{{ row.Property_Code }}</td>
                            <td>{{ row.Category_Name }}</td>
                            <td>{{ row.house_no }}</td>
                            <td>{{ row.house_name }}</td>
                            <td>{{ row.road_no }}</td>
                            <td>{{ row.developer_name }}</td>
                            <td>{{ row.Zone_Name }}</td>
                            <td>{{ row.land_size }}</td>
                            <td>{{ row.address }}</td>
                            <td>{{ row.building_height }}</td>
                            <td>{{ row.Sqft_Name }}</td>
                            <td>{{ row.Floor_Name }}</td>
                            <td>{{ row.Gas_Name }}</td>
                            <td>{{ row.Bed_Name }}</td>
                            <td>{{ row.unit }}</td>
                            <td>{{ row.Lift_Name }}</td>
                            <td>{{ row.Bath_Name }}</td>
                            <td>{{ row.Sbed_Name }}</td>
                            <td>{{ row.Generator_Name }}</td>
                            <td>{{ row.Sbath_Name }}</td>
                            <td>{{ row.Drawing_Name }}</td>
                            <td>{{ row.Balcony_Name }}</td>
                            <td>{{ row.Face_Name }}</td>
                            <td>{{ row.handover }}</td>
                            <td>{{ row.total_unit }}</td>
                            <td>{{ row.parking }}</td>
                            <td>{{ row.loan_status }}</td>
                            <td>{{ row.Type_Name }}</td>
                            <td>{{ row.others }}</td>
                            <td>{{ row.owner_name }}</td>
                            <td>{{ row.owner_number }}</td>
                            <td>{{ row.owner_profession }}</td>
                            <td>{{ row.living_at }}</td>
                            <td>{{ row.manager_name }}</td>
                            <td>{{ row.manager_number }}</td>
                            <td>{{ row.package_price }}</td>
                            <td>{{ row.sft_price }}</td>
                            <td>{{ row.utility_price }}</td>
                            <td>{{ row.percentage }}</td>
                            <td>{{ row.fixed_price }}</td>
                            <td>
                                <span v-show="row.Status == 'p'" class="badge badge-danger">Pending</span>
                                <span v-show="row.Status == 'a'" class="badge badge-success">Sold Out</span>
                            </td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" v-show="row.Status == 'p'" @click="statusUpdate(row)">SoldOut</button>
                                    <a href="" :href="`/sale_property/${row.Property_SlNo}`" class="button edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                <?php } ?>
                                <?php if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a') { ?>
                                    <a href="" class="button" @click.prevent="deleteProperty(row.Property_SlNo)">
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
                properties: [],
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',

                columns: [{
                        label: 'Property_Id',
                        field: 'Property_Code',
                        align: 'center'
                    },
                    {
                        label: 'Category_Name',
                        field: 'Category_Name',
                        align: 'center'
                    },
                    {
                        label: 'House_No.',
                        field: 'house_no',
                        align: 'center'
                    },
                    {
                        label: 'House_Name',
                        field: 'house_name',
                        align: 'center'
                    },
                    {
                        label: 'Road_No.',
                        field: 'road_no',
                        align: 'center'
                    },
                    {
                        label: 'Developer_Name',
                        field: 'developer_name',
                        align: 'center'
                    },
                    {
                        label: 'Zone',
                        field: 'Zone_Name',
                        align: 'center'
                    },
                    {
                        label: 'LandSize',
                        field: 'land_size',
                        align: 'center'
                    },
                    {
                        label: 'Area',
                        field: 'address',
                        align: 'center'
                    },
                    {
                        label: 'Building_Height',
                        field: 'building_height',
                        align: 'center'
                    },
                    {
                        label: 'Sqft',
                        field: 'Sqft_Name',
                        align: 'center'
                    },
                    {
                        label: 'Floor',
                        field: 'Floor_Name',
                        align: 'center'
                    },
                    {
                        label: 'Gas',
                        field: 'Gas_Name',
                        align: 'center'
                    },
                    {
                        label: 'Bed',
                        field: 'Bed_Name',
                        align: 'center'
                    },
                    {
                        label: 'Unit',
                        field: 'unit',
                        align: 'center'
                    },
                    {
                        label: 'Lift',
                        field: 'Lift_Name',
                        align: 'center'
                    },
                    {
                        label: 'Bath',
                        field: 'Bath_Name',
                        align: 'center'
                    },
                    {
                        label: 'Sarvent_Bed',
                        field: 'Sbed_Name',
                        align: 'center'
                    },
                    {
                        label: 'Generator',
                        field: 'Generator_Name',
                        align: 'center'
                    },
                    {
                        label: 'Sarvent_Bath',
                        field: 'Sbath_Name',
                        align: 'center'
                    },
                    {
                        label: 'Drawing',
                        field: 'Drawing_Name',
                        align: 'center'
                    },
                    {
                        label: 'Balcony',
                        field: 'Balcony_Name',
                        align: 'center'
                    },
                    {
                        label: 'Apt. Face',
                        field: 'Face_Name',
                        align: 'center'
                    },
                    {
                        label: 'Handover',
                        field: 'handover',
                        align: 'center'
                    },
                    {
                        label: 'Total_Unit',
                        field: 'total_unit',
                        align: 'center'
                    },
                    {
                        label: 'Parking',
                        field: 'parking',
                        align: 'center'
                    },
                    {
                        label: 'Loan_Status',
                        field: 'loan_status',
                        align: 'center'
                    },
                    {
                        label: 'Apt. Type',
                        field: 'Type_Name',
                        align: 'center'
                    },
                    {
                        label: 'Others',
                        field: 'others',
                        align: 'center'
                    },
                    {
                        label: 'Owner_Name',
                        field: 'owner_name',
                        align: 'center'
                    },
                    {
                        label: 'Owner_Number',
                        field: 'owner_number',
                        align: 'center'
                    },
                    {
                        label: 'Profession',
                        field: 'owner_profession',
                        align: 'center'
                    },
                    {
                        label: 'Living_At',
                        field: 'living_at',
                        align: 'center'
                    },
                    {
                        label: 'Manager_Name',
                        field: 'manager_name',
                        align: 'center'
                    },
                    {
                        label: 'Manager_Number',
                        field: 'manager_number',
                        align: 'center'
                    },
                    {
                        label: 'Package_Price',
                        field: 'package_price',
                        align: 'center'
                    },
                    {
                        label: 'Per_Sft_Price',
                        field: 'sft_price',
                        align: 'center'
                    },
                    {
                        label: 'Parking+Utilities',
                        field: 'utility_price',
                        align: 'center'
                    },
                    {
                        label: 'Percentage',
                        field: 'percentage',
                        align: 'center'
                    },
                    {
                        label: 'Fixed Price',
                        field: 'fixed_price',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'Status',
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
            this.getUsers();
            this.getProperty();
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

            getProperty() {
                axios.post('/get_sale_property').then(res => {
                    this.properties = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            deleteProperty(rowId) {
                if (!confirm("Are you sure?")) return;
                axios.post('/delete_sale_property', {
                    propertyId: rowId
                }).then(res => {
                    alert(res.data.message)
                    this.getProperty();
                })
            },

            statusUpdate(row) {
                if (!confirm("Are you sure?")) return;
                axios.post("/sale_status_update", row)
                    .then(res => {
                        alert(res.data.message);
                        if (res.data.success) {
                            this.getProperty();
                        }
                    })
            }
        }
    })
</script>