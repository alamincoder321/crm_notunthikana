<?php
class CsCustomer extends CI_Controller
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
        $data['title'] = "Cs Customer Entry";
        $data['content'] = $this->load->view('Administrator/cs_customer', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getCsCustomer()
    {
        $bath = $this->db->query("select * from tbl_cs_customer where Status = 'a'")->result();
        echo json_encode($bath);
    }

    public function addCsCustomer()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_cs_customer where Status = 'a' and Customer_Mobile = ?", $data->Customer_Mobile)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Customer Mobile already exists"];
            } else {
                $bath = array(
                    'Customer_Name'   => $data->Customer_Name,
                    'Customer_Mobile' => $data->Customer_Mobile,
                    'customer_status' => $data->customer_status,
                    'Status'          => 'a',
                    'AddBy'           => $this->session->userdata("FullName"),
                    'AddTime'         => date("Y-m-d H:i:s"),
                    'branchId'        => $this->branchId
                );
                $this->db->insert("tbl_cs_customer", $bath);
                $res = ['status' => true, 'message' => 'Customer added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateCsCustomer()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_cs_customer where Customer_SlNo != ? and Status = 'a' and Customer_Mobile = ?", [$data->Customer_SlNo, $data->Customer_Mobile])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Customer Mobile already exists"];
            } else {
                $bath = array(
                    'Customer_Name'   => $data->Customer_Name,
                    'Customer_Mobile' => $data->Customer_Mobile,
                    'customer_status' => $data->customer_status,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Customer_SlNo", $data->Customer_SlNo);
                $this->db->update("tbl_cs_customer", $bath);
                $res = ['status' => true, 'message' => 'Customer update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteCsCustomer()
    {
        $data = json_decode($this->input->raw_input_stream);

        $customer = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Customer_SlNo", $data->customerId);
        $this->db->update("tbl_cs_customer", $customer);
        $res = ['status' => true, 'message' => 'Customer delete successfully'];
        echo json_encode($res);
    }
}
