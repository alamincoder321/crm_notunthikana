<?php
class Budget extends CI_Controller
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

    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Budget Entry";
        $data['content'] = $this->load->view('Administrator/common/budget', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getBudget()
    {
        $budget = $this->db->query("select * from tbl_budget where Status = 'a'")->result();
        echo json_encode($budget);
    }

    public function addBudget()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_budget where Status = 'a' and Budget_Name = ?", $data->Budget_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Budget name already exists"];
            } else {
                $budget = array(
                    'Budget_Name' => $data->Budget_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_budget", $budget);
                $res = ['status' => true, 'message' => 'Budget added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBudget()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_budget where Budget_SlNo != ? and Status = 'a' and Budget_Name = ?", [$data->Budget_SlNo, $data->Budget_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Budget name already exists"];
            } else {
                $budget = array(
                    'Budget_Name' => $data->Budget_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Budget_SlNo", $data->Budget_SlNo);
                $this->db->update("tbl_budget", $budget);
                $res = ['status' => true, 'message' => 'Budget update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteBudget()
    {
        $data = json_decode($this->input->raw_input_stream);

        $budget = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Budget_SlNo", $data->budgetId);
        $this->db->update("tbl_budget", $budget);
        $res = ['status' => true, 'message' => 'Budget delete successfully'];
        echo json_encode($res);
    }
}
