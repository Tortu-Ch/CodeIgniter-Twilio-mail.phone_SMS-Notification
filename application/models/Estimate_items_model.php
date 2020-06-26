<?php

class Estimate_items_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'estimate_items';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $estimate_items_table = $this->db->dbprefix('estimate_items');
        $estimates_table = $this->db->dbprefix('estimates');
        $clients_table = $this->db->dbprefix('clients');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $estimate_items_table.id=$id";
        }
        $estimate_id = get_array_value($options, "estimate_id");
        if ($estimate_id) {
            $where .= " AND $estimate_items_table.estimate_id=$estimate_id";
        }

        $sql = "SELECT $estimate_items_table.*, (SELECT $clients_table.currency_symbol FROM $clients_table WHERE $clients_table.id=$estimates_table.client_id limit 1) AS currency_symbol
        FROM $estimate_items_table
        LEFT JOIN $estimates_table ON $estimates_table.id=$estimate_items_table.estimate_id
        WHERE $estimate_items_table.deleted=0 $where";
        return $this->db->query($sql);  
    }

}
