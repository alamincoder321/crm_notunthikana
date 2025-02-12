<?php
class Bed extends CI_Controller
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
        $data['title'] = "Bed Entry";
        $data['content'] = $this->load->view('Administrator/common/bed', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getBed()
    {
        $bed = $this->db->query("select * from tbl_bed where Status = 'a'")->result();
        echo json_encode($bed);
    }

    public function addBed()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_bed where Status = 'a' and Bed_Name = ?", $data->Bed_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Bed name already exists"];
            } else {
                $bed = array(
                    'Bed_Name' => $data->Bed_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_bed", $bed);
                $res = ['status' => true, 'message' => 'Bed added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBed()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_bed where Bed_SlNo != ? and Status = 'a' and Bed_Name = ?", [$data->Bed_SlNo, $data->Bed_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Bed name already exists"];
            } else {
                $bed = array(
                    'Bed_Name' => $data->Bed_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Bed_SlNo", $data->Bed_SlNo);
                $this->db->update("tbl_bed", $bed);
                $res = ['status' => true, 'message' => 'Bed update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteBed()
    {
        $data = json_decode($this->input->raw_input_stream);

        $bed = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Bed_SlNo", $data->bedId);
        $this->db->update("tbl_bed", $bed);
        $res = ['status' => true, 'message' => 'Bed delete successfully'];
        echo json_encode($res);
    }
}
