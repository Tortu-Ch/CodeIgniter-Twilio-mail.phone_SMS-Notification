<?php

class Attendance_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'attendance';
        parent::__construct($this->table);
    }

    function current_clock_in_record($user_id) {
        $attendnace_table = $this->db->dbprefix('attendance');
        $sql = "SELECT $attendnace_table.*
        FROM $attendnace_table
        WHERE $attendnace_table.deleted=0 AND $attendnace_table.user_id=$user_id AND $attendnace_table.status='incomplete'";
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->row();
        } else {
            return false;
        }
    }

    function log_time($user_id, $note = "") {

        $current_clock_record = $this->current_clock_in_record($user_id);

        $now = get_current_utc_time();

        if ($current_clock_record && $current_clock_record->id) {
            $data = array(
                "out_time" => $now,
                "status" => "pending",
                "note" => $note
            );
            return $this->save($data, $current_clock_record->id);
        } else {
            $data = array(
                "in_time" => $now,
                "status" => "incomplete",
                "user_id" => $user_id
            );
            return $this->save($data);
        }
    }

    function get_details($options = array()) {
        $attendnace_table = $this->db->dbprefix('attendance');
        $users_table = $this->db->dbprefix('users');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $attendnace_table.id=$id";
        }
        $offset = convert_seconds_to_time_format(get_timezone_offset());

        $start_date = get_array_value($options, "start_date");
        if ($start_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))>='$start_date'";
        }
        $end_date = get_array_value($options, "end_date");
        if ($end_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))<='$end_date'";
        }

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $attendnace_table.user_id=$user_id";
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
            $where .= " AND $attendnace_table.user_id IN($allowed_members)";
        }

        $only_clocked_in_members = get_array_value($options, "only_clocked_in_members");
        if ($only_clocked_in_members) {
            $where .= " AND $attendnace_table.status = 'incomplete'";
        }

        $sql = "SELECT $attendnace_table.*,  CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_user, $users_table.image as created_by_avatar, $users_table.id as user_id, $users_table.job_title as user_job_title
        FROM $attendnace_table
        LEFT JOIN $users_table ON $users_table.id = $attendnace_table.user_id
        WHERE $attendnace_table.deleted=0 $where
        ORDER BY $attendnace_table.in_time DESC";
        return $this->db->query($sql);
    }

    function get_summary_details($options = array()) {
        $attendnace_table = $this->db->dbprefix('attendance');
        $users_table = $this->db->dbprefix('users');

        $where = "";
        $offset = convert_seconds_to_time_format(get_timezone_offset());

        $start_date = get_array_value($options, "start_date");
        if ($start_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))>='$start_date'";
        }
        $end_date = get_array_value($options, "end_date");
        if ($end_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))<='$end_date'";
        }

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $attendnace_table.user_id=$user_id";
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
            $where .= " AND $attendnace_table.user_id IN($allowed_members)";
        }



        //we'll show the details deport in summary_detials view         
        $extra_inner_select = "";
        $extra_group_by = "";
        $extra_select = "";
        $sort_by = "";
        if (get_array_value($options, "summary_details")) {
            $extra_select = ", start_date ";
            $extra_inner_select = ", MAX(DATE(ADDTIME($attendnace_table.in_time,'$offset'))) AS start_date ";
            $extra_group_by = ", DATE(ADDTIME($attendnace_table.in_time,'$offset')) ";
            $sort_by = "ORDER BY user_id, start_date ASC"; //order by must be with user_id 
        }


        $sql = "SELECT user_id, total_duration, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_user, $users_table.image as created_by_avatar $extra_select
                 FROM (SELECT $attendnace_table.user_id, SUM(TIMESTAMPDIFF(SECOND, $attendnace_table.in_time, $attendnace_table.out_time)) AS total_duration $extra_inner_select
                    FROM $attendnace_table
                    WHERE $attendnace_table.deleted=0 $where 
                    GROUP BY $attendnace_table.user_id $extra_group_by) AS new_summary_table 
                LEFT JOIN $users_table ON $users_table.id = new_summary_table.user_id
                $sort_by    
               ";

        return $this->db->query($sql);
    }

    function count_clock_status() {
        $attendnace_table = $this->db->dbprefix('attendance');
        $users_table = $this->db->dbprefix('users');

        $clocked_in = "SELECT $attendnace_table.user_id
        FROM $attendnace_table
        WHERE $attendnace_table.deleted=0 AND $attendnace_table.status='incomplete'
        GROUP BY $attendnace_table.user_id";
        $clocked_in_result = $this->db->query($clocked_in);

        $total_members = "SELECT COUNT(id) AS total_members
        FROM $users_table
        WHERE $users_table.deleted=0 AND $users_table.user_type='staff' AND $users_table.status='active'";
        $total_members_result = $this->db->query($total_members)->row()->total_members;


        $info = new stdClass();
        $info->members_clocked_in = $clocked_in_result->num_rows();
        $info->total_members = $total_members_result ? $total_members_result : 0;
        $info->members_clocked_out = $total_members_result - $info->members_clocked_in;

        return $info;
    }

    function get_timecard_statistics($options = array()) {
        $attendnace_table = $this->db->dbprefix('attendance');

        $where = "";
        $offset = convert_seconds_to_time_format(get_timezone_offset());

        $start_date = get_array_value($options, "start_date");
        if ($start_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))>='$start_date'";
        }
        $end_date = get_array_value($options, "end_date");
        if ($end_date) {
            $where .= " AND DATE(ADDTIME($attendnace_table.in_time,'$offset'))<='$end_date'";
        }

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $attendnace_table.user_id=$user_id";
        }

        $sql = "SELECT DATE_FORMAT($attendnace_table.in_time,'%d') AS day, SUM(TIME_TO_SEC(TIMEDIFF($attendnace_table.out_time,$attendnace_table.in_time))) total_sec
                FROM $attendnace_table 
                WHERE $attendnace_table.deleted=0 AND $attendnace_table.status!='incomplete' $where
                GROUP BY DATE($attendnace_table.in_time)";
        return $this->db->query($sql);
    }

    function count_total_time($options = array()) {
        $attendnace_table = $this->db->dbprefix('attendance');
        $timesheet_table = $this->db->dbprefix('project_time');

        $attendance_where = "";
        $timesheet_where = "";

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $attendance_where .= " AND $attendnace_table.user_id=$user_id";
            $timesheet_where .= " AND $timesheet_table.user_id=$user_id";
        }

        $info = new stdClass();

        $attendance_sql = "SELECT  SUM(TIME_TO_SEC(TIMEDIFF($attendnace_table.out_time,$attendnace_table.in_time))) total_sec
                FROM $attendnace_table 
                WHERE $attendnace_table.deleted=0 AND $attendnace_table.status!='incomplete' $attendance_where";
        $info->timecard_total = $this->db->query($attendance_sql)->row()->total_sec;

        $timesheet_sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF($timesheet_table.end_time,$timesheet_table.start_time))) total_sec
                FROM $timesheet_table 
                WHERE $timesheet_table.deleted=0 AND $timesheet_table.status='logged' $timesheet_where";

        $info->timesheet_total = $this->db->query($timesheet_sql)->row()->total_sec;

        return $info;
    }

    function get_clocked_out_members($options = array()) {
        $attendnace_table = $this->db->dbprefix('attendance');
        $users_table = $this->db->dbprefix('users');

        $where = "";
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
            $where .= " AND $users_table.id IN ($allowed_members)";
        }

        $sql = "SELECT CONCAT($users_table.first_name, ' ',$users_table.last_name) AS member_name, $users_table.last_online, $users_table.image, $users_table.id, $users_table.job_title
        FROM $users_table
        WHERE $users_table.deleted=0 AND $users_table.status='active' AND $users_table.user_type='staff' AND $users_table.id NOT IN (SELECT user_id from $attendnace_table WHERE $attendnace_table.deleted=0 AND $attendnace_table.status='incomplete') $where
        ORDER BY $users_table.first_name DESC";
        return $this->db->query($sql);
    }

}
