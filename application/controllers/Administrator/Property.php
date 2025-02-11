<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Property extends CI_Controller
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

        $data['title'] = "Property Entry";
        $data['content'] = $this->load->view('Administrator/property/add_property', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getProperty()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";

        if (isset($data->propertyId) && $data->propertyId != '') {
            $clauses .= " and pr.Property_SlNo = '$data->propertyId'";
        }
        if (isset($data->Property_Code) && $data->Property_Code != '') {
            $clauses .= " and pr.Property_Code = '$data->Property_Code'";
        }
        if (isset($data->floorId) && $data->floorId != '') {
            $clauses .= " and pr.floorId = '$data->floorId'";
        }
        if (isset($data->categoryId) && $data->categoryId != '') {
            $clauses .= " and pr.categoryId = '$data->categoryId'";
        }

        if ($this->session->userdata('accountType') == 'u') {
            if (isset($data->user_id) && $data->user_id != '') {
                $clauses .= " and pr.user_id = '$data->user_id'";
                $clauses .= " or pr.employeeId = '$data->employee_id'";
            }
        } else {
            if (isset($data->user_id) && $data->user_id != '') {
                $clauses .= " and pr.user_id = '$data->user_id'";
            }
        }

        if (isset($data->employeeId) && $data->employeeId != '') {
            $clauses .= " and pr.employeeId = '$data->employeeId'";
        }
        if (isset($data->dateFrom) && $data->dateFrom != '') {
            $clauses .= " and pr.entry_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $property = $this->db->query("select pr.*,
                                        f.Floor_Name,
                                        ifnull(u.User_Name, '') as User_Name,
                                        pc.Category_Name
                                        from tbl_property pr
                                        left join tbl_property_category pc on pc.Category_SlNo = pr.categoryId
                                        left join tbl_floor f on f.Floor_SlNo = pr.floorId
                                        left join tbl_user u on u.User_SlNo = pr.user_id
                                        where pr.Status != 'd'
                                        $clauses
                                        order by pr.Property_SlNo desc")->result();

        echo json_encode(['propertyCode' => $this->mt->generatePropertyCode(), 'properties' => $property]);
    }

    public function addProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $propertyObj = json_decode($this->input->post('data'));

            unset($propertyObj->Property_SlNo);
            foreach ($propertyObj as $key => $val) {
                $emptyVal = $val;
                if ($emptyVal == '') {
                    $res = ['success' => false, 'message' => "{$key} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $propertyCodeCount = $this->db->query("select * from tbl_property where Property_Code = ?", $propertyObj->Property_Code)->num_rows();
            if ($propertyCodeCount > 0) {
                $propertyObj->Property_Code = $this->mt->generatePropertyCode();
            }

            $property = (array)$propertyObj;
            $property['Status'] = 'p';
            $property['AddBy'] = $this->session->userdata("FullName");
            $property['AddTime'] = date('Y-m-d H:i:s');
            $property['branchId'] = $this->branchId;

            $this->db->insert('tbl_property', $property);
            $propertyId = $this->db->insert_id();

            if (!empty($_FILES) && isset($_FILES['image'])) {
                $imagePath = $this->mt->uploadImage($_FILES, 'image', 'uploads/persons', $propertyObj->Property_Code);
                $this->db->query("update tbl_property c set c.image_name = ? where c.Property_SlNo = ?", [$imagePath, $propertyId]);
            }
            if (!empty($_FILES)) {
                $attachFiles = [];
                foreach ($_FILES['attachFile']['name'] as $key => $name) {
                    if ($_FILES['attachFile']['error'][$key] != 0) {
                        continue;
                    }
                    $tmpFilePath = $_FILES['attachFile']['tmp_name'][$key];
                    if ($tmpFilePath != "") {
                        $newFilePath = "uploads/attachFile/" . uniqid() . "_" . basename($name);
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            array_push($attachFiles, $newFilePath);
                        }
                    }
                }
                $this->db->query("update tbl_property c set c.attachFile = ? where c.Property_SlNo = ?", [json_encode($attachFiles, true), $propertyId]);
            }

            $res = ['success' => true, 'message' => 'Property added successfully', 'propertyCode' => $this->mt->generatePropertyCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $propertyObj = json_decode($this->input->post('data'));

            $emptyValueObj = $propertyObj;
            foreach ($emptyValueObj as $key => $val) {
                $emptyVal = $val;
                if ($emptyVal == '') {
                    $res = ['success' => false, 'message' => "{$key} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $propertyCodeCount = $this->db->query("select * from tbl_property where Property_Code = ? and Property_SlNo != ?", [$propertyObj->Property_Code, $propertyObj->Property_SlNo])->num_rows();
            if ($propertyCodeCount > 0) {
                $res = ['success' => false, 'message' => 'Property code already exists'];
                echo json_encode($res);
                exit;
            }

            $property = (array)$propertyObj;
            $property['UpdateBy'] = $this->session->userdata("FullName");
            $property['UpdateTime'] = date('Y-m-d H:i:s');
            $property['branchId'] = $this->branchId;

            $this->db->where('Property_SlNo', $propertyObj->Property_SlNo);
            $this->db->update('tbl_property', $property);

            $propertyImage = $this->db->query("select * from tbl_property p where p.Property_SlNo = ?", $propertyObj->Property_SlNo)->row();
            if (!empty($_FILES) && isset($_FILES['image'])) {
                $oldImgFile = $propertyImage->image_name;
                if (file_exists($oldImgFile)) {
                    unlink($oldImgFile);
                }
                $imagePath = $this->mt->uploadImage($_FILES, 'image', 'uploads/persons', $propertyObj->Property_Code);
                $this->db->query("update tbl_property set image_name = ? where Property_SlNo = ?", [$imagePath, $propertyObj->Property_SlNo]);
            }
            if (!empty($_FILES)) {
                if ($propertyImage->attachFile != NULL) {
                    $oldAttachFile = json_decode($propertyImage->attachFile, true);
                    foreach ($oldAttachFile as $key => $item) {
                        if (file_exists($item)) {
                            unlink($item);
                        }
                    }
                }
                $attachFiles = [];
                foreach ($_FILES['attachFile']['name'] as $key => $name) {
                    if ($_FILES['attachFile']['error'][$key] != 0) {
                        continue;
                    }
                    $tmpFilePath = $_FILES['attachFile']['tmp_name'][$key];
                    if ($tmpFilePath != "") {
                        $newFilePath = "uploads/attachFile/" . uniqid() . "_" . basename($name);
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            array_push($attachFiles, $newFilePath);
                        }
                    }
                }
                $this->db->query("update tbl_property c set c.attachFile = ? where c.Property_SlNo = ?", [json_encode($attachFiles, true), $propertyObj->Property_SlNo]);
            }

            $res = ['success' => true, 'message' => 'Property update successfully', 'propertyCode' => $this->mt->generatePropertyCode()];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateSingleProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $property = array(
                'next_meeting_date' => $data->next_meeting_date,
                'next_call_date'    => $data->next_call_date,
                'latest_call_date'  => $data->latest_call_date,
                'property_status'   => $data->property_status,
                'purchase_date'     => $data->purchase_date,
                'MOU_status'        => $data->MOU_status,
                'MOU_percentage'    => $data->MOU_percentage,
                'is_popular'        => $data->is_popular,
            );

            $this->db->set($property)->where('Property_SlNo', $data->Property_SlNo)->update('tbl_property');

            $res = ['success' => true, 'message' => 'Property update successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status' => 'd'])->where('Property_SlNo', $data->propertyId)->update('tbl_property');

            $res = ['success' => true, 'message' => 'Property deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function PropertyInvoicePrint($id)
    {
        $data['title'] = "Property Entry";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/property/propertyInvoicePage', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function popularProperty()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Popular Property List";
        $data['content'] = $this->load->view('Administrator/property/popular_property', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function propertyList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Property List";
        $data['content'] = $this->load->view('Administrator/property/propertyList', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    //property type
    public function propertyType()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Property Type Entry";
        $data['content'] = $this->load->view('Administrator/property/propertyType', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getpropertyType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $types = $this->db->query("select * from tbl_property_type where Status = 'a'")->result();

        echo json_encode($types);
    }

    public function addpropertyType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_property_type where Status = 'a' and Type_Name = ?", $data->Type_Name)->row();
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
                $this->db->insert("tbl_property_type", $type);
                $res = ['status' => true, 'message' => 'Type added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updatepropertyType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_property_type where Type_SlNo != ? and Status = 'a' and Type_Name = ?", [$data->Type_SlNo, $data->Type_Name])->row();
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
                $this->db->update("tbl_property_type", $type);
                $res = ['status' => true, 'message' => 'Type update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deletepropertyType()
    {
        $data = json_decode($this->input->raw_input_stream);

        $type = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Type_SlNo", $data->typeId);
        $this->db->update("tbl_property_type", $type);
        $res = ['status' => true, 'message' => 'Type delete successfully'];
        echo json_encode($res);
    }

    //purpose entry
    public function purpose()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Purpose Entry";
        $data['content'] = $this->load->view('Administrator/property/purpose', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getPurpose()
    {
        $data = json_decode($this->input->raw_input_stream);

        $purpose = $this->db->query("select * from tbl_purpose where Status = 'a'")->result();

        echo json_encode($purpose);
    }

    public function addPurpose()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_purpose where Status = 'a' and Purpose_Name = ?", $data->Purpose_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Purpose name already exists"];
            } else {
                $purpose = array(
                    'Purpose_Name' => $data->Purpose_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_purpose", $purpose);
                $res = ['status' => true, 'message' => 'Purpose added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updatePurpose()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_purpose where Purpose_SlNo != ? and Status = 'a' and Purpose_Name = ?", [$data->Purpose_SlNo, $data->Purpose_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Purpose name already exists"];
            } else {
                $purpose = array(
                    'Purpose_Name' => $data->Purpose_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Purpose_SlNo", $data->Purpose_SlNo);
                $this->db->update("tbl_purpose", $purpose);
                $res = ['status' => true, 'message' => 'Purpose update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deletePurpose()
    {
        $data = json_decode($this->input->raw_input_stream);

        $purpose = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Purpose_SlNo", $data->purposeId);
        $this->db->update("tbl_purpose", $purpose);
        $res = ['status' => true, 'message' => 'Purpose delete successfully'];
        echo json_encode($res);
    }


    public function downloadxlxProperty($dateFrom, $dateTo)
    {
        $clauses = " and pr.entry_date between '$dateFrom' and '$dateTo'";
        $property =  $this->db->query("select pr.*,
                                        f.Floor_Name,
                                        pt.Type_Name,
                                        pu.Purpose_Name,
                                        e.Employee_Name,
                                        ifnull(u.User_Name, '') as User_Name,
                                        b.Block_Name,
                                        d.District_Name,
                                        pc.Category_Name,
                                        bh.Height_Name,
                                        l.Lift_Name,
                                        va.Availability_Name,
                                        op.Occupancy_Name
                                        from tbl_property pr
                                        left join tbl_block b on b.Block_SlNo = pr.blockId
                                        left join tbl_district d on d.District_SlNo = pr.areaId
                                        left join tbl_purpose pu on pu.Purpose_SlNo = pr.purposeId
                                        left join tbl_property_category pc on pc.Category_SlNo = pr.categoryId
                                        left join tbl_property_type pt on pt.Type_SlNo = pr.typeId
                                        left join tbl_floor f on f.Floor_SlNo = pr.floorId
                                        left join tbl_building_height bh on bh.Height_SlNo = pr.heightId
                                        left join tbl_lift l on l.Lift_SlNo = pr.liftId
                                        left join tbl_viewing_availability va on va.Availability_SlNo = pr.availabilityId
                                        left join tbl_occupancy op on op.Occupancy_SlNo = pr.occupancyId
                                        left join tbl_employee e on e.Employee_SlNo = pr.employeeId
                                        left join tbl_user u on u.User_SlNo = pr.user_id
                                        where pr.Status != 'd'
                                $clauses")->result();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row with styling
        $headerStyle = [
            'font' => [
                'bold' => true,
            ]
        ];

        $sheet->getStyle('A1:AV1')->applyFromArray($headerStyle);

        // Set the header row
        $sheet->setCellValue('A1', 'Property_Code');
        $sheet->setCellValue('B1', 'Property_Name');
        $sheet->setCellValue('C1', 'Property_Address');
        $sheet->setCellValue('D1', 'Block_Name');
        $sheet->setCellValue('E1', 'Area_Name');
        $sheet->setCellValue('F1', 'Purpose_Name');
        $sheet->setCellValue('G1', 'Category_Name');
        $sheet->setCellValue('H1', 'Property_Type');
        $sheet->setCellValue('I1', 'Apt_Size');
        $sheet->setCellValue('J1', 'Apt_Size_Range');
        $sheet->setCellValue('K1', 'Price');
        $sheet->setCellValue('L1', 'Price_Per_Sq/Ft(Approx)');
        $sheet->setCellValue('M1', 'Service_Charge');
        $sheet->setCellValue('N1', 'Floor_Name');
        $sheet->setCellValue('O1', 'Unit_Number');
        $sheet->setCellValue('P1', 'Unit_Per_Floor');
        $sheet->setCellValue('Q1', 'Total_Unit');
        $sheet->setCellValue('R1', 'Building_Height');
        $sheet->setCellValue('S1', 'Bed');
        $sheet->setCellValue('T1', 'Bath');
        $sheet->setCellValue('U1', 'Balcony');
        $sheet->setCellValue('V1', 'Servent_Bed');
        $sheet->setCellValue('W1', 'Servent_Bath');
        $sheet->setCellValue('X1', 'Apt_Condition');
        $sheet->setCellValue('Y1', 'Facing');
        $sheet->setCellValue('Z1', 'Parking');
        $sheet->setCellValue('AA1', 'Gas_Connection');
        $sheet->setCellValue('AB1', 'Lift_Name');
        $sheet->setCellValue('AC1', 'Generator');
        $sheet->setCellValue('AD1', 'Land_Size');
        $sheet->setCellValue('AE1', 'Road_Size');
        $sheet->setCellValue('AF1', 'Loan_Status');
        $sheet->setCellValue('AG1', 'Availability_Name');
        $sheet->setCellValue('AH1', 'Occupancy_Status');
        $sheet->setCellValue('AI1', 'Developer_Name');
        $sheet->setCellValue('AJ1', 'Property_HandOver_Date');
        $sheet->setCellValue('AK1', 'Employee');
        $sheet->setCellValue('AL1', 'Property_Entry_Date');
        $sheet->setCellValue('AM1', 'Property_Status');
        $sheet->setCellValue('AN1', 'MOU/Purchase_Date');
        $sheet->setCellValue('AO1', 'MOU/Purchase_Status');
        $sheet->setCellValue('AP1', 'Property_Owner_Name');
        $sheet->setCellValue('AQ1', 'Property_Owner_Contact');
        $sheet->setCellValue('AR1', 'Property_Owner_Email');
        $sheet->setCellValue('AS1', 'MOU_Percentage');
        $sheet->setCellValue('AT1', 'Final_Revenue');
        $sheet->setCellValue('AU1', 'Next_Call_Date');
        $sheet->setCellValue('AV1', 'Latest_Call_Date');
        $sheet->setCellValue('AW1', 'Entry_By');
        $sheet->setCellValue('AX1', 'AssignBy');

        $row = 2;
        foreach ($property as $item) {
            $sheet->setCellValue('A' . $row, $item->Property_Code);
            $sheet->setCellValue('B' . $row, $item->Property_Name);
            $sheet->setCellValue('C' . $row, $item->Property_Address);
            $sheet->setCellValue('D' . $row, $item->Block_Name);
            $sheet->setCellValue('E' . $row, $item->District_Name);
            $sheet->setCellValue('F' . $row, $item->Purpose_Name);
            $sheet->setCellValue('G' . $row, $item->Category_Name);
            $sheet->setCellValue('H' . $row, $item->Type_Name);
            $sheet->setCellValue('I' . $row, $item->Apt_Size);
            $sheet->setCellValue('J' . $row, $item->Apt_Size_Range);
            $sheet->setCellValue('K' . $row, $item->Price);
            $sheet->setCellValue('L' . $row, $item->per_sft_rate);
            $sheet->setCellValue('M' . $row, $item->service_charge);
            $sheet->setCellValue('N' . $row, $item->Floor_Name);
            $sheet->setCellValue('O' . $row, $item->unit_number);
            $sheet->setCellValue('P' . $row, $item->unit_per_floor);
            $sheet->setCellValue('Q' . $row, $item->total_unit);
            $sheet->setCellValue('R' . $row, $item->Height_Name);
            $sheet->setCellValue('S' . $row, $item->Bed);
            $sheet->setCellValue('T' . $row, $item->Bath);
            $sheet->setCellValue('U' . $row, $item->Balcony);
            $sheet->setCellValue('V' . $row, $item->servent_bed);
            $sheet->setCellValue('W' . $row, $item->servent_bath);
            $sheet->setCellValue('X' . $row, $item->Apt_Condition);
            $sheet->setCellValue('Y' . $row, $item->facing);
            $sheet->setCellValue('Z' . $row, $item->parking);
            $sheet->setCellValue('AA' . $row, $item->Gas_Connection);
            $sheet->setCellValue('AB' . $row, $item->Lift_Name);
            $sheet->setCellValue('AC' . $row, $item->generator);
            $sheet->setCellValue('AD' . $row, $item->Land_Size);
            $sheet->setCellValue('AE' . $row, $item->road_size);
            $sheet->setCellValue('AF' . $row, $item->loan_status);
            $sheet->setCellValue('AG' . $row, $item->Availability_Name);
            $sheet->setCellValue('AH' . $row, $item->Occupancy_Name);
            $sheet->setCellValue('AI' . $row, $item->Developer);
            $sheet->setCellValue('AJ' . $row, $item->HandoverDate);
            $sheet->setCellValue('AK' . $row, $item->Employee_Name);
            $sheet->setCellValue('AL' . $row, $item->property_status);
            $sheet->setCellValue('AM' . $row, $item->entry_date);
            $sheet->setCellValue('AN' . $row, $item->purchase_date);
            $sheet->setCellValue('AO' . $row, $item->MOU_status);
            $sheet->setCellValue('AP' . $row, $item->Owner_Name);
            $sheet->setCellValue('AQ' . $row, $item->Owner_Contact);
            $sheet->setCellValue('AR' . $row, $item->Owner_Email);
            $sheet->setCellValue('AS' . $row, $item->MOU_percentage);
            $sheet->setCellValue('AT' . $row, $item->final_revenue);
            $sheet->setCellValue('AU' . $row, $item->next_call_date);
            $sheet->setCellValue('AV' . $row, $item->latest_call_date);
            $sheet->setCellValue('AW' . $row, $item->AddBy);
            $sheet->setCellValue('AX' . $row, $item->User_Name);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filename = "PropertyList_" . time() . '.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer->save('php://output');
        exit;
    }


    // report controller
    public function add_report()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $customer = (array)$customerObj;
            unset($customer['id']);
            $customer["branch_id"] = $this->session->userdata("BRANCHid");
            $customer["user_id"] = $this->session->userdata("userId");
            $customer["AddBy"] = $this->session->userdata("FullName");
            $customer["AddTime"] = date("Y-m-d H:i:s");

            $this->db->insert('tbl_property_report', $customer);

            $this->db->where("Property_SlNo", $customerObj->property_id)->update('tbl_property', ['Status' => 'a']);

            $res_message = 'Report added successfully';

            $res = ['success' => true, 'message' => $res_message];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function get_reports()
    {
        $data = json_decode($this->input->raw_input_stream);
        $userType = $this->session->userdata('accountType');


        $clause = "";
        if (isset($data->employee_id) && $data->employee_id != null) {
            $clause .= " and r.employee_id = '$data->employee_id'";
        }

        if (isset($data->property_id) && $data->property_id != null) {
            $clause .= " and r.property_id = '$data->property_id'";
        }

        if (isset($data->user_id) && $data->user_id != null) {
            $clause .= " and r.user_id = '$data->user_id'";
        }

        if (isset($data->report_status) && $data->report_status != null) {
            $clause .= " and r.report_status = '$data->report_status'";
        }

        if (isset($data->property_status) && $data->property_status != null) {
            $clause .= " and r.property_status = '$data->property_status'";
        }

        if (isset($data->propertyStatus) && $data->propertyStatus != null) {
            $clause .= " and pr.property_status = '$data->propertyStatus'";
        }
        if (isset($data->purposeId) && $data->purposeId != null) {
            $clause .= " and pr.purposeId = '$data->purposeId'";
        }

        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clause .= " and r.report_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $customers = $this->db->query("
            select
                r.*,
                pr.Property_Name,
                pr.Property_Code,
                pr.next_call_date,
                pu.Purpose_Name,
                u.User_Name,
                pr.property_status as propertyStatus
            from tbl_property_report r
            join tbl_property pr on pr.Property_SlNo = r.property_id
            left join tbl_purpose pu on pu.Purpose_SlNo = pr.purposeId
            left join tbl_user u on u.User_SlNo = r.user_id
            where r.status = 'a'
            $clause
            order by r.id desc
        ", $this->session->userdata('BRANCHid'))->result();


        echo json_encode(array_values($customers));
    }

    public function delete_report()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("update tbl_property_report set status = 'd' where id = ?", $data->reportId);

            $res = ['success' => true, 'message' => ' deleted'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function update_report()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->post('data'));

            $customer = (array)$customerObj;
            $customerId = $customerObj->id;

            unset($customer["id"]);
            $customer["branch_id"] = $this->session->userdata("BRANCHid");
            $customer["UpdateBy"] = $this->session->userdata("FullName");
            $customer["UpdateTime"] = date("Y-m-d H:i:s");

            $this->db->where('id', $customerId)->update('tbl_property_report', $customer);

            $res = ['success' => true, 'message' => 'updated successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    function report_list()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Report List";
        $data['content'] = $this->load->view('Administrator/property/property_report_list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    function propertyReminder()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Property Report Reminder";
        $data['content'] = $this->load->view('Administrator/property/property_report_reminder', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function assignProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $customerObj = json_decode($this->input->raw_input_stream);

            $customer = array(
                'user_id' => $customerObj->user_id,
            );
            $this->db->where('Property_SlNo', $customerObj->property_id)->update('tbl_property', $customer);

            $res = ['success' => true, 'message' => 'Property assign successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }


    public function propertyMeetingReminder()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Property Meeting Reminder";
        $data['content'] = $this->load->view("Administrator/property/meeting_reminder", $data, true);
        $this->load->view("Administrator/index", $data);
    }


    //add meeting
    public function meeting_report()
    {
        // $access = $this->mt->userAccess();
        // if (!$access) {
        //     redirect(base_url());
        // }
        $data['title'] = "Meeting Report List";
        $data['content'] = $this->load->view("Administrator/property/meeting_report", $data, true);
        $this->load->view("Administrator/index", $data);
    }

    public function add_meeting()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $meetingObj = json_decode($this->input->raw_input_stream);

            $meeting = array(
                'user_id'     => $this->session->userdata('userId'),
                'property_id' => $meetingObj->property_id,
                'report_date' => $meetingObj->report_date,
                'note'        => $meetingObj->note,
                'AddBy'       => $this->session->userdata('FullName'),
                'AddTime'     => date("Y-m-d H:i:s"),
                'branchId'    => $this->session->userdata("BRANCHid"),
            );

            $this->db->insert('tbl_property_meeting', $meeting);

            if (!empty($meetingObj->next_meeting_date)) {
                $this->db->set(['next_meeting_date' => $meetingObj->next_meeting_date])->where('Property_SlNo', $meetingObj->property_id)->update('tbl_property');
            } else {
                $this->db->set(['next_meeting_date' => NULL])->where('Property_SlNo', $meetingObj->property_id)->update('tbl_property');
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
        if (isset($data->purposeId) && $data->purposeId != null) {
            $customerTypeClause .= " and pr.purposeId = '$data->purposeId'";
        }

        if (isset($data->dateFrom) && $data->dateFrom != '') {
            $customerTypeClause .= " and rp.report_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $meeting = $this->db->query("
            select
                rp.*,
                u.User_Name,
                pr.Property_Name,
                pr.Property_Code
            from tbl_property_meeting rp
            left join tbl_user u on u.User_SlNo = rp.user_id
            left join tbl_property pr on pr.Property_SlNo = rp.property_id
            where rp.Status != 'd'
            $customerTypeClause
            $order_by
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($meeting);
    }
}
