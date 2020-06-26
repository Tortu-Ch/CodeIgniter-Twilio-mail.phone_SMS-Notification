<?php

class Estimate_requests_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'estimate_requests';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $estimate_requests_table = $this->db->dbprefix('estimate_requests');
        $estimate_forms_table = $this->db->dbprefix('estimate_forms');
        $clients_table = $this->db->dbprefix('clients');
        $leads_table = $this->db->dbprefix('leads');
        $users_table = $this->db->dbprefix('users');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $estimate_requests_table.id=$id";
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $estimate_requests_table.client_id=$client_id";
        }
        
        $lead_id = get_array_value($options, "lead_id");
        if ($lead_id) {
            $where .= " AND $estimate_requests_table.lead_id=$lead_id";
        }

        $assigned_to = get_array_value($options, "assigned_to");
        if ($assigned_to) {
            $where .= " AND $estimate_requests_table.assigned_to=$assigned_to";
        }

        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND $estimate_requests_table.status='$status'";
        }

        $sql = "SELECT $estimate_requests_table.*, $clients_table.company_name, $estimate_forms_table.title AS form_title, $leads_table.company_name AS lead_company_name, 
              CONCAT($users_table.first_name, ' ',$users_table.last_name) AS assigned_to_user, $users_table.image as assigned_to_avatar 
        FROM $estimate_requests_table
        LEFT JOIN $clients_table ON $clients_table.id = $estimate_requests_table.client_id
        LEFT JOIN $leads_table ON $leads_table.id = $estimate_requests_table.lead_id    
        LEFT JOIN $users_table ON $users_table.id = $estimate_requests_table.assigned_to
        LEFT JOIN $estimate_forms_table ON $estimate_forms_table.id = $estimate_requests_table.estimate_form_id
        WHERE $estimate_requests_table.deleted=0 $where";

        return $this->db->query($sql);
    }

}
