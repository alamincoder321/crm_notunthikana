<?php
class Gas extends CI_Controller
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
        $data['title'] = "Gas Entry";
        $data['content'] = $this->load->view('Administrator/common/gas', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getGas()
    {
        $gas = $this->db->query("select * from tbl_gas where Status = 'a'")->result();
        echo json_encode($gas);
    }

    public function addGas()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_gas where Status = 'a' and Gas_Name = ?", $data->Gas_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Gas name already exists"];
            } else {
                $gas = array(
                    'Gas_Name' => $data->Gas_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_gas", $gas);
                $res = ['status' => true, 'message' => 'Gas added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateGas()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_gas where Gas_SlNo != ? and Status = 'a' and Gas_Name = ?", [$data->Gas_SlNo, $data->Gas_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Gas name already exists"];
            } else {
                $gas = array(
                    'Gas_Name' => $data->Gas_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Gas_SlNo", $data->Gas_SlNo);
                $this->db->update("tbl_gas", $gas);
                $res = ['status' => true, 'message' => 'Gas update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteGas()
    {
        $data = json_decode($this->input->raw_input_stream);

        $gas = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Gas_SlNo", $data->gasId);
        $this->db->update("tbl_gas", $gas);
        $res = ['status' => true, 'message' => 'Gas delete successfully'];
        echo json_encode($res);
    }
}
