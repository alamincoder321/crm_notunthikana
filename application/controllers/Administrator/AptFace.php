<?php
class AptFace extends CI_Controller
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
        $data['title'] = "AptFace Entry";
        $data['content'] = $this->load->view('Administrator/common/face', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAptFace()
    {
        $aptface = $this->db->query("select * from tbl_apt_face where Status = 'a'")->result();
        echo json_encode($aptface);
    }

    public function addAptFace()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_face where Status = 'a' and Face_Name = ?", $data->Face_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "AptFace name already exists"];
            } else {
                $face = array(
                    'Face_Name' => $data->Face_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_apt_face", $face);
                $res = ['status' => true, 'message' => 'AptFace added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateAptFace()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_apt_face where Face_SlNo != ? and Status = 'a' and Face_Name = ?", [$data->Face_SlNo, $data->Face_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "AptFace name already exists"];
            } else {
                $face = array(
                    'Face_Name' => $data->Face_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Face_SlNo", $data->Face_SlNo);
                $this->db->update("tbl_apt_face", $face);
                $res = ['status' => true, 'message' => 'AptFace update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteAptFace()
    {
        $data = json_decode($this->input->raw_input_stream);

        $face = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Face_SlNo", $data->faceId);
        $this->db->update("tbl_apt_face", $face);
        $res = ['status' => true, 'message' => 'AptFace delete successfully'];
        echo json_encode($res);
    }
}
