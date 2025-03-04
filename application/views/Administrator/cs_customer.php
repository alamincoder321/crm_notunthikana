<div id="customer">
    <form @submit.prevent="saveData">
        <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Customer Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="customer.Customer_Name" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Customer Mobile:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="customer.Customer_Mobile" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Status:</label>
                    <div class="col-md-7">
                        <select class="form-control" style="padding: 0 1px;" v-model="customer.customer_status">
                            <option value=""></option>
                            <option value="positive">Positive</option>
                            <option value="negative">Negative</option>
                        </select>
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
                <datatable :columns="columns" :data="customers" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.sl }}</td>
                            <td>{{ row.AddTime | dateFormat("DD/MM/YYYY") }}</td>
                            <td>{{ row.Customer_Name }}</td>
                            <td>{{ row.Customer_Mobile }}</td>
                            <td>
                                <span v-show="row.customer_status == 'positive'" class="badge badge-success">Positive</span>
                                <span v-show="row.customer_status == 'negative'" class="badge badge-danger">Negative</span>
                            </td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editData(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteData(row.Customer_SlNo)">
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
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#customer',
        data() {
            return {
                customer: {
                    Customer_SlNo: 0,
                    Customer_Name: '',
                    Customer_Mobile: '',
                    customer_status: ''
                },
                customers: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Added Date',
                        field: 'AddTime',
                        align: 'center'
                    },
                    {
                        label: 'Customer Name',
                        field: 'Customer_Name',
                        align: 'center'
                    },
                    {
                        label: 'Customer Mobile',
                        field: 'Customer_Mobile',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'customer_status',
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
        filters: {
            dateFormat(dt, format){
                return dt == '' || dt == null ? "" : moment(dt).format(format);
            },
        },
        created() {
            this.getData();
        },
        methods: {
            getData() {
                axios.get('/get_cs_customer').then(res => {
                    this.customers = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            saveData() {
                let url = '/add_cs_customer';
                if (this.customer.Customer_SlNo != 0) {
                    url = '/update_cs_customer';
                }

                axios.post(url, this.customer).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.resetForm();
                        this.getData();
                    }
                })
            },
            editData(customer) {
                let keys = Object.keys(this.customer);
                keys.forEach(key => {
                    this.customer[key] = customer[key];
                })
            },
            deleteData(customerId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_cs_customer', {
                    customerId: customerId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.getData();
                    }
                })
            },
            resetForm() {
                let keys = Object.keys(this.customer);
                keys.forEach(key => {
                    if (typeof(this.customer[key]) == 'string') {
                        this.customer[key] = '';
                    } else if (typeof(this.customer[key]) == 'number') {
                        this.customer[key] = 0;
                    }
                })
            }
        }
    })
</script>