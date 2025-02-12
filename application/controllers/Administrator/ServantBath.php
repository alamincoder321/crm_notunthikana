<?php
class ServantBath extends CI_Controller
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
        $data['title'] = "ServantBath Entry";
        $data['content'] = $this->load->view('Administrator/common/bath', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getServantBath()
    {
        $bath = $this->db->query("select * from tbl_servant_bath where Status = 'a'")->result();
        echo json_encode($bath);
    }

    public function addServantBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_servant_bath where Status = 'a' and Sbath_Name = ?", $data->Sbath_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Servant bath name already exists"];
            } else {
                $sbath = array(
                    'Sbath_Name' => $data->Sbath_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_servant_bath", $sbath);
                $res = ['status' => true, 'message' => 'Servant bath added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateServantBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_servant_bath where Sbath_SlNo != ? and Status = 'a' and Sbath_Name = ?", [$data->Sbath_SlNo, $data->Sbath_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Servent bath name already exists"];
            } else {
                $sbath = array(
                    'Sbath_Name' => $data->Sbath_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Sbath_SlNo", $data->Sbath_SlNo);
                $this->db->update("tbl_servant_bath", $sbath);
                $res = ['status' => true, 'message' => 'Servent bath update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteServantBath()
    {
        $data = json_decode($this->input->raw_input_stream);

        $sbath = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Sbath_SlNo", $data->sbathId);
        $this->db->update("tbl_servant_bath", $sbath);
        $res = ['status' => true, 'message' => 'Servant bath delete successfully'];
        echo json_encode($res);
    }
}
