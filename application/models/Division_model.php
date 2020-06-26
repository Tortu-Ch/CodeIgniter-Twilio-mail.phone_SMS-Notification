<?php

class Division_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'division_type';
        parent::__construct($this->table);
    }

    function get_division_types_active(){
        $division_type_table = $this->db->dbprefix('division_type');

        $sql = "SELECT $division_type_table.*
        FROM $division_type_table
        WHERE $division_type_table.state=1";
        return $this->db->query($sql);
    }

}
