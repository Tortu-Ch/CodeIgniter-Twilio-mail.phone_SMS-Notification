<?php

class Leave_applications_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'leave_applications';
        parent::__construct($this->table);
    }

    function get_details_info($id = 0) {
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $users_table = $this->db->dbprefix('users');
        $leave_types_table = $this->db->dbprefix('leave_types');

        $sql = "SELECT $leave_applications_table.*, 
                CONCAT(applicant_table.first_name, ' ',applicant_table.last_name) AS applicant_name, applicant_table.image as applicant_avatar, applicant_table.job_title,
                CONCAT(checker_table.first_name, ' ',checker_table.last_name) AS checker_name, checker_table.image as checker_avatar,
                $leave_types_table.title as leave_type_title,   $leave_types_table.color as leave_type_color
            FROM $leave_applications_table
            LEFT JOIN $users_table AS applicant_table ON applicant_table.id= $leave_applications_table.applicant_id
            LEFT JOIN $users_table AS checker_table ON checker_table.id= $leave_applications_table.checked_by
            LEFT JOIN $leave_types_table ON $leave_types_table.id= $leave_applications_table.leave_type_id        
            WHERE $leave_applications_table.deleted=0 AND $leave_applications_table.id=$id";
        return $this->db->query($sql)->row();
    }

    function get_list($options = array()) {
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $users_table = $this->db->dbprefix('users');
        $leave_types_table = $this->db->dbprefix('leave_types');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $leave_applications_table.id=$id";
        }

        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND $leave_applications_table.status='$status'";
        }

        $start_date = get_array_value($options, "start_date");
        $end_date = get_array_value($options, "end_date");
        if ($start_date && $end_date) {
            $where .= " AND ($leave_applications_table.start_date BETWEEN '$start_date' AND '$end_date') ";
        }

        $applicant_id = get_array_value($options, "applicant_id");
        if ($applicant_id) {
            $where .= " AND $leave_applications_table.applicant_id=$applicant_id";
        }

        $access_type = get_array_value($options, "access_type");

        if (!$id && $access_type !== "all") {

            $allowed_members = get_array_value($options, "allowed_members");
            if (is_array($allowed_members) && count($allowed_members)) {
                $allowed_members = join(",", $allowed_members);
            } else {
                $allowed_members = '0';
            }
            $login_user_id = get_array_value($options, "login_user_id");
            if ($login_user_id) {
                $allowed_members .= "," . $login_user_id;
            }
            $where .= " AND $leave_applications_table.applicant_id IN($allowed_members)";
        }


        $sql = "SELECT $leave_applications_table.id, $leave_applications_table.start_date, $leave_applications_table.end_date, $leave_applications_table.total_hours,
                $leave_applications_table.total_days, $leave_applications_table.applicant_id, $leave_applications_table.status,
                CONCAT($users_table.first_name, ' ',$users_table.last_name) AS applicant_name, $users_table.image as applicant_avatar,
                $leave_types_table.title as leave_type_title,   $leave_types_table.color as leave_type_color
            FROM $leave_applications_table
            LEFT JOIN $users_table ON $users_table.id= $leave_applications_table.applicant_id
            LEFT JOIN $leave_types_table ON $leave_types_table.id= $leave_applications_table.leave_type_id        
            WHERE $leave_applications_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_summary($options = array()) {
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $users_table = $this->db->dbprefix('users');
        $leave_types_table = $this->db->dbprefix('leave_types');

        $where = "";

        $where .= " AND $leave_applications_table.status='approved'";


        $start_date = get_array_value($options, "start_date");
        $end_date = get_array_value($options, "end_date");

        if ($start_date && $end_date) {
            $where .= " AND ($leave_applications_table.start_date BETWEEN '$start_date' AND '$end_date') ";
        }

        $applicant_id = get_array_value($options, "applicant_id");
        if ($applicant_id) {
            $where .= " AND $leave_applications_table.applicant_id=$applicant_id";
        }

        $leave_type_id = get_array_value($options, "leave_type_id");
        if ($leave_type_id) {
            $where .= " AND $leave_applications_table.leave_type_id=$leave_type_id";
        }

        $access_type = get_array_value($options, "access_type");

        if ($access_type !== "all") {

            $allowed_members = get_array_value($options, "allowed_members");
            if (is_array($allowed_members) && count($allowed_members)) {
                $allowed_members = join(",", $allowed_members);
            } else {
                $allowed_members = '0';
            }
            $login_user_id = get_array_value($options, "login_user_id");
            if ($login_user_id) {
                $allowed_members .= "," . $login_user_id;
            }
            $where .= " AND $leave_applications_table.applicant_id IN($allowed_members)";
        }


        $sql = "SELECT  SUM($leave_applications_table.total_hours) AS total_hours,
                SUM($leave_applications_table.total_days) AS total_days, MAX($leave_applications_table.applicant_id) AS applicant_id, $leave_applications_table.status,
                CONCAT($users_table.first_name, ' ',$users_table.last_name) AS applicant_name, $users_table.image as applicant_avatar,
                $leave_types_table.title as leave_type_title,   $leave_types_table.color as leave_type_color
            FROM $leave_applications_table
            LEFT JOIN $users_table ON $users_table.id= $leave_applications_table.applicant_id
            LEFT JOIN $leave_types_table ON $leave_types_table.id= $leave_applications_table.leave_type_id        
            WHERE $leave_applications_table.deleted=0 $where
            GROUP BY $leave_applications_table.applicant_id, $leave_applications_table.leave_type_id";
        return $this->db->query($sql);
    }

}
