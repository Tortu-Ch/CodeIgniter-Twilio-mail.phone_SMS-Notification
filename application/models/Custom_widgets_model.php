<?php

class Custom_widgets_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'custom_widgets';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $custom_widgets_table = $this->db->dbprefix("custom_widgets");

        $where = "";

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $custom_widgets_table.user_id=$user_id";
        }

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $custom_widgets_table.id= $id";
        }

        $sql = "SELECT $custom_widgets_table.*
        FROM $custom_widgets_table
        WHERE $custom_widgets_table.deleted=0 $where
        ORDER BY $custom_widgets_table.title ASC";

        return $this->db->query($sql);
    }

}
