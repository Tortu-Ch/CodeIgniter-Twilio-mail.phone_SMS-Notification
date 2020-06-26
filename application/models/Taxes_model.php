<?php

class Taxes_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'taxes';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $taxes_table = $this->db->dbprefix('taxes');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $taxes_table.id=$id";
        }

        $sql = "SELECT $taxes_table.*
        FROM $taxes_table
        WHERE $taxes_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
