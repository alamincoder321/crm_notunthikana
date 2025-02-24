<?php
class PropertyCategory extends CI_Controller
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

        $data['title'] = "Property Category Entry";
        $data['content'] = $this->load->view('Administrator/common/add_property_category', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getPropertyCategory()
    {
        $data = json_decode($this->input->raw_input_stream);

        $category = $this->db->query("select c.*
                                        from tbl_property_category c                                        
                                        where c.Status = 'a'")->result();

        echo json_encode($category);
    }

    public function addPropertyCategory()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $categoryObj = json_decode($this->input->raw_input_stream);

            $category = (array)$categoryObj;
            $category['Status'] = 'a';
            $category['AddBy'] = $this->session->userdata("FullName");
            $category['AddTime'] = date('Y-m-d H:i:s');
            $category['branchId'] = $this->branchId;

            $this->db->insert('tbl_property_category', $category);

            $res = ['success' => true, 'message' => 'PropertyCategory added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updatePropertyCategory()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $categoryObj = json_decode($this->input->raw_input_stream);

            $category = (array)$categoryObj;
            $category['Status'] = 'a';
            $category['AddBy'] = $this->session->userdata("FullName");
            $category['AddTime'] = date('Y-m-d H:i:s');
            $category['branchId'] = $this->branchId;

            $this->db->where('Category_SlNo', $categoryObj->Category_SlNo);
            $this->db->update('tbl_property_category', $category);

            $res = ['success' => true, 'message' => 'PropertyCategory update successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deletePropertyCategory()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status' => 'd'])->where('Category_SlNo', $data->categoryId)->update('tbl_property_category');

            $res = ['success' => true, 'message' => 'PropertyCategory deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
}
