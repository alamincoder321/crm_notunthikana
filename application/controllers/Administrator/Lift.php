<?php
class Lift extends CI_Controller
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
        $data['title'] = "Lift Entry";
        $data['content'] = $this->load->view('Administrator/common/lift', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getLift()
    {
        $lift = $this->db->query("select * from tbl_lift where Status = 'a'")->result();
        echo json_encode($lift);
    }

    public function addLift()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_lift where Status = 'a' and Lift_Name = ?", $data->Lift_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Lift name already exists"];
            } else {
                $lift = array(
                    'Lift_Name' => $data->Lift_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_lift", $lift);
                $res = ['status' => true, 'message' => 'Lift added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateLift()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_lift where Lift_SlNo != ? and Status = 'a' and Lift_Name = ?", [$data->Lift_SlNo, $data->Lift_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Lift name already exists"];
            } else {
                $lift = array(
                    'Lift_Name' => $data->Lift_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Lift_SlNo", $data->Lift_SlNo);
                $this->db->update("tbl_lift", $lift);
                $res = ['status' => true, 'message' => 'Lift update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteLift()
    {
        $data = json_decode($this->input->raw_input_stream);

        $lift = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Lift_SlNo", $data->liftId);
        $this->db->update("tbl_lift", $lift);
        $res = ['status' => true, 'message' => 'Lift delete successfully'];
        echo json_encode($res);
    }
}
