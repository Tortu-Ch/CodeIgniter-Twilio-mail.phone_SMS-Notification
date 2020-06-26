<?php

class Todo_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'to_do';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $todo_table = $this->db->dbprefix('to_do');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $todo_table.id=$id";
        }


        $created_by = get_array_value($options, "created_by");
        if ($created_by) {
            $where .= " AND $todo_table.created_by=$created_by";
        }


        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND FIND_IN_SET($todo_table.status,'$status')";
        }


        $sql = "SELECT $todo_table.*
        FROM $todo_table
        WHERE $todo_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_label_suggestions($user_id) {
        $todo_table = $this->db->dbprefix('to_do');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $todo_table
        WHERE $todo_table.deleted=0 AND $todo_table.created_by=$user_id";
        return $this->db->query($sql)->row()->label_groups;
    }

}
