<?php

class Activity_logs_model extends CI_Model {

    function __construct() {
        
    }

    function save($data) {
        $data["created_at"] = get_current_utc_time();
        $data["created_by"] = $this->login_user->id;
        $this->db->insert("activity_logs", $data);
        return $this->db->insert_id();
    }

    function delete_where($where = array()) {
        if (count($where)) {
            return $this->db->delete("activity_logs", $where);
        }
    }

    function get_details($options = array()) {
        $activity_logs_table = $this->db->dbprefix('activity_logs');
        $project_members_table = $this->db->dbprefix('project_members');

        $users_table = $this->db->dbprefix('users');
        $where = "";
        $limit = get_array_value($options, "limit");
        $limit = $limit ? $limit : "20";
        $offset = get_array_value($options, "offset");
        $offset = $offset ? $offset : "0";

        $extra_join_info = "";
        $extra_select = "";

        $log_for = get_array_value($options, "log_for");
        if ($log_for) {
            $where .= " AND $activity_logs_table.log_for='$log_for'";

            $log_for_id = get_array_value($options, "log_for_id");
            if ($log_for_id) {
                $where .= " AND $activity_logs_table.log_for_id=$log_for_id";
            } else {
                //link with the parent
                if ($log_for === "project") {
                    $link_with_table = $this->db->dbprefix('projects');
                    $extra_join_info = " LEFT JOIN $link_with_table ON $activity_logs_table.log_for_id=$link_with_table.id ";
                    $extra_select = " , $link_with_table.title as log_for_title";
                }
            }
        }

        $log_type = get_array_value($options, "log_type");
        $log_type_id = get_array_value($options, "log_type_id");
        if ($log_type && $log_type_id) {
            $where .= " AND $activity_logs_table.log_type='$log_type' AND $activity_logs_table.log_type_id=$log_type_id";
        }

        //don't show all project's log for none admin users
        $project_join = "";
        $project_where = "";
        $user_id = get_array_value($options, "user_id");
        $is_admin = get_array_value($options, "is_admin");
        if (!$is_admin && $user_id) {
            $project_join = " LEFT JOIN (SELECT $project_members_table.user_id, $project_members_table.project_id FROM $project_members_table WHERE $project_members_table.user_id=$user_id AND $project_members_table.deleted=0 GROUP BY $project_members_table.project_id) AS project_members_table ON project_members_table.project_id= $activity_logs_table.log_for_id AND log_for='project' ";
            $project_where = " AND project_members_table.user_id=$user_id";
        }



        $sql = "SELECT SQL_CALC_FOUND_ROWS $activity_logs_table.*,  CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_user, $users_table.image as created_by_avatar, $users_table.user_type $extra_select
        FROM $activity_logs_table
        LEFT JOIN $users_table ON $users_table.id= $activity_logs_table.created_by
        $extra_join_info
        $project_join
        WHERE $activity_logs_table.deleted=0 $where $project_where
        ORDER BY $activity_logs_table.created_at DESC
        LIMIT $offset, $limit";
        $data = new stdClass();
        $data->result = $this->db->query($sql)->result();
        $data->found_rows = $this->db->query("SELECT FOUND_ROWS() as found_rows")->row()->found_rows;
        return $data;
    }

    function get_one($id = 0) {
        return $this->get_one_where(array('id' => $id));
    }

    function get_one_where($where = array()) {
        $result = $this->db->get_where("activity_logs", $where, 1);
        if ($result->num_rows()) {
            return $result->row();
        } else {
            $db_fields = $this->db->list_fields("activity_logs");
            $fields = new stdClass();
            foreach ($db_fields as $field) {
                $fields->$field = "";
            }
            return $fields;
        }
    }

    function update_where($data = array(), $where = array()) {
        if (count($where)) {
            return $this->db->update("activity_logs", $data, $where);
        }
    }

}
