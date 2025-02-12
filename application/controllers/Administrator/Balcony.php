<?php
class Balcony extends CI_Controller
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
        $data['title'] = "Balcony Entry";
        $data['content'] = $this->load->view('Administrator/common/balcony', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getBalcony()
    {
        $balcony = $this->db->query("select * from tbl_balcony where Status = 'a'")->result();
        echo json_encode($balcony);
    }

    public function addBalcony()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_balcony where Status = 'a' and Balcony_Name = ?", $data->Balcony_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Balcony name already exists"];
            } else {
                $balcony = array(
                    'Balcony_Name' => $data->Balcony_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_balcony", $balcony);
                $res = ['status' => true, 'message' => 'Balcony added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateBalcony()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_balcony where Balcony_SlNo != ? and Status = 'a' and Balcony_Name = ?", [$data->Balcony_SlNo, $data->Balcony_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Balcony name already exists"];
            } else {
                $balcony = array(
                    'Balcony_Name' => $data->Balcony_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Balcony_SlNo", $data->Balcony_SlNo);
                $this->db->update("tbl_balcony", $balcony);
                $res = ['status' => true, 'message' => 'Balcony update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteBalcony()
    {
        $data = json_decode($this->input->raw_input_stream);

        $balcony = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Balcony_SlNo", $data->balconyId);
        $this->db->update("tbl_balcony", $balcony);
        $res = ['status' => true, 'message' => 'Balcony delete successfully'];
        echo json_encode($res);
    }
}
