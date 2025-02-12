<?php
class AptStatus extends CI_Controller
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
        $data['title'] = "AptStatus Entry";
        $data['content'] = $this->load->view('Administrator/common/aptStatus', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAptStatus()
    {
        $status = $this->db->query("select * from tbl_apt_status where Status = 'a'")->result();
        echo json_encode($status);
    }

    public function addAptStatus()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_status where Status = 'a' and Status_Name = ?", $data->Status_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "AptStatus name already exists"];
            } else {
                $status = array(
                    'Status_Name' => $data->Status_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_apt_status", $status);
                $res = ['status' => true, 'message' => 'Status added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateAptStatus()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_status where Status_SlNo != ? and Status = 'a' and Status_Name = ?", [$data->Status_SlNo, $data->Status_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "AptStatus name already exists"];
            } else {
                $status = array(
                    'Status_Name' => $data->Status_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Status_SlNo", $data->Status_SlNo);
                $this->db->update("tbl_apt_status", $status);
                $res = ['status' => true, 'message' => 'Status update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteAptStatus()
    {
        $data = json_decode($this->input->raw_input_stream);

        $status = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Status_SlNo", $data->statusId);
        $this->db->update("tbl_apt_status", $status);
        $res = ['status' => true, 'message' => 'Status delete successfully'];
        echo json_encode($res);
    }
}
