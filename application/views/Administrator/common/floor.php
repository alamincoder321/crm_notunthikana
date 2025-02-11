<div id="floor">
    <form @submit.prevent="saveData">
        <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Floor Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="floor.Floor_Name" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-md-7 col-md-offset-4 text-right">
                        <input type="submit" class="btn btn-success btn-sm" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="floors" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.sl }}</td>
                            <td>{{ row.Floor_Name }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editData(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteData(row.Floor_SlNo)">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
        el: '#floor',
        data() {
            return {
                floor: {
                    Floor_SlNo: 0,
                    Floor_Name: '',
                },
                floors: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Floor Name',
                        field: 'Floor_Name',
                        align: 'center'
                    },

                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 100,
                filter: ''
            }
        },
        created() {
            this.getFloor();
        },
        methods: {
            getFloor() {
                axios.get('/get_floor').then(res => {
                    this.floors = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            saveData() {
                let url = '/add_floor';
                if (this.floor.Floor_SlNo != 0) {
                    url = '/update_floor';
                }

                axios.post(url, this.floor).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.resetForm();
                        this.getFloor();
                    }
                })
            },
            editData(floor) {
                let keys = Object.keys(this.floor);
                keys.forEach(key => {
                    this.floor[key] = floor[key];
                })
            },
            deleteData(floorId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_floor', {
                    floorId: floorId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.getFloor();
                    }
                })
            },
            resetForm() {
                let keys = Object.keys(this.floor);
                keys.forEach(key => {
                    if (typeof(this.floor[key]) == 'string') {
                        this.floor[key] = '';
                    } else if (typeof(this.floor[key]) == 'number') {
                        this.floor[key] = 0;
                    }
                })
            }
        }
    })
</script>