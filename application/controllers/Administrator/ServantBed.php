<?php
class ServantBed extends CI_Controller
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
        $data['title'] = "ServantBed Entry";
        $data['content'] = $this->load->view('Administrator/common/servantBed', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getServantBed()
    {
        $servantbed = $this->db->query("select * from tbl_servant_bed where Status = 'a'")->result();
        echo json_encode($servantbed);
    }

    public function addBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_servant_bed where Status = 'a' and Sbed_Name = ?", $data->Sbed_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Bath name already exists"];
            } else {
                $servantbed = array(
                    'Sbed_Name' => $data->Sbed_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_servant_bed", $servantbed);
                $res = ['status' => true, 'message' => 'Servant Bed added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateServantBed()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_servant_bed where Sbed_SlNo != ? and Status = 'a' and Sbed_Name = ?", [$data->Sbed_SlNo, $data->Sbed_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Servant Bed name already exists"];
            } else {
                $servantbed = array(
                    'Sbed_Name' => $data->Sbed_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Sbed_SlNo", $data->Sbed_SlNo);
                $this->db->update("tbl_servant_bed", $servantbed);
                $res = ['status' => true, 'message' => 'ServantBed update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteServantBed()
    {
        $data = json_decode($this->input->raw_input_stream);

        $sbed = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Sbed_SlNo", $data->sbedId);
        $this->db->update("tbl_servant_bed", $sbed);
        $res = ['status' => true, 'message' => 'Servant Bed delete successfully'];
        echo json_encode($res);
    }
}
