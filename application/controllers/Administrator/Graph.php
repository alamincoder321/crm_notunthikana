<?php
class Graph extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = $this->session->userdata('userId');
        $this->branchId = $this->session->userdata('BRANCHid');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
    }

    public function graph()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Graph";
        $data['content'] = $this->load->view('Administrator/graph/graph', $data, true);
        $this->load->view('Administrator/index', $data);
    }

    public function getGraphData()
    {

        $year = date('Y');
        $month = date('m');

        $clauses = "";
        $userId = $this->session->userdata('userId');
        if ($this->session->userdata("accountType") != 'm') {
            $clauses .= " and c.user_id = '$userId'";
        }

        $today_client = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    left join tbl_user u on u.User_SlNo = c.user_id 
                    where c.status != 'd'
                    and DATE_FORMAT(c.AddTime, '%Y-%m-%d') = ?
                    $clauses
            ", [date('Y-m-d')])->row()->total;

        $monthly_client = $this->db->query("
                select 
                ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                from tbl_customer c
                left join tbl_user u on u.User_SlNo = c.user_id 
                where c.status != 'd'
                and month(c.AddTime) = ?
                and year(c.AddTime) = ?
                $clauses
            ", [$month, $year])->row()->total;

        $total_client = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    left join tbl_user u on u.User_SlNo = c.user_id 
                    where c.status != 'd'
                    $clauses
            ")->row()->total;


        $sold_client = $this->db->query("
            select 
                ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                from tbl_customer c
                left join tbl_user u on u.User_SlNo = c.user_id 
                where c.status != 'd'
                and c.customer_status = 'Sale'
                $clauses
        ")->row()->total;
        
        $rent_client = $this->db->query("
            select 
                ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                from tbl_customer c
                left join tbl_user u on u.User_SlNo = c.user_id 
                where c.status != 'd'
                and c.customer_status = 'Rent'
                $clauses
        ")->row()->total;

        //land        
        $today_land = $this->db->query("
                select 
                    ifnull(count(ifnull(l.Land_SlNo, 0)), 0) as total
                    from tbl_land l
                    where l.Status != 'd'
                    and l.AddTime between ? and ?
            ", [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"])->row()->total;

        $monthly_land = $this->db->query("
                select 
                ifnull(count(ifnull(l.Land_SlNo, 0)), 0) as total
                from tbl_land l
                where l.Status != 'd'
                and month(l.AddTime) = ?
                and year(l.AddTime) = ?
            ", [$month, $year])->row()->total;

        $total_land = $this->db->query("
                select 
                    ifnull(count(ifnull(l.Land_SlNo, 0)), 0) as total
                    from tbl_land l
                    where l.Status != 'd'
            ")->row()->total;


        $sold_land = $this->db->query("
            select 
                ifnull(count(ifnull(l.Land_SlNo, 0)), 0) as total
                from tbl_land l
                where l.Status != 'd'
                and l.land_status = 'Sold'
        ")->row()->total;
        
        $rent_land = $this->db->query("
            select 
                ifnull(count(ifnull(l.Land_SlNo, 0)), 0) as total
                from tbl_land l
                where l.Status != 'd'
                and l.land_status = 'Rented'
        ")->row()->total;
        
        //property
        $propertyClauses = "";
        if ($this->session->userdata("accountType") != 'm') {
            $propertyClauses = "and pr.user_id = '$userId'";
        }

        $today_property = $this->db->query("
                select 
                    ifnull(count(ifnull(pr.Property_SlNo, 0)), 0) as total
                    from tbl_property pr
                    where pr.Status != 'd'
                    and DATE_FORMAT(pr.AddTime, '%Y-%m-%d') = ?
                    $propertyClauses
            ", [date('Y-m-d')])->row()->total;

        $monthly_property = $this->db->query("
                select 
                ifnull(count(ifnull(pr.Property_SlNo, 0)), 0) as total
                from tbl_property pr
                where pr.Status != 'd'
                and month(pr.AddTime) = ?
                and year(pr.AddTime) = ?
                $propertyClauses
            ", [$month, $year])->row()->total;

        $total_property = $this->db->query("
                select 
                    ifnull(count(ifnull(pr.Property_SlNo, 0)), 0) as total
                    from tbl_property pr
                    where pr.Status != 'd'
                    $propertyClauses
            ")->row()->total;


        $sold_property = $this->db->query("
            select 
                ifnull(count(ifnull(pr.Property_SlNo, 0)), 0) as total
                from tbl_property pr
                where pr.Status != 'd'
                and pr.property_status = 'Sold'
                $propertyClauses
        ")->row()->total;
        
        $rent_property = $this->db->query("
            select 
                ifnull(count(ifnull(pr.Property_SlNo, 0)), 0) as total
                from tbl_property pr
                where pr.Status != 'd'
                and pr.property_status = 'Rented'
                $propertyClauses
        ")->row()->total;

        $source1 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 1
            ")->row()->total;

        $source2 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 2
            ")->row()->total;
        $source3 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 3
            ")->row()->total;
        $source4 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 4
            ")->row()->total;
        $source5 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 5
            ")->row()->total;
        $source6 = $this->db->query("
                select 
                    ifnull(count(ifnull(c.Customer_SlNo, 0)), 0) as total
                    from tbl_customer c
                    where c.status != 'd'
                    and c.source_id = 6
            ")->row()->total;

        $total_report = $this->db->query("
                select 
                    ifnull(count(ifnull(c.id, 0)), 0) as total
                    from tbl_client_report c
                    where c.status = 'a'
            ")->row()->total;

        $today_report = $this->db->query("
                select 
                    ifnull(count(ifnull(c.id, 0)), 0) as total
                    from tbl_client_report c
                    where c.status = 'a'
                    and c.report_date between ? and ?
            ", [date('Y-m-d') . " 00:00:00", date('Y-m-d') . " 23:59:59"])->row()->total;

        $monthly_report = $this->db->query("
                select 
                    ifnull(count(ifnull(c.id, 0)), 0) as total
                    from tbl_client_report c
                    where c.status = 'a'
                    and month(c.report_date) = ?
                    and year(c.report_date) = ?
            ", [$month, $year])->row()->total;


        $notices = $this->db->query("
                select c.*
                from tbl_notice c 
                where c.status != 'd'
                order by c.id desc 
            ")->result();


        // Monthly Record
        $monthlyRecord = [];
        $year = date('Y');
        $month = date('m');
        $dayNumber = date('t', mktime(0, 0, 0, $month, 1, $year));
        for ($i = 1; $i <= $dayNumber; $i++) {
            $date = $year . '-' . $month . '-' . sprintf("%02d", $i);
            $pending = $this->db->query("
                                select crp.*
                                from tbl_client_report crp
                                where crp.status != 'd'
                                and crp.report_status = 'Pending'
                                and crp.report_date = ?
                                group by crp.report_date", $date)->result();
            $completed = $this->db->query("
                                select crp.*
                                from tbl_client_report crp
                                where crp.status != 'd'
                                and crp.report_status = 'Completed'
                                and crp.report_date = ?
                                group by crp.report_date", $date)->result();

            $clientsale = [sprintf("%02d", $i), count($completed), count($pending)];
            array_push($monthlyRecord, $clientsale);
        }

        $yearlyRecord = [];
        for ($i = 1; $i <= 12; $i++) {
            $yearMonth = $year . sprintf("%02d", $i);
            $pending = $this->db->query("
                    select crp.*
                    from tbl_client_report crp
                    where crp.status != 'd'
                    and crp.report_status = 'Pending'
                    and extract(year_month from crp.report_date) = ?
                    group by extract(year_month from crp.report_date)
                ", $yearMonth)->result();
            $completed = $this->db->query("
                            select crp.*
                            from tbl_client_report crp
                            where crp.status != 'd'
                            and crp.report_status = 'Completed'
                            and extract(year_month from crp.report_date) = ?
                            group by extract(year_month from crp.report_date)
                ", $yearMonth)->result();

            $monthName = date("M", mktime(0, 0, 0, $i, 10));
            $clientsale = [$monthName, count($completed), count($pending)];

            array_push($yearlyRecord, $clientsale);
        }

        $responseData = [
            'today_land'       => $today_land,
            'monthly_land'     => $monthly_land,
            'total_land'       => $total_land,
            'sold_land'        => $sold_land,
            'rent_land'        => $rent_land,
            'today_property'   => $today_property,
            'monthly_property' => $monthly_property,
            'total_property'   => $total_property,
            'sold_property'    => $sold_property,
            'rent_property'    => $rent_property,
            'today_client'     => $today_client,
            'monthly_client'   => $monthly_client,
            'total_client'     => $total_client,
            'sold_client'      => $sold_client,
            'rent_client'      => $rent_client,
            'today_report'     => $today_report,
            'monthly_report'   => $monthly_report,
            'total_report'     => $total_report,
            'notices'          => $notices,
            'source1'          => $source1,
            'source2'          => $source2,
            'source3'          => $source3,
            'source4'          => $source4,
            'source5'          => $source5,
            'source6'          => $source6,

            'monthly_record' => $monthlyRecord,
            'yearly_record' => $yearlyRecord,
        ];

        echo json_encode($responseData, JSON_NUMERIC_CHECK);
    }
}
