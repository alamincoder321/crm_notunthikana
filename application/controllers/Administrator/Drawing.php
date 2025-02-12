<?php
class Drawing extends CI_Controller
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
        $data['title'] = "Drawing Entry";
        $data['content'] = $this->load->view('Administrator/common/drawing', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getDrawing()
    {
        $drawing = $this->db->query("select * from tbl_drawing where Status = 'a'")->result();
        echo json_encode($drawing);
    }

    public function addDrawing()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_drawing where Status = 'a' and Drawing_Name = ?", $data->Drawing_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Drawing name already exists"];
            } else {
                $drawing = array(
                    'Drawing_Name' => $data->Drawing_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_drawing", $drawing);
                $res = ['status' => true, 'message' => 'Drawing added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateDrawing()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_drawing where Drawing_SlNo != ? and Status = 'a' and Drawing_Name = ?", [$data->Drawing_SlNo, $data->Drawing_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Drawing name already exists"];
            } else {
                $drawing = array(
                    'Drawing_Name' => $data->Drawing_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Drawing_SlNo", $data->Drawing_SlNo);
                $this->db->update("tbl_drawing", $drawing);
                $res = ['status' => true, 'message' => 'Drawing update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteDrawing()
    {
        $data = json_decode($this->input->raw_input_stream);

        $drawing = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Drawing_SlNo", $data->drawingId);
        $this->db->update("tbl_drawing", $drawing);
        $res = ['status' => true, 'message' => 'Drawing delete successfully'];
        echo json_encode($res);
    }
}
