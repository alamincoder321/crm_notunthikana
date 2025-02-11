<style>
    .widgets {
        width: 100%;
        min-height: 100px;
        padding: 8px;
        box-shadow: 0px 1px 2px #454545;
        border-radius: 3px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .widgets .widget-icon {
        width: 40px;
        height: 40px;
        padding-top: 8px;
        border-radius: 50%;
        color: white;
    }

    .widgets .widget-content {
        flex-grow: 2;
        font-weight: bold;
    }

    .widgets .widget-content .widget-text {
        font-size: 13px;
        color: #6f6f6f;
    }

    .widgets .widget-content .widget-value {
        font-size: 16px;
    }

    .custom-table-bordered,
    .custom-table-bordered>tbody>tr>td,
    .custom-table-bordered>tbody>tr>th,
    .custom-table-bordered>tfoot>tr>td,
    .custom-table-bordered>tfoot>tr>th,
    .custom-table-bordered>thead>tr>td,
    .custom-table-bordered>thead>tr>th {
        border: 1px solid #0d333b;
    }


    .card {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        box-shadow: 0 0 10px #ccc;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
    }

    .card .card-header i {
        padding: 10px 14px;
        font-size: 40px;
        border: 1px solid gray;
        border-radius: 30px;
    }

    h4 {
        margin: 0;
    }

    .headingTitle {
        display: inline-block;
        margin: 0px;
        font-weight: 900;
        padding: 3px 100px;
        border: 2px solid gray;
        text-align: center;
        border-bottom-left-radius: 30px;
        border-top-right-radius: 30px;
        margin-bottom: 8px;
        background: #08a2ed;
        color: white;
    }

    .descText p {
        text-align: left;
    }

    figure table {
        width: 100%;
        border-collapse: collapse;
    }

    figure table,
    th,
    td {
        border: 1px solid black;
    }

    figure th,
    td {
        padding: 2px 10px;
        text-align: left;
    }

    figure ol {
        margin: 0;
    }
</style>
<div id="graph">
    <?php
    $user = $this->db->query("select * from tbl_user where User_SlNo = ?", $this->session->userdata("userId"))->row();
    ?>
    <?php if ($this->session->userdata("accountType") == 'm') { ?>
        <div class="row" style="display: flex;justify-content:center;">
            <!-- land section -->
            <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
                <div class="card" style="background: #4ebff7;">
                    <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-globe" style="padding: 12px 17px;"></i></div>
                    <div class="box text-center" style="padding: 8px 3px;">
                        <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                            Today Land
                        </h3>
                        <h4>{{ today_land }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
                <div class="card" style="background: #4ebff7;">
                    <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-globe" style="padding: 12px 17px;"></i></div>
                    <div class="box text-center" style="padding: 8px 3px;">
                        <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                            Monthly Land
                        </h3>
                        <h4>{{ monthly_land }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
                <div class="card" style="background: #4ebff7;">
                    <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-globe" style="padding: 12px 17px;"></i></div>
                    <div class="box text-center" style="padding: 8px 3px;">
                        <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                            Total Land
                        </h3>
                        <h4>{{ total_land }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
                <div class="card" style="background: #4ebff7;">
                    <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-globe" style="padding: 12px 17px;"></i></div>
                    <div class="box text-center" style="padding: 8px 3px;">
                        <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                            Sale Land
                        </h3>
                        <h4>{{ sold_land }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
                <div class="card" style="background: #4ebff7;">
                    <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-globe" style="padding: 12px 17px;"></i></div>
                    <div class="box text-center" style="padding: 8px 3px;">
                        <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                            Rent Land
                        </h3>
                        <h4>{{ sold_land }}</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row" style="display: flex;justify-content:center;">
        <!-- property section -->
        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #ffc56d;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-university" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Today Property
                    </h3>
                    <h4>{{ today_property }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #ffc56d;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-university" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Monthly Property
                    </h3>
                    <h4>{{ monthly_property }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #ffc56d;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-university" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Total Property
                    </h3>
                    <h4>{{ total_property }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #ffc56d;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-university" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Sale Property
                    </h3>
                    <h4>{{ sold_property }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #ffc56d;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-university" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Rent Property
                    </h3>
                    <h4>{{ rent_property }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="display: flex;justify-content:center;">
        <!-- client section -->
        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #80ff61;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-male" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Today Client
                    </h3>
                    <h4>{{ today_client }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #80ff61;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-male" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Monthly Client
                    </h3>
                    <h4>{{ monthly_client }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #80ff61;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-male" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Total Client
                    </h3>
                    <h4>{{ total_client }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #80ff61;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-male" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Sale Client
                    </h3>
                    <h4>{{ sold_client }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-xs-6 no-padding" style="margin-bottom: 15px;">
            <div class="card" style="background: #80ff61;">
                <div class="card-header text-center" style="margin: 7px 0;"><i class="fa fa-male" style="padding: 12px 17px;"></i></div>
                <div class="box text-center" style="padding: 8px 3px;">
                    <h3 style="margin-top: 0;font-size:16px;font-weight:900;text-transform:uppercase;">
                        Rent Client
                    </h3>
                    <h4>{{ rent_client }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12 text-center">
            <h4 class="headingTitle">Notice Board</h4>
        </div>
        <div class="col-md-12">
            <table class="table custom-table-bordered">
                <tbody>
                    <tr v-for="(a, sl) in notices">
                        <td style="width: 0;">{{sl+1}}</td>
                        <th class="descText" style="text-align:left;" v-html="a.notice"></th>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row" style="margin-top:20px; margin-left:0; margin-right:0;border:1px solid gray;">
        <div class="col-md-4">
            <div class="test2" id="piechart"></div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12" v-if="salesGraph == 'monthly'">
                    <h4 style="margin: 0;" class="text-center">This Month's Client Report</h4>
                    <sales-chart type="ColumnChart" :data="salesData" :options="salesChartOptions" />
                </div>
                <div class="col-md-12" v-else>
                    <h4 style="margin: 0;" class="text-center">This Year's Client Report</h4>
                    <sales-chart type="ColumnChart" :data="yearlySalesData" :options="yearlySalesChartOptions" />
                </div>
                <div class="col-md-12 text-center">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-primary" @click="salesGraph = 'monthly'">Monthly</button>
                        <button type="button" class="btn btn-warning" @click="salesGraph = 'yearly'">Yearly</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/vue-google-charts.browser.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>






<script>
    var todayClient = '';
    var monthlyClient = '';
    var soldClient = '';
    var totalClient = '';
    var totalReport = '';
    var monthlyReport = '';
    var source1 = '';
    var source2 = '';
    var source3 = '';
    var source4 = '';
    var source5 = '';
    var source6 = '';

    let googleChart = VueGoogleCharts.GChart;
    new Vue({
        el: '#graph',
        components: {
            'sales-chart': googleChart,
        },
        data() {
            return {
                today_land: 0,
                monthly_land: 0,
                sold_land: 0,
                total_land: 0,
                rent_land: 0,

                today_property: 0,
                monthly_property: 0,
                sold_property: 0,
                rent_property: 0,
                total_property: 0,

                today_client: 0,
                monthly_client: 0,
                sold_client: 0,
                total_client: 0,
                rent_client: 0,

                today_report: 0,
                monthly_report: 0,
                total_report: 0,
                active_employee: 0,
                notices: [],
                categories: [],

                salesGraph: 'monthly',

                salesData: [
                    ['Date', 'Sale', 'Pending']
                ],
                salesChartOptions: {
                    chart: {
                        title: 'Client',
                        subtitle: "This month's client's data",
                    }
                },
                yearlySalesData: [
                    ['Month', 'Sale', 'Pending']
                ],
                yearlySalesChartOptions: {
                    chart: {
                        title: 'Client',
                        subtitle: "This year's client's data",
                    }
                },

                userType: '<?php echo $this->session->userdata("accountType"); ?>',
                userId: '<?php echo $this->session->userdata("userId"); ?>',
            }
        },
        created() {
            this.getGraphData();
        },
        methods: {
            getGraphData() {
                axios.get('/get_graph_data').then(res => {
                    this.today_land = res.data.today_land;
                    this.monthly_land = res.data.monthly_land;
                    this.total_land = res.data.total_land;
                    this.sold_land = res.data.sold_land;
                    this.rent_land = res.data.rent_land;
                    //property
                    this.today_property = res.data.today_property;
                    this.monthly_property = res.data.monthly_property;
                    this.total_property = res.data.total_property;
                    this.sold_property = res.data.sold_property;
                    this.rent_property = res.data.rent_property;

                    this.today_client = res.data.today_client;
                    todayClient = res.data.today_client;

                    this.monthly_client = res.data.monthly_client;
                    monthlyClient = res.data.monthly_client;

                    this.total_client = res.data.total_client;
                    totalClient = res.data.total_client;

                    this.sold_client = res.data.sold_client;
                    soldClient = res.data.sold_client;

                    this.rent_client = res.data.rent_client;


                    this.today_report = res.data.today_report;

                    this.monthly_report = res.data.monthly_report;
                    monthlyReport = res.data.monthly_report;

                    this.total_report = res.data.total_report;
                    totalReport = res.data.total_report;

                    this.notices = res.data.notices;
                    this.categories = res.data.categories;

                    source1 = res.data.source1;
                    source2 = res.data.source2;
                    source3 = res.data.source3;
                    source4 = res.data.source4;
                    source5 = res.data.source5;
                    source6 = res.data.source6;


                    res.data.monthly_record.forEach(d => {
                        this.salesData.push(d);
                    })

                    res.data.yearly_record.forEach(d => {
                        this.yearlySalesData.push(d);
                    })

                })
            }
        }
    });


    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {


        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Facebook', source1],
            ['Whatsapp', source2],
            ['Instagram', source6],
            ['Twiter', source4],
            ['Website', source3]
        ]);

        var options = {
            title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>