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

<div id="reportList">
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
                            <td v-text="row.Customer_Name"></td>
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
        el: '#reportList',
        data() {
            return {
                columns: [{
                        label: 'Sl.',
                        field: 'sl',
                        align: 'center'
                    },
                    {
                        label: 'Client Name',
                        field: 'Customer_Name',
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
                    }
                ],
                page: 1,
                per_page: 1000,
                filter: '',

                reports: [],
                clientRow: {},
                users: [],
                selectedUser: null,
                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
            }
        },
        created() {
            this.getRentReportList();
        },
        methods: {
            getRentReportList() {
                let filter = {
                    report_status: 'j'
                };
                axios.post('/get_rent_report', filter)
                    .then(res => {
                        this.reports = res.data.map((item, index) => {
                            item.sl = index + 1;
                            return item;
                        });
                    })
            },
        }
    })
</script>