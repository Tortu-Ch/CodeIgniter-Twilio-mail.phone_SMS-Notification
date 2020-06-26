<?php

class Estimate_division_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'estimate_division';
        parent::__construct($this->table);
    }

    function get_estimate_division_active($estimate_id){
        $estimate_division_table = $this->db->dbprefix('estimate_division');

        $sql = "SELECT $estimate_division_table.*
        FROM $estimate_division_table
        WHERE $estimate_division_table.estimate_id=$estimate_id";
        return $this->db->query($sql);
    }

}
