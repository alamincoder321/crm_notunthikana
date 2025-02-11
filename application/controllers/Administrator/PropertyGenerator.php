<?php
class PropertyGenerator extends CI_Controller
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
        $data['title'] = "Generator Entry";
        $data['content'] = $this->load->view('Administrator/common/generator', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getGenerator()
    {
        $generator = $this->db->query("select * from tbl_generator where Status = 'a'")->result();
        echo json_encode($generator);
    }

    public function addGenerator()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_generator where Status = 'a' and Generator_Name = ?", $data->Generator_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Generator name already exists"];
            } else {
                $generator = array(
                    'Generator_Name' => $data->Generator_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_generator", $generator);
                $res = ['status' => true, 'message' => 'Generator added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateGenerator()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_generator where Generator_SlNo != ? and Status = 'a' and Generator_Name = ?", [$data->Generator_SlNo, $data->Generator_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Generator name already exists"];
            } else {
                $generator = array(
                    'Generator_Name' => $data->Generator_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Generator_SlNo", $data->Generator_SlNo);
                $this->db->update("tbl_generator", $generator);
                $res = ['status' => true, 'message' => 'Generator update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteGenerator()
    {
        $data = json_decode($this->input->raw_input_stream);

        $generator = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Generator_SlNo", $data->generatorId);
        $this->db->update("tbl_generator", $generator);
        $res = ['status' => true, 'message' => 'Generator delete successfully'];
        echo json_encode($res);
    }
}
