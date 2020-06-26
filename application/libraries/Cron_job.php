<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron_job {

    private $today = null;
    private $ci = null;

    function run() {
        $this->today = get_today_date();
        $this->ci = get_instance();

        $this->create_recurring_invoices();

        $this->send_invoice_due_pre_reminder();
        $this->send_invoice_due_after_reminder();
        $this->send_recurring_invoice_creation_reminder();
    }

    private function send_invoice_due_pre_reminder() {

        $reminder_date = get_setting("send_invoice_due_pre_reminder");

        if ($reminder_date) {

            //prepare invoice due date accroding to the setting
            $start_date = add_period_to_date($this->today, get_setting("send_invoice_due_pre_reminder"), "days");

            $invoices = $this->ci->Invoices_model->get_details(array(
                        "status" => "not_paid", //find all invoices which are not paid yet but due date not expired
                        "start_date" => $start_date,
                        "end_date" => $start_date, //both should be same
                        "exclude_due_reminder_date" => $this->today //don't find invoices which reminder already sent today
                    ))->result();

            foreach ($invoices as $invoice) {
                log_notification("invoice_due_reminder_before_due_date", array("invoice_id" => $invoice->id), "0");
            }
        }
    }

    private function send_invoice_due_after_reminder() {

        $reminder_date = get_setting("send_invoice_due_after_reminder");

        if ($reminder_date) {

            //prepare invoice due date accroding to the setting
            $start_date = subtract_period_from_date($this->today, get_setting("send_invoice_due_after_reminder"), "days");

            $invoices = $this->ci->Invoices_model->get_details(array(
                        "status" => "overdue", //find all invoices where due date has expired
                        "start_date" => $start_date,
                        "end_date" => $start_date, //both should be same
                        "exclude_due_reminder_date" => $this->today //don't find invoices which reminder already sent today
                    ))->result();

            foreach ($invoices as $invoice) {
                log_notification("invoice_overdue_reminder", array("invoice_id" => $invoice->id), "0");
            }
        }
    }
    
     private function send_recurring_invoice_creation_reminder() {

        $reminder_date = get_setting("send_recurring_invoice_reminder_before_creation");

        if ($reminder_date) {

            //prepare invoice due date accroding to the setting
            $start_date = add_period_to_date($this->today, get_setting("send_recurring_invoice_reminder_before_creation"), "days");

            $invoices = $this->ci->Invoices_model->get_details(array(
                        "status" => "not_paid", //non-draft invoices
                        "recurring"=>1,
                        "next_recurring_start_date" => $start_date,
                        "next_recurring_end_date" => $start_date, //both should be same
                        "exclude_recurring_reminder_date" => $this->today //don't find invoices which reminder already sent today
                    ))->result();

            foreach ($invoices as $invoice) {
                log_notification("recurring_invoice_creation_reminder", array("invoice_id" => $invoice->id), "0");
            }
        }
    }
    

    private function create_recurring_invoices() {
        $recurring_invoices = $this->ci->Invoices_model->get_renewable_invoices($this->today);
        if ($recurring_invoices->num_rows()) {
            foreach ($recurring_invoices->result() as $invoice) {
                $this->_create_new_invoice($invoice);
            }
        }
    }

    //create new invoice from a recurring invoice 
    private function _create_new_invoice($invoice) {

        //don't update the next recurring date when updating invoice manually?
        //stop backdated recurring invoice creation.
        //check recurring invoice once/hour?
        //settings: send invoice to client


        $bill_date = $invoice->next_recurring_date;
        $diff_of_due_date = get_date_difference_in_days($invoice->due_date, $invoice->bill_date); //calculate the due date difference of the original invoice
        $due_date = add_period_to_date($bill_date, $diff_of_due_date, "days");



        $new_invoice_data = array(
            "client_id" => $invoice->client_id,
            "project_id" => $invoice->project_id,
            "bill_date" => $bill_date,
            "due_date" => $due_date,
            "note" => $invoice->note,
            "status" => "draft",
            "tax_id" => $invoice->tax_id,
            "tax_id2" => $invoice->tax_id2,
            "recurring_invoice_id" => $invoice->id
        );

        //create new invoice
        $new_invoice_id = $this->ci->Invoices_model->save($new_invoice_data);

        //create invoice items
        $items = $this->ci->Invoice_items_model->get_details(array("invoice_id" => $invoice->id))->result();
        foreach ($items as $item) {
            //create invoice items for new invoice
            $new_invoice_item_data = array(
                "title" => $item->title,
                "description" => $item->description,
                "quantity" => $item->quantity,
                "unit_type" => $item->unit_type,
                "rate" => $item->rate,
                "total" => $item->total,
                "invoice_id" => $new_invoice_id,
            );
            $this->ci->Invoice_items_model->save($new_invoice_item_data);
        }


        //update the main recurring invoice
        $no_of_cycles_completed = $invoice->no_of_cycles_completed + 1;
        $next_recurring_date = add_period_to_date($bill_date, $invoice->repeat_every, $invoice->repeat_type);


        $recurring_invoice_data = array(
            "next_recurring_date" => $next_recurring_date,
            "no_of_cycles_completed" => $no_of_cycles_completed
        );
        $this->ci->Invoices_model->save($recurring_invoice_data, $invoice->id);

        //finally send notification
        log_notification("recurring_invoice_created_vai_cron_job", array("invoice_id" => $new_invoice_id), "0");
    }

}
