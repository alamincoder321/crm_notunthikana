<?php
class Parking extends CI_Controller
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
        $data['title'] = "Parking Entry";
        $data['content'] = $this->load->view('Administrator/common/parking', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getParking()
    {
        $parking = $this->db->query("select * from tbl_parking where Status = 'a'")->result();
        echo json_encode($parking);
    }

    public function addParking()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_parking where Status = 'a' and Parking_Name = ?", $data->Parking_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Parking name already exists"];
            } else {
                $parking = array(
                    'Parking_Name' => $data->Parking_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_parking", $parking);
                $res = ['status' => true, 'message' => 'Parking added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateParking()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_parking where Parking_SlNo != ? and Status = 'a' and Parking_Name = ?", [$data->Parking_SlNo, $data->Parking_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Parking name already exists"];
            } else {
                $parking = array(
                    'Parking_Name' => $data->Parking_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Parking_SlNo", $data->Parking_SlNo);
                $this->db->update("tbl_parking", $parking);
                $res = ['status' => true, 'message' => 'Parking update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteParking()
    {
        $data = json_decode($this->input->raw_input_stream);

        $parking = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Parking_SlNo", $data->parkingId);
        $this->db->update("tbl_parking", $parking);
        $res = ['status' => true, 'message' => 'Parking delete successfully'];
        echo json_encode($res);
    }
}
