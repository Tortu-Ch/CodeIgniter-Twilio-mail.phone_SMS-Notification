<?php

class Leads_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'leads';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $leads_table = $this->db->dbprefix('leads');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $leads_table.id=$id";
        }

        $sql = "SELECT $leads_table.*
                FROM $leads_table       
        WHERE $leads_table.deleted=0 $where";
        return $this->db->query($sql);
    }
}
