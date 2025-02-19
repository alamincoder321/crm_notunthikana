<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class SaleCustomer extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->cbrunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->model('SMS_model', 'sms', true);
    }

    public function index()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Sale Lead Entry";
        $data['customerId'] = 0;
        $data['Customer_Code'] = $this->mt->generateSaleCustomerCode();
        $data['content'] = $this->load->view('Administrator/add_sale_customer', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function editCustomer($customerId = 0)
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Sale Lead Update";
        $data['customerId'] = $customerId;
        $data['Customer_Code'] = $this->mt->generateSaleCustomerCode();
        $data['content'] = $this->load->view('Administrator/add_sale_customer', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function customerList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Sale Lead List";
        $data['content'] = $this->load->view("Administrator/reports/sale_customer_list", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function getCustomers()
    {
        $data = json_decode($this->input->raw_input_stream);

        $order_by = " order by c.Customer_SlNo desc";

        $clauses = "";
        if ($this->session->userdata('accountType') == 'u') {
            $userId = $this->session->userdata('userId');
            $clauses .= " and c.user_id = '$userId'";
        }

        if (isset($data->customerId) && $data->customerId != null) {
            $clauses .= " and c.Customer_SlNo = '$data->customerId'";
        }

        $customers = $this->db->query("
            select
                c.*,
                concat_ws(' - ', c.Customer_Code, c.Customer_Name, c.Customer_Mobile) as display_name,
                z.Zone_Name,
                sq.Sqft_Name,
                bu.Budget_Name,
                s.Status_Name,
                cd.Condition_Name,
                sr.Source_Name,
                u.User_Name
            from tbl_sale_customer c
            left join tbl_zone z on z.Zone_SlNo = c.zone_id
            left join tbl_sqft sq on sq.Sqft_SlNo = c.sqft_id
            left join tbl_budget bu on bu.Budget_SlNo = c.budget_id
            left join tbl_apt_status s on s.Status_SlNo = c.status_id
            left join tbl_condition cd on cd.Condition_SlNo = c.condition_id
            left join tbl_source sr on sr.Source_SlNo = c.source_id
            left join tbl_user u on u.User_SlNo = c.user_id
            where c.status != 'd'
            $clauses
            $order_by
        ", $this->session->userdata('BRANCHid'))->result();
        echo json_encode($customers);
    }

    public function addCustomer()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $validations = array(
                'zone_id',
                'sqft_id',
                'budget_id',
                'status_id',
                'source_id',
                'Customer_Name',
                'Customer_Mobile'
            );

            unset($customerObj->Customer_SlNo);
            foreach ($customerObj as $key => $val) {
                $emptyVal = $val;
                if (in_array($key, $validations) && $emptyVal == '') {
                    $res = ['success' => false, 'message' => "{$key} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $customerCodeCount = $this->db->query("select * from tbl_sale_customer where Customer_Code = ?", $customerObj->Customer_Code)->num_rows();
            if ($customerCodeCount > 0) {
                $customerObj->Customer_Code = $this->mt->generateSaleCustomerCode($customerObj->Customer_Type);
            }

            if ($this->session->userdata('accountType') == 'm' || $this->session->userdata('accountType') == 'a') {
                $customerObj->user_id = NULL;
            }

            $customer = (array)$customerObj;
            unset($customer['Customer_SlNo']);
            unset($customer['Customer_Code']);
            $customer["Customer_Code"] = $this->mt->generateSaleCustomerCode();
            $customer["Customer_brunchid"] = $this->session->userdata("BRANCHid");

            $res_message = "";
            $duplicateMobileQuery = $this->db->query("select * from tbl_sale_customer where Customer_Mobile = ? and Customer_brunchid = ? and status != 'd' and Customer_Mobile != ''", [$customerObj->Customer_Mobile, $this->session->userdata("BRANCHid")]);

            if ($duplicateMobileQuery->num_rows() > 0) {
                $res = ['success' => false, 'message' => 'Mobile Number Already Exists'];
                echo json_encode($res);
                exit;
            } else {
                $customer["AddBy"] = $this->session->userdata("FullName");
                $customer["AddTime"] = date("Y-m-d H:i:s");
                $customer["status"] = 'a';

                $this->db->insert('tbl_sale_customer', $customer);
                $res_message = 'Sale Lead added successfully';
            }

            $res = ['success' => true, 'message' => $res_message, 'customerCode' => $this->mt->generateSaleCustomerCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateCustomer()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));
            $validations = array(
                'zone_id',
                'sqft_id',
                'budget_id',
                'status_id',
                'source_id',
                'Customer_Name',
                'Customer_Mobile'
            );
            
            $customerId = $customerObj->Customer_SlNo;
            unset($customerObj->Customer_SlNo);
            foreach ($customerObj as $key => $val) {
                $emptyVal = $val;
                if (in_array($key, $validations) && $emptyVal == '') {
                    $res = ['success' => false, 'message' => "{$key} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $customerMobileCount = $this->db->query("select * from tbl_sale_customer where Customer_Mobile = ? and Customer_Mobile != '' and Customer_SlNo != ? and Customer_brunchid = ? and status != 'd'", [$customerObj->Customer_Mobile, $customerId, $this->session->userdata("BRANCHid")])->num_rows();

            if ($customerMobileCount > 0) {
                $res = ['success' => false, 'message' => 'Mobile number already exists'];
                echo json_encode($res);
                exit;
            }

            $customer = (array)$customerObj;
            unset($customer["Customer_SlNo"]);
            $customer["Customer_brunchid"] = $this->session->userdata("BRANCHid");
            $customer["UpdateBy"] = $this->session->userdata("FullName");
            $customer["UpdateTime"] = date("Y-m-d H:i:s");

            $this->db->where('Customer_SlNo', $customerId)->update('tbl_sale_customer', $customer);

            $res = [
                'success' => true,
                'message' => 'Sale Lead updated successfully',
                'customerCode' => $this->mt->generateSaleCustomerCode()
            ];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function assignCustomer()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->raw_input_stream);
            $customer = array(
                'user_id' => $customerObj->user_id,
            );

            $this->db->where('Customer_SlNo', $customerObj->Customer_SlNo)->update('tbl_sale_customer', $customer);

            $res = [
                'success' => true,
                'message' => 'Customer updated successfully',
                'customerCode' => $this->mt->generateSaleCustomerCode()
            ];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteCustomer()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_sale_customer set status = 'd' where Customer_SlNo = ?", $data->customerId);

            $res = ['success' => true, 'message' => 'Customer deleted'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
}
