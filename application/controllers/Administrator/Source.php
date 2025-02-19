<?php
class Source extends CI_Controller
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
        $data['title'] = "Source Entry";
        $data['content'] = $this->load->view('Administrator/common/source', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getSource()
    {
        $source = $this->db->query("select * from tbl_source where Status = 'a'")->result();
        echo json_encode($source);
    }

    public function addSource()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_source where Status = 'a' and Source_Name = ?", $data->Source_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Source name already exists"];
            } else {
                $source = array(
                    'Source_Name' => $data->Source_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_source", $source);
                $res = ['status' => true, 'message' => 'Source added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSource()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_source where Source_SlNo != ? and Status = 'a' and Source_Name = ?", [$data->Source_SlNo, $data->Source_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Source name already exists"];
            } else {
                $source = array(
                    'Source_Name' => $data->Source_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Source_SlNo", $data->Source_SlNo);
                $this->db->update("tbl_source", $source);
                $res = ['status' => true, 'message' => 'Source update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteSource()
    {
        $data = json_decode($this->input->raw_input_stream);

        $source = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Source_SlNo", $data->sourceId);
        $this->db->update("tbl_source", $source);
        $res = ['status' => true, 'message' => 'Source delete successfully'];
        echo json_encode($res);
    }
}
