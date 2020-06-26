<?php

class Invoice_items_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'invoice_items';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $invoice_items_table = $this->db->dbprefix('invoice_items');
        $invoices_table = $this->db->dbprefix('invoices');
        $clients_table = $this->db->dbprefix('clients');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $invoice_items_table.id=$id";
        }
        $invoice_id = get_array_value($options, "invoice_id");
        if ($invoice_id) {
            $where .= " AND $invoice_items_table.invoice_id=$invoice_id";
        }

      /*  $sql = "SELECT $invoice_items_table.*, (SELECT $clients_table.currency_symbol FROM $clients_table WHERE $clients_table.id=$invoices_table.client_id limit 1) AS currency_symbol
        FROM $invoice_items_table
        LEFT JOIN $invoices_table ON $invoices_table.id=$invoice_items_table.invoice_id
        WHERE $invoice_items_table.deleted=0 $where
        ORDER BY $invoice_items_table.sort ASC"; */
		
		$sql = "SELECT w.* FROM (SELECT $invoice_items_table.*, (SELECT $clients_table.currency_symbol FROM $clients_table WHERE $clients_table.id=$invoices_table.client_id limit 1) AS currency_symbol
        FROM $invoice_items_table
        LEFT JOIN $invoices_table ON $invoices_table.id=$invoice_items_table.invoice_id
        WHERE $invoice_items_table.deleted=0 $where ) w 
		UNION (
		SELECT b.id,b.title,b.description,('1')quantity,('')unit_type,(b.price)rate,(1*b.price)total,(0)sort,($invoice_id)invoice_id,b.deleted, ('')currency_symbol FROM `invoices` a 
		LEFT JOIN projects b ON (a.project_id=b.id) WHERE a.id=$invoice_id
		)UNION (
		SELECT b.id,b.title,b.description,('1')quantity,('')unit_type,(0)rate,(0)total,b.sort,($invoice_id)invoice_id,b.deleted, ('')currency_symbol FROM `invoices` a 
		LEFT JOIN tasks b ON (a.project_id=b.project_id) WHERE a.id=$invoice_id
		)";
        return $this->db->query($sql);
    }

    function get_item_suggestion($keyword = "") {
        $items_table = $this->db->dbprefix('items');
        

        $sql = "SELECT $items_table.title
        FROM $items_table
        WHERE $items_table.deleted=0  AND $items_table.title LIKE '%$keyword%'
        LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

    function get_item_info_suggestion($item_name = "") {

        $items_table = $this->db->dbprefix('items');
        

        $sql = "SELECT $items_table.*
        FROM $items_table
        WHERE $items_table.deleted=0  AND $items_table.title LIKE '%$item_name%'
        ORDER BY id DESC LIMIT 1
        ";
        
        $result = $this->db->query($sql); 

        if ($result->num_rows()) {
            return $result->row();
        }

    }

}
