<?php

class Invoices_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'invoices';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $invoices_table = $this->db->dbprefix('invoices');
        $clients_table = $this->db->dbprefix('clients');
        $projects_table = $this->db->dbprefix('projects');
        $taxes_table = $this->db->dbprefix('taxes');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $invoice_items_table = $this->db->dbprefix('invoice_items');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $invoices_table.id=$id";
        }
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $invoices_table.client_id=$client_id";
        }

        $exclude_draft = get_array_value($options, "exclude_draft");
        if ($exclude_draft) {
            $where .= " AND $invoices_table.status!='draft' ";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $invoices_table.project_id=$project_id";
        }

        $start_date = get_array_value($options, "start_date");
        $end_date = get_array_value($options, "end_date");
        if ($start_date && $end_date) {
            $where .= " AND ($invoices_table.due_date BETWEEN '$start_date' AND '$end_date') ";
        }

        $next_recurring_start_date = get_array_value($options, "next_recurring_start_date");
        $next_recurring_end_date = get_array_value($options, "next_recurring_end_date");
        if ($next_recurring_start_date && $next_recurring_start_date) {
            $where .= " AND ($invoices_table.next_recurring_date BETWEEN '$next_recurring_start_date' AND '$next_recurring_end_date') ";
        } else if ($next_recurring_start_date) {
            $where .= " AND $invoices_table.next_recurring_date >= '$next_recurring_start_date' ";
        } else if ($next_recurring_end_date) {
            $where .= " AND $invoices_table.next_recurring_date <= '$next_recurring_end_date' ";
        }

        $recurring_invoice_id = get_array_value($options, "recurring_invoice_id");
        if ($recurring_invoice_id) {
            $where .= " AND $invoices_table.recurring_invoice_id=$recurring_invoice_id";
        }

        $now = get_my_local_time("Y-m-d");
        //  $options['status'] = "draft";
        $status = get_array_value($options, "status");

        
        $invoice_value_calculation_query = $this->_get_invoice_value_calculation_query($invoices_table);
        

        $invoice_value_calculation = "TRUNCATE($invoice_value_calculation_query,2)";

        if ($status === "draft") {
            $where .= " AND $invoices_table.status='draft' AND IFNULL(payments_table.payment_received,0)<=0";
        } else if ($status === "not_paid") {
            $where .= " AND $invoices_table.status !='draft' AND IFNULL(payments_table.payment_received,0)<=0";
        } else if ($status === "partially_paid") {
            $where .= " AND IFNULL(payments_table.payment_received,0)>0 AND IFNULL(payments_table.payment_received,0)<$invoice_value_calculation";
        } else if ($status === "fully_paid") {
            $where .= " AND TRUNCATE(IFNULL(payments_table.payment_received,0),2)>=$invoice_value_calculation";
        } else if ($status === "overdue") {
            $where .= " AND $invoices_table.status !='draft' AND $invoices_table.due_date<'$now' AND TRUNCATE(IFNULL(payments_table.payment_received,0),2)<$invoice_value_calculation";
        }


        $recurring = get_array_value($options, "recurring");
        if ($recurring) {
            $where .= " AND $invoices_table.recurring=1";
        }


        $exclude_due_reminder_date = get_array_value($options, "exclude_due_reminder_date");
        if ($exclude_due_reminder_date) {
            $where .= " AND ($invoices_table.due_reminder_date !='$exclude_due_reminder_date') ";
        }

        $exclude_recurring_reminder_date = get_array_value($options, "exclude_recurring_reminder_date");
        if ($exclude_recurring_reminder_date) {
            $where .= " AND ($invoices_table.recurring_reminder_date !='$exclude_recurring_reminder_date') ";
        }


        //prepare custom fild binding query
        $custom_fields = get_array_value($options, "custom_fields");
        $custom_field_query_info = $this->prepare_custom_field_query_string("invoices", $custom_fields, $invoices_table);
        $select_custom_fieds = get_array_value($custom_field_query_info, "select_string");
        $join_custom_fieds = get_array_value($custom_field_query_info, "join_string");




        $sql = "SELECT $invoices_table.*, $clients_table.currency, $clients_table.currency_symbol, $clients_table.company_name, $projects_table.title AS project_title,
           $invoice_value_calculation_query AS invoice_value, IFNULL(payments_table.payment_received,0) AS payment_received, tax_table.percentage AS tax_percentage, tax_table2.percentage AS tax_percentage2 $select_custom_fieds
        FROM $invoices_table
        LEFT JOIN $clients_table ON $clients_table.id= $invoices_table.client_id
        LEFT JOIN $projects_table ON $projects_table.id= $invoices_table.project_id
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.tax_id
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table2 ON tax_table2.id = $invoices_table.tax_id2
        LEFT JOIN (SELECT invoice_id, SUM(amount) AS payment_received FROM $invoice_payments_table WHERE deleted=0 GROUP BY invoice_id) AS payments_table ON payments_table.invoice_id = $invoices_table.id 
        LEFT JOIN (SELECT invoice_id, SUM(total) AS invoice_value FROM $invoice_items_table WHERE deleted=0 GROUP BY invoice_id) AS items_table ON items_table.invoice_id = $invoices_table.id 
        $join_custom_fieds
        WHERE $invoices_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_invoice_total_summary($invoice_id = 0) {
        $invoice_items_table = $this->db->dbprefix('invoice_items');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $invoices_table = $this->db->dbprefix('invoices');
        $clients_table = $this->db->dbprefix('clients');
        $taxes_table = $this->db->dbprefix('taxes');

        $item_sql = "SELECT SUM($invoice_items_table.total) AS invoice_subtotal
        FROM $invoice_items_table
        LEFT JOIN $invoices_table ON $invoices_table.id= $invoice_items_table.invoice_id    
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.invoice_id=$invoice_id AND $invoices_table.deleted=0";
        $item = $this->db->query($item_sql)->row();

        $payment_sql = "SELECT SUM($invoice_payments_table.amount) AS total_paid
        FROM $invoice_payments_table
        WHERE $invoice_payments_table.deleted=0 AND $invoice_payments_table.invoice_id=$invoice_id";
        $payment = $this->db->query($payment_sql)->row();

        $invoice_sql = "SELECT $invoices_table.*, tax_table.percentage AS tax_percentage, tax_table.title AS tax_name,
            tax_table2.percentage AS tax_percentage2, tax_table2.title AS tax_name2
        FROM $invoices_table
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.tax_id
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table2 ON tax_table2.id = $invoices_table.tax_id2
        WHERE $invoices_table.deleted=0 AND $invoices_table.id=$invoice_id";
        $invoice = $this->db->query($invoice_sql)->row();

        $client_sql = "SELECT $clients_table.currency_symbol, $clients_table.currency FROM $clients_table WHERE $clients_table.id=$invoice->client_id";
        $client = $this->db->query($client_sql)->row();


        $result = new stdClass();
        $result->invoice_subtotal = $item->invoice_subtotal;
        $result->tax_percentage = $invoice->tax_percentage;
        $result->tax_percentage2 = $invoice->tax_percentage2;
        $result->tax_name = $invoice->tax_name;
        $result->tax_name2 = $invoice->tax_name2;
        $result->tax = 0;
        $result->tax2 = 0;

        $invoice_subtotal = $result->invoice_subtotal;
        $invoice_subtotal_for_taxes = $invoice_subtotal;
        if ($invoice->discount_type == "before_tax") {
            $invoice_subtotal_for_taxes = $invoice_subtotal - ($invoice->discount_amount_type == "percentage" ? ($result->invoice_subtotal * ($invoice->discount_amount / 100)) : $invoice->discount_amount);
        }

        if ($invoice->tax_percentage) {
            $result->tax = $invoice_subtotal_for_taxes * ($invoice->tax_percentage / 100);
        }
        if ($invoice->tax_percentage2) {
            $result->tax2 = $invoice_subtotal_for_taxes * ($invoice->tax_percentage2 / 100);
        }
        $result->invoice_total = $item->invoice_subtotal + $result->tax + $result->tax2;

        $result->total_paid = $payment->total_paid;

        $result->currency_symbol = $client->currency_symbol ? $client->currency_symbol : get_setting("currency_symbol");
        $result->currency = $client->currency ? $client->currency : get_setting("default_currency");

        //get discount total
        $result->discount_total = 0;
        if ($invoice->discount_type == "after_tax") {
            $invoice_subtotal = $result->invoice_total;
        }

        $result->discount_total = $invoice->discount_amount_type == "percentage" ? ($invoice_subtotal * ($invoice->discount_amount / 100)) : $invoice->discount_amount;

        $result->discount_type = $invoice->discount_type;

        $result->balance_due = number_format($result->invoice_total, 2, ".", "") - number_format($payment->total_paid, 2, ".", "") - number_format($result->discount_total, 2, ".", "");

        return $result;
    }

    function invoice_statistics($options = array()) {
        $invoices_table = $this->db->dbprefix('invoices');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $invoice_items_table = $this->db->dbprefix('invoice_items');
        $taxes_table = $this->db->dbprefix('taxes');
        $info = new stdClass();
        $year = get_my_local_time("Y");

        $where = "";
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $invoices_table.client_id=$client_id";
        }

        $payments = "SELECT SUM($invoice_payments_table.amount) AS total, MONTH($invoice_payments_table.payment_date) AS month
            FROM $invoice_payments_table
            LEFT JOIN $invoices_table ON $invoices_table.id=$invoice_payments_table.invoice_id    
            WHERE $invoice_payments_table.deleted=0 AND YEAR($invoice_payments_table.payment_date)=$year AND $invoices_table.deleted=0 $where
            GROUP BY MONTH($invoice_payments_table.payment_date)";
        $info->payments = $this->db->query($payments)->result();

        $invoice_value_calculation_query = $this->_get_invoice_value_calculation_query($invoices_table);

        $invoices = "SELECT SUM(total) AS total, MONTH(due_date) AS month FROM (SELECT $invoice_value_calculation_query AS total ,$invoices_table.due_date
            FROM $invoices_table
            LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.tax_id
            LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage FROM $taxes_table) AS tax_table2 ON tax_table2.id = $invoices_table.tax_id2
            LEFT JOIN (SELECT invoice_id, SUM(total) AS invoice_value FROM $invoice_items_table WHERE deleted=0 GROUP BY invoice_id) AS items_table ON items_table.invoice_id = $invoices_table.id 
            WHERE $invoices_table.deleted=0 AND $invoices_table.status='not_paid' $where AND YEAR($invoices_table.due_date)=$year) as details_table
            GROUP BY  MONTH(due_date)";

        $info->payments = $this->db->query($payments)->result();
        $info->invoices = $this->db->query($invoices)->result();
        return $info;
    }

    function get_invoices_total_and_paymnts() {
        $invoices_table = $this->db->dbprefix('invoices');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $invoice_items_table = $this->db->dbprefix('invoice_items');
        $taxes_table = $this->db->dbprefix('taxes');
        $info = new stdClass();


        $payments = "SELECT SUM($invoice_payments_table.amount) AS total
            FROM $invoice_payments_table
            LEFT JOIN $invoices_table ON $invoices_table.id=$invoice_payments_table.invoice_id    
            WHERE $invoice_payments_table.deleted=0 AND $invoices_table.deleted=0";
        $info->payments = $this->db->query($payments)->result();
        
        $invoice_value_calculation_query = $this->_get_invoice_value_calculation_query($invoices_table);

        $invoices = "SELECT SUM(total) AS total FROM (SELECT $invoice_value_calculation_query AS total
            FROM $invoices_table
            LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.tax_id
            LEFT JOIN (SELECT $taxes_table.id, $taxes_table.percentage FROM $taxes_table) AS tax_table2 ON tax_table2.id = $invoices_table.tax_id2
            LEFT JOIN (SELECT invoice_id, SUM(total) AS invoice_value FROM $invoice_items_table WHERE deleted=0 GROUP BY invoice_id) AS items_table ON items_table.invoice_id = $invoices_table.id 
            WHERE $invoices_table.deleted=0 AND $invoices_table.status='not_paid') as details_table";

        $info->payments_total = $this->db->query($payments)->row()->total;
        $info->invoices_total = $this->db->query($invoices)->row()->total;
        $info->due = $info->invoices_total - $info->payments_total;
        return $info;
    }
    
    
    
    private function _get_invoice_value_calculation_query($invoices_table){
            $after_tax_1 = "(IFNULL(tax_table.percentage,0)/100*IFNULL(items_table.invoice_value,0))";
            $after_tax_2 = "(IFNULL(tax_table2.percentage,0)/100*IFNULL(items_table.invoice_value,0))";

            $discountable_invoice_value = "IF($invoices_table.discount_type='after_tax', (IFNULL(items_table.invoice_value,0) + $after_tax_1 + $after_tax_2), IFNULL(items_table.invoice_value,0) )";

            $discount_amount = "IF($invoices_table.discount_amount_type='percentage', IFNULL($invoices_table.discount_amount,0)/100* $discountable_invoice_value, $invoices_table.discount_amount)";

            $before_tax_1 = "(IFNULL(tax_table.percentage,0)/100* (IFNULL(items_table.invoice_value,0)- $discount_amount))";
            $before_tax_2 = "(IFNULL(tax_table2.percentage,0)/100* (IFNULL(items_table.invoice_value,0)- $discount_amount))";


            $invoice_value_calculation_query = "(
                IFNULL(items_table.invoice_value,0)+
                IF($invoices_table.discount_type='before_tax',  ($before_tax_1+ $before_tax_2), ($after_tax_1 + $after_tax_2))
                - $discount_amount
               )";
            
            return $invoice_value_calculation_query;
    }

    //change the invoice status from draft to not_paid
    function set_invoice_status_to_not_paid($invoice_id = 0) {
        $status_data = array("status" => "not_paid");
        return $this->save($status_data, $invoice_id);
    }

    //get the recurring invoices which are ready to renew as on a given date
    function get_renewable_invoices($date) {
        $invoices_table = $this->db->dbprefix('invoices');

        $sql = "SELECT * FROM $invoices_table
                        WHERE $invoices_table.deleted=0 AND $invoices_table.recurring=1
                        AND $invoices_table.next_recurring_date IS NOT NULL AND $invoices_table.next_recurring_date<='$date'
                        AND ($invoices_table.no_of_cycles < 1 OR ($invoices_table.no_of_cycles_completed < $invoices_table.no_of_cycles ))";

        return $this->db->query($sql);
    }

}
