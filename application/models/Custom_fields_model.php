<?php

class Custom_fields_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'custom_fields';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $custom_fields_table = $this->db->dbprefix('custom_fields');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $custom_fields_table.id=$id";
        }


        $related_to = get_array_value($options, "related_to");
        if ($related_to) {
            $where .= " AND $custom_fields_table.related_to='$related_to'";
        }

        $show_in_table = get_array_value($options, "show_in_table");
        if ($show_in_table) {
            $where .= " AND $custom_fields_table.show_in_table=1";
        }

        $show_in_invoice = get_array_value($options, "show_in_invoice");
        if ($show_in_invoice) {
            $where .= " AND $custom_fields_table.show_in_invoice=1";
        }

        $show_in_estimate = get_array_value($options, "show_in_estimate");
        if ($show_in_estimate) {
            $where .= " AND $custom_fields_table.show_in_estimate=1";
        }

        $sql = "SELECT $custom_fields_table.*
        FROM $custom_fields_table
        WHERE $custom_fields_table.deleted=0 $where 
        ORDER by $custom_fields_table.sort ASC";
        return $this->db->query($sql);
    }

    function get_max_sort_value($related_to = "") {
        $custom_fields_table = $this->db->dbprefix('custom_fields');

        $sql = "SELECT MAX($custom_fields_table.sort) as sort
        FROM $custom_fields_table
        WHERE $custom_fields_table.deleted=0 AND $custom_fields_table.related_to='$related_to'";
        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->row()->sort;
        } else {
            return 0;
        }
    }

    function get_combined_details($related_to, $related_to_id = 0, $is_admin = 0, $user_type = "") {
        $custom_fields_table = $this->db->dbprefix('custom_fields');
        $custom_field_values_table = $this->db->dbprefix('custom_field_values');


        $where = "";

        //check visibility permission for non-admin users
        if (!$is_admin) {
            $where .= " AND $custom_fields_table.visible_to_admins_only=0";
        }


        //check visibility permission for clients
        if ($user_type === "client") {
            $where .= " AND $custom_fields_table.hide_from_clients=0";
        }


        if (!$related_to_id) {
            $related_to_id = 0;
        }


        $sql = "SELECT $custom_fields_table.*,
                $custom_field_values_table.id AS custom_field_values_id, $custom_field_values_table.value
        FROM $custom_fields_table
        LEFT JOIN $custom_field_values_table ON $custom_fields_table.id= $custom_field_values_table.custom_field_id AND $custom_field_values_table.deleted=0 AND $custom_field_values_table.related_to_id = $related_to_id
        WHERE $custom_fields_table.deleted=0 AND $custom_fields_table.related_to = '$related_to' $where
        ORDER by $custom_fields_table.sort ASC";
        return $this->db->query($sql);
    }

    function get_custom_field_headers_for_table($related_to, $is_admin = 0, $user_type = "") {
        $custom_fields_for_table = $this->get_available_fields_for_table($related_to, $is_admin, $user_type);

        $json_string = "";
        foreach ($custom_fields_for_table as $column) {
            $json_string .= ',' . '{"title":"' . $column->title . '"}';
        }

        return $json_string;
    }

    function get_available_fields_for_table($related_to, $is_admin = 0, $user_type = "") {
        $custom_fields_table = $this->db->dbprefix('custom_fields');

        $where = "";

        //check visibility permission for non-admin users
        if (!$is_admin) {
            $where .= " AND $custom_fields_table.visible_to_admins_only=0";
        }


        //check visibility permission for clients
        if ($user_type === "client") {
            $where .= " AND $custom_fields_table.hide_from_clients=0";
        }


        $sql = "SELECT id, title, field_type
                FROM $custom_fields_table
                WHERE $custom_fields_table.related_to='$related_to' AND $custom_fields_table.show_in_table=1 AND $custom_fields_table.deleted=0 $where    
                ORDER BY $custom_fields_table.sort ASC";

        return $this->db->query($sql)->result();
    }

}
