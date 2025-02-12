<?php
class Bath extends CI_Controller
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
        $data['title'] = "Bath Entry";
        $data['content'] = $this->load->view('Administrator/common/bath', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getBath()
    {
        $bath = $this->db->query("select * from tbl_bath where Status = 'a'")->result();
        echo json_encode($bath);
    }

    public function addBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_bath where Status = 'a' and Bath_Name = ?", $data->Bath_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Bath name already exists"];
            } else {
                $bath = array(
                    'Bath_Name' => $data->Bath_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_bath", $bath);
                $res = ['status' => true, 'message' => 'Bath added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_bath where Bath_SlNo != ? and Status = 'a' and Bath_Name = ?", [$data->Bath_SlNo, $data->Bath_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Bath name already exists"];
            } else {
                $bath = array(
                    'Bath_Name' => $data->Bath_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Bath_SlNo", $data->Bath_SlNo);
                $this->db->update("tbl_bath", $bath);
                $res = ['status' => true, 'message' => 'Bath update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $bath = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Bath_SlNo", $data->bathId);
        $this->db->update("tbl_bath", $bath);
        $res = ['status' => true, 'message' => 'Bath delete successfully'];
        echo json_encode($res);
    }
}
