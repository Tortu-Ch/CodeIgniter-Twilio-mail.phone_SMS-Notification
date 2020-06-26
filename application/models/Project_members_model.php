<?php

class Project_members_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'project_members';
        parent::__construct($this->table);
    }

     function save_member($data = array(), $id = 0) {
        $user_id = get_array_value($data, "user_id");
        $project_id = get_array_value($data, "project_id");
        if (!$user_id || !$project_id) {
            return false;
        }

        $exists = $this->get_one_where($where = array("user_id" => $user_id, "project_id" => $project_id));
        // print_r($exists);
        if ($exists->id && $exists->deleted == 0) {
            //already exists
            return "exists";
        } else if ($exists->id && $exists->deleted == 1) {
            //undelete the record
            if (parent::delete($exists->id, true)) {
                return $exists->id;
            }
        } else {
            //add new
            return parent::save($data, $id);
        }
    }


    function delete($id = 0, $undo = false) {
        return parent::delete($id, $undo);
    }

    function get_details($options = array()) {
        $project_members_table = $this->db->dbprefix('project_members');
        $users_table = $this->db->dbprefix('users');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $project_members_table.id=$id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $project_members_table.project_id=$project_id";
        }

        $sql = "SELECT $project_members_table.*, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS member_name, $users_table.image as member_image, $users_table.job_title
        FROM $project_members_table
        LEFT JOIN $users_table ON $users_table.id= $project_members_table.user_id
        WHERE $project_members_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_project_members_dropdown_list($project_id = 0, $user_ids=array()) {
        $project_members_table = $this->db->dbprefix('project_members');
        $users_table = $this->db->dbprefix('users');

        $where = " AND $project_members_table.project_id=$project_id";
        
        if(is_array($user_ids) && count($user_ids)){
            $users_list = join(",", $user_ids);
            $where.=" AND $users_table.id IN($users_list)";
        }

        $sql = "SELECT $project_members_table.user_id, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS member_name
        FROM $project_members_table
        LEFT JOIN $users_table ON $users_table.id= $project_members_table.user_id
        WHERE $project_members_table.deleted=0 $where 
        GROUP BY $project_members_table.user_id ORDER BY $users_table.first_name ASC";
        return $this->db->query($sql);
    }

    function is_user_a_project_member($project_id = 0, $user_id = 0) {
        $info = $this->get_one_where(array("project_id" => $project_id, "user_id" => $user_id, "deleted" => 0));
        if ($info->id) {
            return true;
        }
    }

    function get_rest_team_members_for_a_project($project_id = 0) {
        $project_members_table = $this->db->dbprefix('project_members');
        $users_table = $this->db->dbprefix('users');

        $sql = "SELECT $users_table.id, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS member_name
        FROM $users_table
        LEFT JOIN $project_members_table ON $project_members_table.user_id=$users_table.id
        WHERE $users_table.user_type='staff' AND $users_table.deleted=0 AND $users_table.id NOT IN (SELECT $project_members_table.user_id FROM $project_members_table WHERE $project_members_table.project_id='$project_id' AND deleted=0)
        ORDER BY $users_table.first_name ASC";

        return $this->db->query($sql);
    }

}
