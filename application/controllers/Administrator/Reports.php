<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->helper('form');
    }
    public function showRentReport($customerId)
    {
        $data['rent_client'] = $this->db->where('Customer_SlNo', $customerId)->get('tbl_customer')->row();
        $data['title'] = "Rent Message Entry";
        $data['customerId'] = $customerId;
        $data['content'] = $this->load->view('Administrator/reports/rent_report_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getRentReport()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clauses = "";
        if (isset($data->customerId) && $data->customerId != "") {
            $clauses .= " and rrp.customer_id = '$data->customerId'";
        }
        $query = $this->db
            ->query("select rrp.*,
                c.Customer_Name 
                from tbl_rent_report rrp
                left join tbl_customer c on c.Customer_SlNo = rrp.customer_id 
                where rrp.Status != 'd' $clauses")
            ->result();

        echo json_encode($query);
    }

    public function addRentReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $report = (array)$data;
            if (empty($data->visit_schedule)) {
                $report['visit_schedule'] = NULL;
            }
            if (empty($data->call_schedule)) {
                $report['call_schedule'] = NULL;
            }
            unset($report['id']);
            $report["user_id"] = $this->session->userdata("userId");
            $report["AddBy"] = $this->session->userdata("FullName");
            $report["AddTime"] = date("Y-m-d H:i:s");
            $report["branchId"] = $this->session->userdata("BRANCHid");

            $this->db->insert("tbl_rent_report", $report);

            // update rent customer
            $this->db->where('Customer_SlNo', $data->customer_id)->update('tbl_customer', ['status' => 'a']);

            $res = ['status' => true, 'message' => 'Follow up message added successfully'];
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteRentReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $rent_report = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("id", $data->id);
        $this->db->update("tbl_rent_report", $rent_report);
        $res = ['status' => true, 'message' => 'Follow up message delete successfully'];
        echo json_encode($res);
    }

    // sale report
    public function showSaleReport($customerId)
    {
        $data['sale_client'] = $this->db->where('Customer_SlNo', $customerId)->get('tbl_sale_customer')->row();
        $data['title'] = "Sale Message Entry";
        $data['customerId'] = $customerId;
        $data['content'] = $this->load->view('Administrator/reports/sale_report_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getSaleReport()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clauses = "";
        if (isset($data->customerId) && $data->customerId != "") {
            $clauses .= " and rrp.customer_id = '$data->customerId'";
        }
        $query = $this->db
            ->query("select rrp.* from tbl_sale_report rrp where rrp.Status != 'd' $clauses")
            ->result();

        echo json_encode($query);
    }

    public function addSaleReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $report = (array)$data;
            if (empty($data->visit_schedule)) {
                $report['visit_schedule'] = NULL;
            }
            if (empty($data->call_schedule)) {
                $report['call_schedule'] = NULL;
            }
            unset($report['id']);
            $report["user_id"] = $this->session->userdata("userId");
            $report["AddBy"] = $this->session->userdata("FullName");
            $report["AddTime"] = date("Y-m-d H:i:s");
            $report["branchId"] = $this->session->userdata("BRANCHid");

            $this->db->insert("tbl_sale_report", $report);

            // update sale customer
            $this->db->where('Customer_SlNo', $data->customer_id)->update('tbl_sale_customer', ['status' => 'a']);

            $res = ['status' => true, 'message' => 'Follow up message added successfully'];
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteSaleReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $sale_report = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("id", $data->id);
        $this->db->update("tbl_sale_report", $sale_report);
        $res = ['status' => true, 'message' => 'Follow up message delete successfully'];
        echo json_encode($res);
    }

    public function rentReportList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Rent Report List";
        $data['status'] = '';
        $data['content'] = $this->load->view("Administrator/reports/rent_report_list", $data, true);
        $this->load->view("Administrator/index", $data);
    }
    public function callrentReportList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Rent Report List";
        $data['status'] = '';
        $data['content'] = $this->load->view("Administrator/reports/rent_report_list", $data, true);
        $this->load->view("Administrator/index", $data);
    }
}
