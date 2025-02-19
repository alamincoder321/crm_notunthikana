<div id="member">
    <form @submit.prevent="saveData">
        <div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Member Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="member.Member_Name" required>
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
                <datatable :columns="columns" :data="members" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.sl }}</td>
                            <td>{{ row.Member_Name }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editData(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteData(row.Member_SlNo)">
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
        el: '#member',
        data() {
            return {
                member: {
                    Member_SlNo: 0,
                    Member_Name: '',
                },
                members: [],

                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Member Name',
                        field: 'Member_Name',
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
            this.getMember();
        },
        methods: {
            getMember() {
                axios.get('/get_member').then(res => {
                    this.members = res.data.map((item, index) => {
                        item.sl = index + 1;
                        return item;
                    });
                })
            },

            saveData() {
                let url = '/add_member';
                if (this.member.Member_SlNo != 0) {
                    url = '/update_member';
                }

                axios.post(url, this.member).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.resetForm();
                        this.getMember();
                    }
                })
            },
            editData(member) {
                let keys = Object.keys(this.member);
                keys.forEach(key => {
                    this.member[key] = member[key];
                })
            },
            deleteData(memberId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_member', {
                    memberId: memberId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.status) {
                        this.getMember();
                    }
                })
            },
            resetForm() {
                let keys = Object.keys(this.member);
                keys.forEach(key => {
                    if (typeof(this.member[key]) == 'string') {
                        this.member[key] = '';
                    } else if (typeof(this.member[key]) == 'number') {
                        this.member[key] = 0;
                    }
                })
            }
        }
    })
</script>