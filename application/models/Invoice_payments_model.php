<?php

class Invoice_payments_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'invoice_payments';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $invoices_table = $this->db->dbprefix('invoices');
        $payment_methods_table = $this->db->dbprefix('payment_methods');
        $clients_table = $this->db->dbprefix('clients');

        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $invoice_payments_table.id=$id";
        }

        $invoice_id = get_array_value($options, "invoice_id");
        if ($invoice_id) {
            $where .= " AND $invoice_payments_table.invoice_id=$invoice_id";
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $invoices_table.client_id=$client_id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $invoices_table.project_id=$project_id";
        }

        $payment_method_id = get_array_value($options, "payment_method_id");
        if ($payment_method_id) {
            $where .= " AND $invoice_payments_table.payment_method_id=$payment_method_id";
        }

        $start_date = get_array_value($options, "start_date");
        $end_date = get_array_value($options, "end_date");
        if ($start_date && $end_date) {
            $where .= " AND ($invoice_payments_table.payment_date BETWEEN '$start_date' AND '$end_date') ";
        }

        $sql = "SELECT $invoice_payments_table.*, $invoices_table.client_id, (SELECT $clients_table.currency_symbol FROM $clients_table WHERE $clients_table.id=$invoices_table.client_id limit 1) AS currency_symbol, $payment_methods_table.title AS payment_method_title
        FROM $invoice_payments_table
        LEFT JOIN $invoices_table ON $invoices_table.id=$invoice_payments_table.invoice_id
        LEFT JOIN $payment_methods_table ON $payment_methods_table.id = $invoice_payments_table.payment_method_id
        WHERE $invoice_payments_table.deleted=0 AND $invoices_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_yearly_payments_chart($year) {
        $payments_table = $this->db->dbprefix('invoice_payments');
        $invoices_table = $this->db->dbprefix('invoices');
         
        $payments = "SELECT SUM($payments_table.amount) AS total, MONTH($payments_table.payment_date) AS month
            FROM $payments_table
            LEFT JOIN $invoices_table ON $invoices_table.id=$payments_table.invoice_id
            WHERE $payments_table.deleted=0 AND YEAR($payments_table.payment_date)= $year AND $invoices_table.deleted=0
            GROUP BY MONTH($payments_table.payment_date)";
        return $this->db->query($payments)->result();
    }

}
