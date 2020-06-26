<?php

class Social_links_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'social_links';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $social_links_table = $this->db->dbprefix('social_links');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $social_links_table.id=$id";
        }

        $sql = "SELECT $social_links_table.*
        FROM $social_links_table
        WHERE $social_links_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
