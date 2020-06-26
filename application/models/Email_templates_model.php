<?php

class Email_templates_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'email_templates';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $email_templates_table = $this->db->dbprefix('email_templates');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $email_templates_table.id=$id";
        }

        $sql = "SELECT $email_templates_table.*
        FROM $email_templates_table
        WHERE $email_templates_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_final_template($template_name = "") {
        $email_templates_table = $this->db->dbprefix('email_templates');
        $sql = "SELECT $email_templates_table.default_message, $email_templates_table.custom_message, $email_templates_table.email_subject, 
            signature_template.custom_message AS signature_custom_message, signature_template.default_message AS signature_default_message
        FROM $email_templates_table
        LEFT JOIN $email_templates_table AS signature_template ON signature_template.template_name='signature'
        WHERE $email_templates_table.deleted=0 AND $email_templates_table.template_name='$template_name'";
        $result = $this->db->query($sql)->row();

        $info = new stdClass();
        $info->subject = $result->email_subject;
        $info->message = $result->custom_message ? $result->custom_message : $result->default_message;
        $info->signature = $result->signature_custom_message ? $result->signature_custom_message : $result->signature_default_message;

        return $info;
    }

}
