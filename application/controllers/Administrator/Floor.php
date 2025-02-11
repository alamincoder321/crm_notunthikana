<?php
class Floor extends CI_Controller
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
        $data['title'] = "Floor Entry";
        $data['content'] = $this->load->view('Administrator/common/floor', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getFloor()
    {
        $floor = $this->db->query("select * from tbl_floor where Status = 'a'")->result();
        echo json_encode($floor);
    }

    public function addFloor()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_floor where Status = 'a' and Floor_Name = ?", $data->Floor_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Floor name already exists"];
            } else {
                $floor = array(
                    'Floor_Name' => $data->Floor_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_floor", $floor);
                $res = ['status' => true, 'message' => 'Floor added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateFloor()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_floor where Floor_SlNo != ? and Status = 'a' and Floor_Name = ?", [$data->Floor_SlNo, $data->Floor_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Floor name already exists"];
            } else {
                $floor = array(
                    'Floor_Name' => $data->Floor_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Floor_SlNo", $data->Floor_SlNo);
                $this->db->update("tbl_floor", $floor);
                $res = ['status' => true, 'message' => 'Floor update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteFloor()
    {
        $data = json_decode($this->input->raw_input_stream);

        $floor = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Floor_SlNo", $data->floorId);
        $this->db->update("tbl_floor", $floor);
        $res = ['status' => true, 'message' => 'Floor delete successfully'];
        echo json_encode($res);
    }
}
