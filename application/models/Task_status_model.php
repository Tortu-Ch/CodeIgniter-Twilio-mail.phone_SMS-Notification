<?php

class Task_status_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'task_status';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $task_status_table = $this->db->dbprefix('task_status');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $task_status_table.id=$id";
        }

        $sql = "SELECT $task_status_table.*
        FROM $task_status_table
        WHERE $task_status_table.deleted=0 $where
        ORDER BY $task_status_table.sort ASC";
        return $this->db->query($sql);
    }

    function get_max_sort_value() {
        $task_status_table = $this->db->dbprefix('task_status');

        $sql = "SELECT MAX($task_status_table.sort) as sort
        FROM $task_status_table
        WHERE $task_status_table.deleted=0";
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->row()->sort;
        } else {
            return 0;
        }
    }

}
