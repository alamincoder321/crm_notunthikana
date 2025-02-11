<div id="otp">
    <form @submit.prevent="updateOtp">
        <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Password:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="otp.password" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-md-7 col-md-offset-4">
                        <input type="submit" class="btn btn-success btn-sm" value="Update">
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
                <datatable :columns="columns" :data="otps" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.sl }}</td>
                            <td>{{ row.password }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editOtp(row)">
                                        <i class="fa fa-pencil"></i>
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
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#otp',
        data() {
            return {
                otp: {
                    id: 0,
                    password: '',
                    user_id: '',
                },
                otps: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Password',
                        field: 'password',
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
            this.getOtp();
        },
        methods: {
            getOtp() {
                axios.get('/get_otp').then(res => {
                    this.otps = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            updateOtp() {
                axios.post('/update_otp', this.otp).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.resetForm();
                        this.getOtp();
                    }
                })
            },
            editOtp(otp) {
                let keys = Object.keys(this.otp);
                keys.forEach(key => {
                    this.otp[key] = otp[key];
                })
            },

            resetForm() {
                let keys = Object.keys(this.otp);
                keys.forEach(key => {
                    if (typeof(this.otp[key]) == 'string') {
                        this.otp[key] = '';
                    } else if (typeof(this.otp[key]) == 'number') {
                        this.otp[key] = 0;
                    }
                })
            }
        }
    })
</script>