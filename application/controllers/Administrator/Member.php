<?php
class Member extends CI_Controller
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
        $data['title'] = "Member Entry";
        $data['content'] = $this->load->view('Administrator/common/member', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getMember()
    {
        $member = $this->db->query("select * from tbl_family_member where Status = 'a'")->result();
        echo json_encode($member);
    }

    public function addMember()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_family_member where Status = 'a' and Member_Name = ?", $data->Member_Name)->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Member name already exists"];
            } else {
                $member = array(
                    'Member_Name' => $data->Member_Name,
                    'Status' => 'a',
                    'AddBy' => $this->session->userdata("FullName"),
                    'AddTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->insert("tbl_family_member", $member);
                $res = ['status' => true, 'message' => 'Member added successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function updateMember()
    {
        $data = json_decode($this->input->raw_input_stream);

        $res = ['status' => false, 'message' => ''];
        try {
            $check = $this->db->query("select * from tbl_family_member where Member_SlNo != ? and Status = 'a' and Member_Name = ?", [$data->Member_SlNo, $data->Member_Name])->row();
            if (!empty($check)) {
                $res = ['status' => false, 'message' => "Member name already exists"];
            } else {
                $member = array(
                    'Member_Name' => $data->Member_Name,
                    'UpdateBy' => $this->session->userdata("FullName"),
                    'UpdateTime' => date("Y-m-d H:i:s"),
                    'branchId' => $this->branchId
                );
                $this->db->where("Member_SlNo", $data->Member_SlNo);
                $this->db->update("tbl_family_member", $member);
                $res = ['status' => true, 'message' => 'Member update successfully'];
            }
        } catch (\Throwable $th) {
            $res = ['status' => false, 'message' => $th->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteMember()
    {
        $data = json_decode($this->input->raw_input_stream);

        $member = array(
            'Status' => 'd',
            'UpdateBy' => $this->session->userdata("FullName"),
            'UpdateTime' => date("Y-m-d H:i:s")
        );

        $this->db->where("Member_SlNo", $data->memberId);
        $this->db->update("tbl_family_member", $member);
        $res = ['status' => true, 'message' => 'Member delete successfully'];
        echo json_encode($res);
    }
}
