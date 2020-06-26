<?php

class Dashboards_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'dashboards';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $dashboard_table = $this->db->dbprefix("dashboards");

        $where = "";

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $dashboard_table.user_id=$user_id";
        }

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $dashboard_table.id= $id";
        }

        $sql = "SELECT $dashboard_table.*, IF($dashboard_table.sort!=0, $dashboard_table.sort, $dashboard_table.id) AS new_sort
        FROM $dashboard_table
        WHERE $dashboard_table.deleted=0 $where
        ORDER BY new_sort DESC";

        return $this->db->query($sql);
    }

}
