<?php
class Sqft extends CI_Controller
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
        $data['title'] = "Sqft Entry";
        $data['content'] = $this->load->view('Administrator/common/sqft', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getSqft()
    {
        $sqft = $this->db->query("select * from tbl_sqft where Status = 'a'")->result();
        echo json_encode($sqft);
    }

    public function addSqft()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_sqft where Status = 'a' and Sqft_Name = ?", $data->Sqft_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Sqft name already exists"];
            } else {
                $sqft = array(
                    'Sqft_Name' => $data->Sqft_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_sqft", $sqft);
                $res = ['status' => true, 'message' => 'Sqft added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSqft()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_sqft where Sqft_SlNo != ? and Status = 'a' and Sqft_Name = ?", [$data->Sqft_SlNo, $data->Sqft_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Sqft name already exists"];
            } else {
                $sqft = array(
                    'Sqft_Name' => $data->Sqft_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Sqft_SlNo", $data->Sqft_SlNo);
                $this->db->update("tbl_sqft", $sqft);
                $res = ['status' => true, 'message' => 'Sqft update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteSqft()
    {
        $data = json_decode($this->input->raw_input_stream);

        $sqft = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Sqft_SlNo", $data->sqftId);
        $this->db->update("tbl_sqft", $sqft);
        $res = ['status' => true, 'message' => 'Sqft delete successfully'];
        echo json_encode($res);
    }
}
