<?php
class AptType extends CI_Controller
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
        $data['title'] = "AptType Entry";
        $data['content'] = $this->load->view('Administrator/common/aptType', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAptType()
    {
        $type = $this->db->query("select * from tbl_apt_type where Status = 'a'")->result();
        echo json_encode($type);
    }

    public function addAptType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_type where Status = 'a' and Type_Name = ?", $data->Type_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Type name already exists"];
            } else {
                $type = array(
                    'Type_Name' => $data->Type_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_apt_type", $type);
                $res = ['status' => true, 'message' => 'Type added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateAptType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_type where Type_SlNo != ? and Status = 'a' and Type_Name = ?", [$data->Type_SlNo, $data->Type_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Type name already exists"];
            } else {
                $type = array(
                    'Type_Name' => $data->Type_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Type_SlNo", $data->Type_SlNo);
                $this->db->update("tbl_apt_type", $type);
                $res = ['status' => true, 'message' => 'Type update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteAptType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $type = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Type_SlNo", $data->typeId);
        $this->db->update("tbl_apt_type", $type);
        $res = ['status' => true, 'message' => 'Type delete successfully'];
        echo json_encode($res);
    }
}
