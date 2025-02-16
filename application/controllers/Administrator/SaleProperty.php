<?php
class SaleProperty extends CI_Controller
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

        $data['title'] = "Sale Property Entry";
        $data['propertyId'] = 0;
        $data['propertyCode'] = $this->mt->generatesalePropertyCode();
        $data['content'] = $this->load->view('Administrator/property/sale_property', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function editProperty($id)
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Sale Property Edit";
        $data['propertyId'] = $id;
        $data['propertyCode'] = $this->mt->generatePropertyCode();
        $data['content'] = $this->load->view('Administrator/property/sale_property', $data, TRUE);
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
            $clauses .= " and pr.floor_id = '$data->floorId'";
        }
        if (isset($data->categoryId) && $data->categoryId != '') {
            $clauses .= " and pr.category_id = '$data->categoryId'";
        }

        if ($this->session->userdata('accountType') == 'u') {
            if (isset($data->user_id) && $data->user_id != '') {
                $clauses .= " and pr.user_id = '$data->user_id'";
            }
        } else {
            if (isset($data->user_id) && $data->user_id != '') {
                $clauses .= " and pr.user_id = '$data->user_id'";
            }
        }

        $property = $this->db->query("
                    select pr.*,
                    u.User_Name,
                    pc.Category_Name,
                    z.Zone_Name,
                    sq.Sqft_Name,
                    f.Floor_Name,
                    g.Gas_Name,
                    b.Bed_Name,
                    sb.Sbed_Name,
                    bt.Bath_Name,
                    sbt.Sbath_Name,
                    gn.Generator_Name,
                    dr.Drawing_Name,
                    bl.Balcony_Name,
                    apf.Face_Name,
                    apt.Type_Name

                    from tbl_sale_property pr
                    left join tbl_property_category pc on pc.Category_SlNo = pr.category_id
                    left join tbl_zone z on z.Zone_SlNo = pr.zone_id
                    left join tbl_sqft sq on sq.Sqft_SlNo = pr.sqft_id
                    left join tbl_floor f on f.Floor_SlNo = pr.floor_id
                    left join tbl_gas g on g.Gas_SlNo = pr.gas_id
                    left join tbl_bed b on b.Bed_SlNo = pr.bed_id
                    left join tbl_servant_bed sb on sb.Sbed_SlNo = pr.sbed_id
                    left join tbl_lift l on l.Lift_SlNo = pr.lift_id
                    left join tbl_bath bt on bt.Bath_SlNo = pr.bath_id
                    left join tbl_servant_bath sbt on sbt.Sbath_SlNo = pr.sbath_id
                    left join tbl_generator gn on gn.Generator_SlNo = pr.generator_id
                    left join tbl_drawing dr on dr.Drawing_SlNo = pr.drawing_id
                    left join tbl_balcony bl on bl.Balcony_SlNo = pr.balcony_id
                    left join tbl_apt_face apf on apf.Face_SlNo = pr.face_id
                    left join tbl_apt_type apt on apt.Type_SlNo = pr.type_id
                    left join tbl_user u on u.User_SlNo = pr.user_id
                    where pr.Status != 'd'
                    $clauses
                    order by pr.Property_SlNo desc")->result();

        echo json_encode($property);
    }

    public function addProperty()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $propertyObj = json_decode($this->input->post('data'));
            $validations = array(
                'category_id',
                'house_no',
                'road_no',
                'developer_name',
                'land_size',
                'building_height',
                'address',
                'unit',
                'parking',
                'zone_id',
                'sqft_id',
                'floor_id',
                'gas_id',
                'bed_id',
                'sbed_id',
                'lift_id',
                'generator_id',
                'bath_id',
                'sbath_id',
                'drawing_id',
                'face_id',
                'handover',
                'total_unit',
                'type_id',
            );

            unset($propertyObj->Property_SlNo);
            foreach ($propertyObj as $key => $val) {
                $emptyVal = $val;
                if (in_array($key, $validations) && $emptyVal == '') {
                    $keyVal = strtoupper($key);
                    $res = ['success' => false, 'message' => "{$keyVal} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $propertyCodeCount = $this->db->query("select * from tbl_sale_property where Property_Code = ?", $propertyObj->Property_Code)->num_rows();
            if ($propertyCodeCount > 0) {
                $propertyObj->Property_Code = $this->mt->generatePropertyCode();
            }

            $property = (array)$propertyObj;
            $property['Status'] = 'p';
            $property['AddBy'] = $this->session->userdata("FullName");
            $property['AddTime'] = date('Y-m-d H:i:s');
            $property['branchId'] = $this->branchId;

            $this->db->insert('tbl_sale_property', $property);

            $res = ['success' => true, 'message' => 'Sale Property added successfully', 'propertyCode' => $this->mt->generatePropertyCode()];
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
            $propertyId = $propertyObj->Property_SlNo;
            $validations = array(
                'category_id',
                'house_no',
                'road_no',
                'developer_name',
                'land_size',
                'building_height',
                'address',
                'unit',
                'parking',
                'zone_id',
                'sqft_id',
                'floor_id',
                'gas_id',
                'bed_id',
                'sbed_id',
                'lift_id',
                'generator_id',
                'bath_id',
                'sbath_id',
                'drawing_id',
                'face_id',
                'handover',
                'total_unit',
                'type_id',
            );

            unset($propertyObj->Property_SlNo);
            foreach ($propertyObj as $key => $val) {
                $emptyVal = $val;
                if (in_array($key, $validations) && $emptyVal == '') {
                    $keyVal = strtoupper($key);
                    $res = ['success' => false, 'message' => "{$keyVal} field is required"];
                    echo json_encode($res);
                    exit;
                }
            }

            $propertyCodeCount = $this->db->query("select * from tbl_sale_property where Property_Code = ? and Property_SlNo != ?", [$propertyObj->Property_Code, $propertyId])->num_rows();
            if ($propertyCodeCount > 0) {
                $res = ['success' => false, 'message' => 'Property code already exists'];
                echo json_encode($res);
                exit;
            }

            $property = (array)$propertyObj;
            $property['UpdateBy'] = $this->session->userdata("FullName");
            $property['UpdateTime'] = date('Y-m-d H:i:s');
            $property['branchId'] = $this->branchId;

            $this->db->where('Property_SlNo', $propertyId);
            $this->db->update('tbl_sale_property', $property);

            $res = ['success' => true, 'message' => 'Sale Property update successfully', 'propertyCode' => $this->mt->generatePropertyCode()];
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

            $this->db->set(['Status' => 'd'])->where('Property_SlNo', $data->propertyId)->update('tbl_sale_property');

            $res = ['success' => true, 'message' => 'Sale Property deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function propertyList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Sale Property List";
        $data['content'] = $this->load->view('Administrator/property/salepropertyList', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
}
