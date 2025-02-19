<?php
class Condition extends CI_Controller
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
        $data['title'] = "Condition Entry";
        $data['content'] = $this->load->view('Administrator/common/condition', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getCondition()
    {
        $condition = $this->db->query("select * from tbl_condition where Status = 'a'")->result();
        echo json_encode($condition);
    }

    public function addCondition()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_condition where Status = 'a' and Condition_Name = ?", $data->Condition_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Condition name already exists"];
            } else {
                $condition = array(
                    'Condition_Name' => $data->Condition_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_condition", $condition);
                $res = ['status' => true, 'message' => 'Condition added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateCondition()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_condition where Condition_SlNo != ? and Status = 'a' and Condition_Name = ?", [$data->Condition_SlNo, $data->Condition_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Condition name already exists"];
            } else {
                $condition = array(
                    'Condition_Name' => $data->Condition_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Condition_SlNo", $data->Condition_SlNo);
                $this->db->update("tbl_condition", $condition);
                $res = ['status' => true, 'message' => 'Condition update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteCondition()
    {
        $data = json_decode($this->input->raw_input_stream);

        $condition = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Condition_SlNo", $data->conditionId);
        $this->db->update("tbl_condition", $condition);
        $res = ['status' => true, 'message' => 'Condition delete successfully'];
        echo json_encode($res);
    }
}
