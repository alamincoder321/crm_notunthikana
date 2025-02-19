<div id="budget">
    <form @submit.prevent="saveData">
        <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Budget Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="budget.Budget_Name" required>
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
                <datatable :columns="columns" :data="budgets" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.sl }}</td>
                            <td>{{ row.Budget_Name }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editData(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteData(row.Budget_SlNo)">
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
        el: '#budget',
        data() {
            return {
                budget: {
                    Budget_SlNo: 0,
                    Budget_Name: '',
                },
                budgets: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Budget Name',
                        field: 'Budget_Name',
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
            this.getBudget();
        },
        methods: {
            getBudget() {
                axios.get('/get_budget').then(res => {
                    this.budgets = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            saveData() {
                let url = '/add_budget';
                if (this.budget.Budget_SlNo != 0) {
                    url = '/update_budget';
                }

                axios.post(url, this.budget).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.resetForm();
                        this.getBudget();
                    }
                })
            },
            editData(budget) {
                let keys = Object.keys(this.budget);
                keys.forEach(key => {
                    this.budget[key] = budget[key];
                })
            },
            deleteData(budgetId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_budget', {
                    budgetId: budgetId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.getBudget();
                    }
                })
            },
            resetForm() {
                let keys = Object.keys(this.budget);
                keys.forEach(key => {
                    if (typeof(this.budget[key]) == 'string') {
                        this.budget[key] = '';
                    } else if (typeof(this.budget[key]) == 'number') {
                        this.budget[key] = 0;
                    }
                })
            }
        }
    })
</script>