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
                            <td>{{ row.tenant }}</td>
                            <td>{{ row.parking }}</td>
                            <td>{{ row.pet_policy }}</td>
                            <td>{{ row.Type_Name }}</td>
                            <td>{{ row.Status_Name }}</td>
                            <td>{{ row.others }}</td>
                            <td>{{ row.owner_name }}</td>
                            <td>{{ row.owner_number }}</td>
                            <td>{{ row.owner_profession }}</td>
                            <td>{{ row.living_at }}</td>
                            <td>{{ row.manager_name }}</td>
                            <td>{{ row.manager_number }}</td>
                            <td>{{ row.monthly_rent }}</td>
                            <td>{{ row.service_charge }}</td>
                            <td>{{ row.advanced }}</td>
                            <td>{{ row.vacant }}</td>
                            <td>{{ row.percentage }}</td>
                            <td>{{ row.btob }}</td>
                            <td>
                                <span v-show="row.Status == 'p'" class="badge badge-danger">Pending</span>
                                <span v-show="row.Status == 'a'" class="badge badge-success">Rent Out</span>
                            </td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" v-show="row.Status == 'p'" @click="statusUpdate(row)">RentOut</button>
                                    <a href="" :href="`/property_entry/${row.Property_SlNo}`" class="button edit">
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
                        label: 'Per_Tenant',
                        field: 'per_tenant',
                        align: 'center'
                    },
                    {
                        label: 'Parking',
                        field: 'parking',
                        align: 'center'
                    },
                    {
                        label: 'Pet_Policy',
                        field: 'pet_policy',
                        align: 'center'
                    },
                    {
                        label: 'Apt. Type',
                        field: 'Type_Name',
                        align: 'center'
                    },
                    {
                        label: 'Apt. Status',
                        field: 'Status_Name',
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
                        label: 'Monthly_Rent',
                        field: 'monthly_rent',
                        align: 'center'
                    },
                    {
                        label: 'Service_Charge',
                        field: 'service_charge',
                        align: 'center'
                    },
                    {
                        label: 'Advanced',
                        field: 'advanced',
                        align: 'center'
                    },
                    {
                        label: 'Vacant',
                        field: 'vacant',
                        align: 'center'
                    },
                    {
                        label: 'Percentage',
                        field: 'percentage',
                        align: 'center'
                    },
                    {
                        label: 'BtoB',
                        field: 'btob',
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

            getProperty() {
                axios.post('/get_property').then(res => {
                    this.properties = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            deleteProperty(rowId) {
                if (!confirm("Are you sure?")) return;
                axios.post('/delete_property', {
                    propertyId: rowId
                }).then(res => {
                    alert(res.data.message)
                    this.getProperty();
                })
            },

            statusUpdate(row) {
                if (!confirm("Are you sure?")) return;
                axios.post("/rent_status_update", row)
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