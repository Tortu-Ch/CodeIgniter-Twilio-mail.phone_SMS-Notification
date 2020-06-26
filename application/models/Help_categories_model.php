<?php

class Help_categories_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'help_categories';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $help_categories_table = $this->db->dbprefix('help_categories');
        $help_articles_table = $this->db->dbprefix('help_articles');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $help_categories_table.id=$id";
        }

        $type = get_array_value($options, "type");
        if ($type) {
            $where .= " AND $help_categories_table.type='$type'";
        }

        
        $only_active_categories = get_array_value($options, "only_active_categories");
        if ($only_active_categories) {
            $where .= " AND $help_categories_table.status='active'";
        }

        
        $sql = "SELECT $help_categories_table.*, 
                (SELECT COUNT($help_articles_table.id) AS total_articles FROM $help_articles_table WHERE $help_articles_table.category_id=$help_categories_table.id AND $help_articles_table.deleted=0 AND  $help_articles_table.status='active') AS total_articles
        FROM $help_categories_table
        WHERE $help_categories_table.deleted=0 $where 
        ORDER BY $help_categories_table.sort";
        return $this->db->query($sql);
    }

}
