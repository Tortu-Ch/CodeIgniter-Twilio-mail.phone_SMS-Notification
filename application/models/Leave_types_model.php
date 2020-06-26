<?php

class Leave_types_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'leave_types';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $leave_types_table = $this->db->dbprefix('leave_types');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $leave_types_table.id=$id";
        }

        $sql = "SELECT $leave_types_table.*
        FROM $leave_types_table
        WHERE $leave_types_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
