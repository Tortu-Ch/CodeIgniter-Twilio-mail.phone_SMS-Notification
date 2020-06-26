<?php

class Tickets_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'tickets';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $tickets_table = $this->db->dbprefix('tickets');
        $ticket_types_table = $this->db->dbprefix('ticket_types');
        $clients_table = $this->db->dbprefix('clients');
        $users_table = $this->db->dbprefix('users');
        $project_table = $this->db->dbprefix("projects");

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $tickets_table.id=$id";
        }
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $tickets_table.client_id=$client_id";
        }
        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $project_table.id=$project_id";
        }

        $status = get_array_value($options, "status");
        if ($status === "closed") {
            $where .= " AND $tickets_table.status='$status'";
        } if ($status === "open") {
            $where .= " AND FIND_IN_SET($tickets_table.status, 'new,open,client_replied')";
        }

        $ticket_label = get_array_value($options, "ticket_label");
        if ($ticket_label) {
            $where .= " AND (FIND_IN_SET('$ticket_label', $tickets_table.labels)) ";
        }

        $assigned_to = get_array_value($options, "assigned_to");
        if ($assigned_to) {
            $where .= " AND $tickets_table.assigned_to=$assigned_to";
        }

        $ticket_types = get_array_value($options, "ticket_types");

        if ($ticket_types && count($ticket_types)) {
            $ticket_types = implode($ticket_types, ","); //prepare comma separated value
            $where .= " AND FIND_IN_SET($ticket_types_table.id, '$ticket_types')";
        }


        //prepare custom fild binding query
        $custom_fields = get_array_value($options, "custom_fields");
        $custom_field_query_info = $this->prepare_custom_field_query_string("tickets", $custom_fields, $tickets_table);
        $select_custom_fieds = get_array_value($custom_field_query_info, "select_string");
        $join_custom_fieds = get_array_value($custom_field_query_info, "join_string");



        $sql = "SELECT $tickets_table.*, $ticket_types_table.title AS ticket_type, $clients_table.company_name, $project_table.title AS project_title,
              CONCAT($users_table.first_name, ' ',$users_table.last_name) AS assigned_to_user, $users_table.image as assigned_to_avatar $select_custom_fieds
        FROM $tickets_table
        LEFT JOIN $ticket_types_table ON $ticket_types_table.id= $tickets_table.ticket_type_id
        LEFT JOIN $clients_table ON $clients_table.id= $tickets_table.client_id
        LEFT JOIN $users_table ON $users_table.id= $tickets_table.assigned_to
        LEFT JOIN $project_table ON $project_table.id= $tickets_table.project_id
        $join_custom_fieds    
        WHERE $tickets_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function count_new_tickets($ticket_types = "") {
        $tickets_table = $this->db->dbprefix('tickets');
        $where = "";
        if ($ticket_types) {
            $where = " AND FIND_IN_SET($tickets_table.ticket_type_id, '$ticket_types')";
        }
        $sql = "SELECT COUNT($tickets_table.id) AS total
        FROM $tickets_table
        WHERE $tickets_table.deleted=0  AND $tickets_table.status='new' $where";
        return $this->db->query($sql)->row()->total;
    }

    function get_ticket_status_info() {
        $tickets_table = $this->db->dbprefix('tickets');
        $where = "";

        $sql = "SELECT $tickets_table.status, COUNT($tickets_table.id) as total
        FROM $tickets_table
        WHERE $tickets_table.deleted=0 $where
        GROUP BY $tickets_table.status";
        return $this->db->query($sql);
    }

    function get_label_suggestions() {
        $tickets_table = $this->db->dbprefix('tickets');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $tickets_table
        WHERE $tickets_table.deleted=0";
        return $this->db->query($sql)->row()->label_groups;
    }

    function delete_ticket_and_sub_items($ticket_id) {
        $tickets_table = $this->db->dbprefix('tickets');
        $ticket_comments_table = $this->db->dbprefix('ticket_comments');


        //get ticket comments info to delete the files from directory 
        $ticket_comments_sql = "SELECT * FROM $ticket_comments_table WHERE $ticket_comments_table.deleted=0 AND $ticket_comments_table.ticket_id=$ticket_id; ";
        $ticket_comments = $this->db->query($ticket_comments_sql)->result();

        //delete the ticket and sub items
        $delete_ticket_sql = "UPDATE $tickets_table SET $tickets_table.deleted=1 WHERE $tickets_table.id=$ticket_id; ";
        $this->db->query($delete_ticket_sql);

        $delete_comments_sql = "UPDATE $ticket_comments_table SET $ticket_comments_table.deleted=1 WHERE $ticket_comments_table.ticket_id=$ticket_id; ";
        $this->db->query($delete_comments_sql);


        //delete the files from directory
        $comment_file_path = get_setting("timeline_file_path");

        foreach ($ticket_comments as $comment_info) {
            if ($comment_info->files && $comment_info->files != "a:0:{}") {
                $files = unserialize($comment_info->files);
                foreach ($files as $file) {
                    $source_path = $comment_file_path . get_array_value($file, "file_name");
                    delete_file_from_directory($source_path);
                }
            }
        }

        return true;
    }

    function count_tickets($options = array()) {
        $tickets_table = $this->db->dbprefix('tickets');

        $where = "";

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $tickets_table.client_id=$client_id";
        }

        $allowed_ticket_types = get_array_value($options, "allowed_ticket_types");
        if ($allowed_ticket_types && count($allowed_ticket_types)) {
            $implode_allowed_ticket_types = implode(",", $allowed_ticket_types);
            $where .= " AND FIND_IN_SET($tickets_table.ticket_type_id, '$implode_allowed_ticket_types')";
        }

        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND FIND_IN_SET($tickets_table.status, '$status')";
        }

        $sql = "SELECT COUNT($tickets_table.id) AS total
        FROM $tickets_table
        WHERE $tickets_table.deleted=0 $where";

        return $this->db->query($sql)->row()->total;
    }

}
