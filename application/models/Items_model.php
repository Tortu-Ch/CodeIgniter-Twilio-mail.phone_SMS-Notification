<?php

class Items_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'items';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $items_table = $this->db->dbprefix('items');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $items_table.id=$id";
        }

        $sql = "SELECT $items_table.*
        FROM $items_table
        WHERE $items_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
