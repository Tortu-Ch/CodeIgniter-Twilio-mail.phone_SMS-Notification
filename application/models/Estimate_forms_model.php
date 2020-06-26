<?php

class Estimate_forms_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'estimate_forms';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $estimate_forms_table = $this->db->dbprefix('estimate_forms');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $estimate_forms_table.id=$id";
        }


        $sql = "SELECT $estimate_forms_table.*
        FROM $estimate_forms_table
        WHERE $estimate_forms_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
