<?php
class Zone extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = $this->session->userdata('userId');
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

        $data['title'] = "Zone Entry";
        $data['content'] = $this->load->view('Administrator/common/add_zone', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getZone()
    {
        $data = json_decode($this->input->raw_input_stream);

        $category = $this->db->query("select z.*
                                        from tbl_zone z                                        
                                        where z.status = 'a'")->result();

        echo json_encode($category);
    }

    public function addZone()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $categoryObj = json_decode($this->input->raw_input_stream);

            $category = (array)$categoryObj;
            $category['status'] = 'a';
            $category['AddBy'] = $this->session->userdata("FullName");
            $category['AddTime'] = date('Y-m-d H:i:s');

            $this->db->insert('tbl_zone', $category);

            $res = ['success' => true, 'message' => 'Zone added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateZone()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $categoryObj = json_decode($this->input->raw_input_stream);

            $category = (array)$categoryObj;
            $category['status'] = 'a';
            $category['UpdateBy'] = $this->session->userdata("FullName");
            $category['UpdateTime'] = date('Y-m-d H:i:s');

            $this->db->where('Zone_SlNo', $categoryObj->Zone_SlNo);
            $this->db->update('tbl_zone', $category);

            $res = ['success' => true, 'message' => 'Zone update successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteZone()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status' => 'd'])->where('Zone_SlNo', $data->categoryId)->update('tbl_zone');

            $res = ['success' => true, 'message' => 'Zone deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
}
