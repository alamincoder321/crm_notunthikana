<style scoped>
    .card {
        border: 1px solid gray;
        padding: 25px 15px;
        text-align: center;
        cursor: pointer;
    }

    button {
        padding: 8px 20px;
        background: #26a1f9;
        border: none;
        color: #fff;
        font-weight: 600;
    }

    .navCustom li>a {
        background: white !important;
    }

    .navCustom li>a:focus {
        background: white !important;
    }

    .navCustom li>a:hover {
        background: white !important;
    }
</style>
<div id="message">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <strong>Client Name: </strong> <?php echo $sale_client->Customer_Name; ?><br>
                <strong>Mobile: </strong> <?php echo $sale_client->Customer_Mobile; ?><br>
                <strong>Area: </strong> <?php echo $sale_client->Customer_Address; ?>
            </div>
            <ul class="nav nav-tabs navCustom">
                <li class="tab1" @click="tabValueSet(1)" :class="message.stage == 1 ? 'active' : ''" style="text-align:center;">
                    <a style="padding: 20px 0px;font-size:30px;" href="#first" data-toggle="tab">1<sup>st</sup> Stage</a>
                </li>
                <li class="tab2" @click="tabValueSet(2)" :class="message.stage == 2 ? 'active' : ''" style="text-align:center;">
                    <a style="padding: 20px 10px;font-size:30px;" href="#second" data-toggle="tab">2<sup>nd</sup> Stage</a>
                </li>
                <li class="tab3" @click="tabValueSet(3)" :class="message.stage == 3 ? 'active' : ''" style="text-align:center;">
                    <a style="padding: 20px 10px;font-size:30px;" href="#third" data-toggle="tab">3<sup>rd</sup> Stage</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <div id="first" class="tab-pane fade" :class="message.stage == 1 ? 'in active' : ''">
                    <div class="row">
                        <form @submit.prevent="saveMessage">
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Follow Up:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.follow_up" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Product Match:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.product_match" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Visit Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.visit_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Call Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.call_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Status:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" v-model="message.report_status" style="padding: 0 3px; border-radius: 3px;">
                                        <option value=""></option>
                                        <option value="a">Successful</option>
                                        <option value="j">Junk/Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <div class="col-xs-12 col-md-12">
                                    <button type="submit">Save Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="second" class="tab-pane fade" :class="message.stage == 2 ? 'in active' : ''">
                    <div class="row">
                        <form @submit.prevent="saveMessage">
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Follow Up:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.follow_up" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Product Match:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.product_match" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Visit Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.visit_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Call Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.call_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Status:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" v-model="message.report_status" style="padding: 0 3px; border-radius: 3px;">
                                        <option value=""></option>
                                        <option value="a">Successful</option>
                                        <option value="j">Junk/Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <div class="col-xs-12 col-md-12">
                                    <button type="submit">Save Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="third" class="tab-pane fade" :class="message.stage == 3 ? 'in active' : ''">
                    <div class="row">
                        <form @submit.prevent="saveMessage">
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Follow Up:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.follow_up" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Product Match:</label>
                                <div class="col-xs-8">
                                    <input type="text" v-model="message.product_match" class="form-control" placeholder="Typing..." />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Visit Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.visit_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Call Schedule:</label>
                                <div class="col-xs-8">
                                    <input type="datetime-local" v-model="message.call_schedule" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-4" for="follow_up">Status:</label>
                                <div class="col-xs-8">
                                    <select class="form-control" v-model="message.report_status" style="padding: 0 3px; border-radius: 3px;">
                                        <option value=""></option>
                                        <option value="a">Successful</option>
                                        <option value="j">Junk/Reject</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <div class="col-xs-12 col-md-12">
                                    <button type="submit">Save Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="reports" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td v-text="row.sl"></td>
                            <td>
                                <span class="badge" v-show="row.stage == 1">1<sup>st</sup> Stage</span>
                                <span class="badge" v-show="row.stage == 2">2<sup>nd</sup> Stage</span>
                                <span class="badge" v-show="row.stage == 3">3<sup>rd</sup> Stage</span>
                            </td>
                            <td v-text="row.follow_up"></td>
                            <td v-text="row.product_match"></td>
                            <td>
                                {{row.visit_schedule | dateFormat("DD-MM-YYYY h:mm:ss")}}
                            </td>
                            <td>
                                {{row.call_schedule | dateFormat("DD-MM-YYYY h:mm:ss")}}
                            </td>
                            <td>
                                <span class="badge badge-success" v-show="row.report_status == 'a'">Successful</span>
                                <span class="badge badge-danger" v-show="row.report_status == 'j'">Junk</span>
                            </td>
                            <td>
                                <?php if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a') { ?>
                                    <a href="" class="button" @click.prevent="deleteMessage(row.id)">
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
        el: '#message',
        data() {
            return {
                columns: [{
                        label: 'Sl.',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Stage',
                        field: 'stage',
                        align: 'center'
                    },
                    {
                        label: 'Follow Up',
                        field: 'follow_up',
                        align: 'center'
                    },
                    {
                        label: 'Product Match',
                        field: 'product_match',
                        align: 'center'
                    },
                    {
                        label: 'Visit_Schedule',
                        field: 'visit_schedule',
                        align: 'center'
                    },
                    {
                        label: 'Call_Schedule',
                        field: 'call_schedule',
                        align: 'center'
                    },
                    {
                        label: 'Status',
                        field: 'report_status',
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

                message: {
                    id: "",
                    customer_id: "<?= $customerId; ?>",
                    follow_up: "",
                    product_match: "",
                    visit_schedule: "",
                    call_schedule: "",
                    report_status: "",
                    stage: 1
                },
                reports: [],
                userType: "<?php echo $this->session->userdata('accountType') ?>",
                userId: "<?php echo $this->session->userdata('userId') ?>",
            }
        },
        filters: {
            dateFormat(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        async created() {
            this.getMessage();
        },
        methods: {
            tabValueSet(val) {
                this.message.stage = val;
            },
            getMessage() {
                let filter = {
                    customerId: this.message.customer_id
                }
                axios.post('/get_sale_report', filter)
                    .then(res => {
                        this.reports = res.data.map((item, index) => {
                            item.sl = index + 1;
                            return item;
                        });
                        let stage_one = res.data.filter(item => item.stage == 1);
                        let stage_second = res.data.filter(item => item.stage == 2);
                        let stage_third = res.data.filter(item => item.stage == 3);
                        if (stage_third.length > 0) {
                            this.message.stage = 3;
                            $(".navCustom").find('.tab1').css({
                                display: 'none'
                            });
                            $(".navCustom").find('.tab2').css({
                                display: 'none'
                            });
                            $(".navCustom").find('.tab3').attr("style", "width: 100% !important;");
                            $(".tab-content").find('#first').css({
                                display: 'none'
                            });
                            $(".tab-content").find('#second').css({
                                display: 'none'
                            });
                        } else if (stage_second.length > 0) {
                            this.message.stage = 2;
                            $(".navCustom").find('.tab1').css({
                                display: 'none'
                            });
                            $(".navCustom").find('.tab2').attr("style", "width: 50% !important;");
                            $(".navCustom").find('.tab3').attr("style", "width: 50% !important;");
                            $(".tab-content").find('#first').css({
                                display: 'none'
                            });
                        } else {
                            $(".navCustom").find('.tab1').attr("style", "width: 33.33% !important;");
                            $(".navCustom").find('.tab2').attr("style", "width: 33.33% !important;");
                            $(".navCustom").find('.tab3').attr("style", "width: 33.33% !important;");
                        }
                    })
            },
            saveMessage() {
                let url = "/add_sale_report";
                if (this.message.id != '') {
                    url = "/update_sale_report";
                }
                axios.post(url, this.message)
                    .then(res => {
                        alert(res.data.message)
                        if (res.data.status) {
                            this.getMessage();
                            this.resetForm();
                        }
                    })
            },
            editMessage(row) {
                let keys = Object.keys(this.message);
                keys.forEach(key => {
                    this.message[key] = row[key];
                })
            },
            deleteMessage(id) {
                if (!confirm("Are you sure?")) return;
                axios.post('/delete_sale_report', {
                        id: id
                    })
                    .then(res => {
                        alert(res.data.message);
                        if (res.data.status) {
                            this.getMessage();
                        }
                    })
            },
            resetForm() {
                this.message.id = "";
                this.message.customer_id = "<?= $customerId; ?>";
                this.message.follow_up = "";
                this.message.product_match = "";
                this.message.visit_schedule = "";
                this.message.call_schedule = "";
                this.message.report_status = "";
            },
        }
    })
</script>