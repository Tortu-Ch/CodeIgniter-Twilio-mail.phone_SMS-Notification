<?php

class Project_files_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'project_files';
        parent::__construct($this->table);
        parent::init_activity_log("project_file", "file_name", "project", "project_id");
    }

    function schema() {
        return array(
            "id" => array(
                "label" => lang("id"),
                "type" => "int"
            ),
            "file_name" => array(
                "label" => lang("file_name"),
                "type" => "text"
            ),
            "project_id" => array(
                "label" => lang("project"),
                "type" => "foreign_key",
                "linked_model" => $this->Projects_model,
                "label_fields" => array("title"),
            ),
            "start_date" => array(
                "label" => lang("start_date"),
                "type" => "date"
            ),
            "end_date" => array(
                "label" => lang("end_date"),
                "type" => "date"
            ),
            "deleted" => array(
                "label" => lang("deleted"),
                "type" => "int"
            )
        );
    }

    function get_details($options = array()) {
        $project_files_table = $this->db->dbprefix('project_files');
        $users_table = $this->db->dbprefix('users');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $project_files_table.id=$id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where = " AND $project_files_table.project_id=$project_id";
        }

        $sql = "SELECT $project_files_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS uploaded_by_user_name, $users_table.image AS uploaded_by_user_image, $users_table.user_type AS uploaded_by_user_type
        FROM $project_files_table
        LEFT JOIN $users_table ON $users_table.id= $project_files_table.uploaded_by
        WHERE $project_files_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_files($ids = array()) {
        $string_of_ids = implode(",", $ids);
                   
        $project_files_table = $this->db->dbprefix("project_files");
        $sql = "SELECT * FROM $project_files_table WHERE deleted=0 AND FIND_IN_SET($project_files_table.id, '$string_of_ids')";
        if($this->db->query($sql)->num_rows() > 0){
            return $this->db->query($sql);
        }
    }

}
