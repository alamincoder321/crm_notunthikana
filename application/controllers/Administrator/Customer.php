<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Customer extends CI_Controller
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
        $data['title'] = $this->session->userdata('accountType') == 'm' ? "Client Entry" : 'Assign Client';
        $data['Customer_Code'] = $this->mt->generateCustomerCode();
        $data['content'] = $this->load->view('Administrator/add_customer', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function notice()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Notice";
        $data['content'] = $this->load->view('Administrator/notice', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function add_notice()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $customer = (array)$customerObj;
            unset($customer['id']);
            $customer["branch_id"] = $this->session->userdata("BRANCHid");

            $customer["AddBy"] = $this->session->userdata("FullName");
            $customer["AddTime"] = date("Y-m-d H:i:s");
            $customer["status"] = 'a';

            $this->db->insert('tbl_notice', $customer);

            $res_message = 'added successfully';


            $res = ['success' => true, 'message' => $res_message];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function update_notice()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $customer = (array)$customerObj;
            $customerId = $customerObj->id;

            unset($customer["id"]);
            $customer["UpdateBy"] = $this->session->userdata("FullName");
            $customer["UpdateTime"] = date("Y-m-d H:i:s");

            $this->db->where('id', $customerId)->update('tbl_notice', $customer);

            $res = ['success' => true, 'message' => 'updated successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function delete_notice()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_notice set status = 'd' where id = ?", $data->id);

            $res = ['success' => true, 'message' => 'deleted'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function get_notices()
    {
        $customers = $this->db->query("
            select
                c.*
            from tbl_notice c
            where c.status = 'a'
            order by c.id desc
        ")->result();
        echo json_encode($customers);
    }

    public function customerlist($status = 'all')
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "{$status} Client List";
        $data['status'] = $status;
        $data['content'] = $this->load->view("Administrator/reports/customer_list", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function meeting_reminder()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Meeting Reminder";
        $data['content'] = $this->load->view("Administrator/reports/meeting_reminder", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function next_call_reminder()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Next Call Reminder";
        $data['content'] = $this->load->view("Administrator/reports/next_call_reminder", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function getCustomers()
    {
        $data = json_decode($this->input->raw_input_stream);

        $order_by = " order by c.Customer_SlNo desc";

        $customerTypeClause = "";
        if ($this->session->userdata('accountType') == 'u') {
            $userId = $this->session->userdata('userId');
            $customerTypeClause .= " and c.user_id = '$userId'";
        }

        if (isset($data->customerType) && $data->customerType != null) {
            $customerTypeClause .= " and c.Customer_Type = '$data->customerType'";
        }

        if (isset($data->latest_call_date) && $data->latest_call_date != null) {
            $customerTypeClause .= " and c.latest_call_date = '$data->latest_call_date'";
        }

        if (isset($data->customer_status) && $data->customer_status != null && $data->customer_status != 'All') {
            $customerTypeClause .= " and c.customer_status = '$data->customer_status'";
        }

        if (isset($data->user_id) && $data->user_id != null) {
            $customerTypeClause .= " and c.user_id = '$data->user_id'";
        }
        if (isset($data->propertyId) && $data->propertyId != null) {
            $customerTypeClause .= " and c.propertyId = '$data->propertyId'";
        }
        if (isset($data->employeeId) && $data->employeeId != null) {
            $customerTypeClause .= " and c.employeeId = '$data->employeeId'";
        }

        if (isset($data->client_status) && $data->client_status != null) {
            $customerTypeClause .= " and c.client_status = '$data->client_status'";
        }

        if (isset($data->dateFrom) && $data->dateFrom != '') {
            $customerTypeClause .= " and DATE_FORMAT(c.AddTime, '%Y-%m-%d') between '$data->dateFrom' and '$data->dateTo'";
        }
        
        if (isset($data->meetingFrom) && $data->meetingFrom != '') {
            $customerTypeClause .= " and DATE_FORMAT(c.next_meeting_date, '%Y-%m-%d') between '$data->meetingFrom' and '$data->meetingTo'";
        }

        if (isset($data->status) && $data->status != null) {
            $customerTypeClause .= " and c.status = '$data->status'";
        }
        if (isset($data->customerId) && $data->customerId != null) {
            $customerTypeClause .= " and c.Customer_SlNo = '$data->customerId'";
        }
        if (isset($data->AddBy) && $data->AddBy != null) {
            $customerTypeClause .= " and c.AddBy = '$data->AddBy'";
        }
        if (isset($data->next_call_date) && $data->next_call_date != null) {
            $customerTypeClause .= " and c.latest_call_date = '$data->next_call_date'";
        }
        if (isset($data->next_meeting_date) && $data->next_meeting_date != null) {
            $customerTypeClause .= " and c.next_meeting_date = '$data->next_meeting_date'";
        }

        if (isset($data->Customer_Mobile) && $data->Customer_Mobile != null) {
            $customerTypeClause .= " and c.Customer_Mobile like '$data->Customer_Mobile%'";
        }

        if (isset($data->meeting_reminder)) {
            $customerTypeClause .= " and c.next_meeting_date is not null";
            $order_by = " order by c.next_meeting_date asc";
        }

        $customers = $this->db->query("
            select
                c.*,
                t.type_name,
                s.source_name,
                d.District_Name,
                ifnull(u.User_Name, '') as User_Name,
                pr.Property_Name,
                pr.Property_Code,
                e.Employee_Name,
                concat_ws(' - ', c.Customer_Code, c.Customer_Name, c.Customer_Mobile) as display_name
            from tbl_customer c
            left join tbl_district d on d.District_SlNo = c.area_ID
            left join tbl_source s on s.id = c.source_id
            left join tbl_type t on t.id = c.type_id
            left join tbl_user u on u.User_SlNo = c.user_id
            left join tbl_property pr on pr.Property_SlNo = c.propertyId
            left join tbl_employee e on e.Employee_SlNo = c.employeeId
            where c.status != 'd'
            $customerTypeClause
            $order_by
        ", $this->session->userdata('BRANCHid'))->result();
        echo json_encode($customers);
    }

    public function addCustomer()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $customerCodeCount = $this->db->query("select * from tbl_customer where Customer_Code = ?", $customerObj->Customer_Code)->num_rows();
            if ($customerCodeCount > 0) {
                $customerObj->Customer_Code = $this->mt->generateCustomerCode($customerObj->Customer_Type);
            }

            if (empty($customerObj->user_id)) {
                $customerObj->user_id = NULL;
            }

            $customer = (array)$customerObj;
            unset($customer['Customer_SlNo']);
            unset($customer['Customer_Code']);
            $customer["Customer_Code"] = $this->mt->generateCustomerCode();
            $customer["Customer_brunchid"] = $this->session->userdata("BRANCHid");

            $customerId = null;
            $res_message = "";

            $duplicateMobileQuery = $this->db->query("select * from tbl_customer where Customer_Mobile = ? and Customer_brunchid = ? and status != 'd' and Customer_Mobile != ''", [$customerObj->Customer_Mobile, $this->session->userdata("BRANCHid")]);

            if ($duplicateMobileQuery->num_rows() > 0) {
                $res = ['success' => false, 'message' => 'Mobile Number Already Exists'];
                echo json_encode($res);
                exit;
            } else {
                $customer["AddBy"] = $this->session->userdata("FullName");
                $customer["AddTime"] = date("Y-m-d H:i:s");
                $customer["status"] = 'p';

                $this->db->insert('tbl_customer', $customer);
                $customerId = $this->db->insert_id();

                $res_message = 'Customer added successfully';
            }


            if (!empty($_FILES)) {
                $imagePath = $this->mt->uploadImage($_FILES, 'image', 'uploads/customers', $customerObj->Customer_Code);
                $this->db->query("update tbl_customer set image_name = ? where Customer_SlNo = ?", [$imagePath, $customerId]);
            }

            $res = ['success' => true, 'message' => $res_message, 'customerCode' => $this->mt->generateCustomerCode()];
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

            $customerMobileCount = $this->db->query("select * from tbl_customer where Customer_Mobile = ? and Customer_Mobile != '' and Customer_SlNo != ? and Customer_brunchid = ? and status != 'd'", [$customerObj->Customer_Mobile, $customerObj->Customer_SlNo, $this->session->userdata("BRANCHid")])->num_rows();

            if ($customerMobileCount > 0) {
                $res = ['success' => false, 'message' => 'Mobile number already exists'];
                echo Json_encode($res);
                exit;
            }

            $customer = (array)$customerObj;
            $customerId = $customerObj->Customer_SlNo;

            unset($customer["Customer_SlNo"]);
            $customer["Customer_brunchid"] = $this->session->userdata("BRANCHid");
            $customer["UpdateBy"] = $this->session->userdata("FullName");
            $customer["UpdateTime"] = date("Y-m-d H:i:s");
            $customer["next_meeting_date"] = !empty($customerObj->next_meeting_date) ? $customerObj->next_meeting_date : NULL;

            $this->db->where('Customer_SlNo', $customerId)->update('tbl_customer', $customer);

            $customerImage = $this->db->query("select * from tbl_customer c where c.Customer_SlNo = ?", $customerObj->Customer_SlNo)->row();
            if (!empty($_FILES)) {
                $oldImgFile = $customerImage->image_name;
                if (file_exists($oldImgFile)) {
                    unlink($oldImgFile);
                }
                $imagePath = $this->mt->uploadImage($_FILES, 'image', 'uploads/customers', $customerObj->Customer_Code);
                $this->db->query("update tbl_customer set image_name = ? where Customer_SlNo = ?", [$imagePath, $customerObj->Customer_SlNo]);
            }

            $res = ['success' => true, 'message' => 'Customer updated successfully', 'customerCode' => $this->mt->generateCustomerCode()];
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

            $this->db->where('Customer_SlNo', $customerObj->Customer_SlNo)->update('tbl_customer', $customer);

            $res = ['success' => true, 'message' => 'Customer updated successfully', 'customerCode' => $this->mt->generateCustomerCode()];
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

            $this->db->query("update tbl_customer set status = 'd' where Customer_SlNo = ?", $data->customerId);

            $res = ['success' => true, 'message' => 'Customer deleted'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    //add meeting
    public function meeting_report()
    {
        // $access = $this->mt->userAccess();
        // if (!$access) {
        //     redirect(base_url());
        // }
        $data['title'] = "Meeting Report List";
        $data['content'] = $this->load->view("Administrator/reports/meeting_report", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function add_meeting()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $meetingObj = json_decode($this->input->raw_input_stream);

            $meeting = array(
                'user_id'     => $this->session->userdata('userId'),
                'client_id'   => $meetingObj->client_id,
                'report_date' => $meetingObj->report_date,
                'note'        => $meetingObj->note,
                'AddBy'       => $this->session->userdata('FullName'),
                'AddTime'     => date("Y-m-d H:i:s"),
                'branchId'    => $this->session->userdata("BRANCHid"),
            );

            $this->db->insert('tbl_meeting', $meeting);

            if (!empty($meetingObj->next_meeting_date)) {
                $this->db->set(['next_meeting_date' => $meetingObj->next_meeting_date])->where('Customer_SlNo', $meetingObj->client_id)->update('tbl_customer');
            } else {
                $this->db->set(['next_meeting_date' => NULL])->where('Customer_SlNo', $meetingObj->client_id)->update('tbl_customer');
            }

            $res = ['success' => true, 'message' => 'Meeting Report insert successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function get_meetings()
    {
        $data = json_decode($this->input->raw_input_stream);

        $order_by = "order by rp.id desc";

        $customerTypeClause = "";
        if ($this->session->userdata('accountType') == 'u') {
            $userId = $this->session->userdata('userId');
            $customerTypeClause .= " and rp.user_id = '$userId'";
        }

        if (isset($data->user_id) && $data->user_id != null) {
            $customerTypeClause .= " and rp.user_id = '$data->user_id'";
        }
        if (isset($data->Customer_Type) && $data->Customer_Type != null) {
            $customerTypeClause .= " and c.Customer_Type = '$data->Customer_Type'";
        }

        if (isset($data->dateFrom) && $data->dateFrom != '') {
            $customerTypeClause .= " and rp.report_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $meeting = $this->db->query("
            select
                rp.*,
                u.User_Name,
                c.Customer_Name,
                c.Customer_Code,
                c.Customer_Type,
                c.Customer_Mobile
            from tbl_meeting rp
            left join tbl_user u on u.User_SlNo = rp.user_id
            left join tbl_customer c on c.Customer_SlNo = rp.client_id
            where rp.Status != 'd'
            $customerTypeClause
            $order_by
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($meeting);
    }

    //xlx file download
    public function downloadxlxCustomer($dateFrom, $dateTo)
    {
        $customerTypeClause = " and DATE_FORMAT(c.AddTime, '%Y-%m-%d') between '$dateFrom' and '$dateTo'";

        $customers = $this->db->query("
            select
                c.*,
                t.type_name,
                s.source_name,
                d.District_Name,
                ifnull(u.User_Name, '') as User_Name,
                pr.Property_Name,
                pr.Property_Code,
                e.Employee_Name,
                concat_ws(' - ', c.Customer_Code, c.Customer_Name, c.Customer_Mobile) as display_name
            from tbl_customer c
            left join tbl_district d on d.District_SlNo = c.area_ID
            left join tbl_source s on s.id = c.source_id
            left join tbl_type t on t.id = c.type_id
            left join tbl_user u on u.User_SlNo = c.user_id
            left join tbl_property pr on pr.Property_SlNo = c.propertyId
            left join tbl_employee e on e.Employee_SlNo = c.employeeId
            where c.status != 'd'
            $customerTypeClause
        ", $this->session->userdata('BRANCHid'))->result();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row with styling
        $headerStyle = [
            'font' => [
                'bold' => true,
            ]
        ];

        $sheet->getStyle('A1:Q1')->applyFromArray($headerStyle);

        // Set the header row
        $sheet->setCellValue('A1', 'Client_Id');
        $sheet->setCellValue('B1', 'Client_Entry_Date');
        $sheet->setCellValue('C1', 'Client_Name');
        $sheet->setCellValue('D1', 'Client_Type');
        $sheet->setCellValue('E1', 'Property');
        $sheet->setCellValue('F1', 'Mobile');
        $sheet->setCellValue('G1', 'Email');
        $sheet->setCellValue('H1', 'Address');
        $sheet->setCellValue('I1', 'Area');
        $sheet->setCellValue('J1', 'Client_Stage');
        $sheet->setCellValue('K1', 'Source');
        $sheet->setCellValue('L1', 'User');
        $sheet->setCellValue('M1', 'Employee');
        $sheet->setCellValue('N1', 'Next_Meeting_Date');
        $sheet->setCellValue('O1', 'Latest_Call_Date');
        $sheet->setCellValue('P1', 'Status');
        $sheet->setCellValue('Q1', 'User_Status');
        $sheet->setCellValue('R1', 'Entry_By');
        $sheet->setCellValue('S1', 'AssignBy');

        $row = 2;
        foreach ($customers as $item) {
            $sheet->setCellValue('A' . $row, $item->Customer_Code);
            $sheet->setCellValue('B' . $row, date('d-m-Y', strtotime($item->AddTime)));
            $sheet->setCellValue('C' . $row, $item->Customer_Name);
            $sheet->setCellValue('D' . $row, $item->Customer_Type);
            $sheet->setCellValue('E' . $row, $item->Property_Name);
            $sheet->setCellValue('F' . $row, $item->Customer_Mobile);
            $sheet->setCellValue('G' . $row, $item->Customer_Email);
            $sheet->setCellValue('H' . $row, $item->Customer_Address);
            $sheet->setCellValue('I' . $row, $item->District_Name);
            $sheet->setCellValue('J' . $row, $item->type_name);
            $sheet->setCellValue('K' . $row, $item->source_name);
            $sheet->setCellValue('L' . $row, $item->User_Name);
            $sheet->setCellValue('M' . $row, $item->Employee_Name);
            $sheet->setCellValue('N' . $row, $item->next_meeting_date);
            $sheet->setCellValue('O' . $row, $item->latest_call_date);
            $sheet->setCellValue('P' . $row, $item->status);
            $sheet->setCellValue('Q' . $row, $item->customer_status);
            $sheet->setCellValue('R' . $row, $item->AddBy);
            $sheet->setCellValue('S' . $row, $item->User_Name);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "ClientList_" . time() . '.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer->save('php://output');
        exit;
    }
}
