<?php

class Client_groups_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'client_groups';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $client_groups_table = $this->db->dbprefix('client_groups');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $client_groups_table.id=$id";
        }

        $sql = "SELECT $client_groups_table.*
        FROM $client_groups_table
        WHERE $client_groups_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
