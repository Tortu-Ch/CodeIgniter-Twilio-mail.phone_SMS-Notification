<?php

class Roles_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'roles';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $roles_table = $this->db->dbprefix('roles');
        
        $where= "";
        $id=get_array_value($options, "id");
        if($id){
            $where =" AND $roles_table.id=$id";
        }
        
        $sql = "SELECT $roles_table.*
        FROM $roles_table
        WHERE $roles_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
