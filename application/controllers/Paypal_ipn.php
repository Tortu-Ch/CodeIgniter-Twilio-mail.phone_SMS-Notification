<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//don't extend this controller from Pre_loader 
//because this will be called by PayPal 
//and login check is not required since we'll validate the data

class Paypal_ipn extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /* load invoice list view */

    function index() {

        $this->load->library("paypal");

        //process ipn
        if ($this->paypal->is_valid_ipn()) {

            //so, ipn is valid. now update the invoice payment in db

            $custom = get_array_value($_POST, "custom");

            $custom_array = array();
            foreach (explode(";", $custom) as $sub_values) {
                $sub_value = explode(":", $sub_values);
                if (count($sub_value) == 2) {
                    $custom_array[$sub_value[0]] = $sub_value[1];
                }
            }


            //set login user id = contact id for future processing
            $this->login_user->id = get_array_value($custom_array, "contact_user_id");
            $this->login_user->user_type = "client";

            $invoice_id = get_array_value($custom_array, "invoice_id");

            //payment complete, insert payment record
            $invoice_payment_data = array(
                "invoice_id" => $invoice_id,
                "payment_date" => get_current_utc_time(),
                "payment_method_id" => get_array_value($custom_array, "payment_method_id"),
                "note" => "",
                "amount" => get_array_value($_POST, "mc_gross"),
                "transaction_id" => get_array_value($_POST, "txn_id"),
                "created_at" => get_current_utc_time(),
                "created_by" => $this->login_user->id,
            );

            $invoice_payment_id = $this->Invoice_payments_model->save($invoice_payment_data);

            if ($invoice_payment_id) {
                //As receiving payment for the invoice, we'll remove the 'draft' status from the invoice 
                $this->Invoices_model->set_invoice_status_to_not_paid($invoice_id);

                log_notification("invoice_payment_confirmation", array("invoice_payment_id" => $invoice_payment_id, "invoice_id" => $invoice_id), "0");
                log_notification("invoice_online_payment_received", array("invoice_payment_id" => $invoice_payment_id, "invoice_id" => $invoice_id), $this->login_user->id);
                //db updated successfully
            }
        }
    }

}

/* End of file payments.php */
/* Location: ./application/controllers/Paypal_ipn.php */