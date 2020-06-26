<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal {

    private $paypal_live_url = "https://www.paypal.com/cgi-bin/webscr";
    private $paypal_sandbox_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    private $paypal_url = "";
    private $paypal_config;
    private $ci;
    private $debug = false;
    private $paypal_log_file = "./paypal.log";

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model("Paypal_ipn_model");

        $this->paypal_config = $this->ci->Payment_methods_model->get_oneline_payment_method("paypal_payments_standard");

        if ($this->paypal_config->debug == "1") {
            $this->debug = true;
        }

        if ($this->paypal_config->paypal_live == "1") {
            $this->paypal_url = $this->paypal_live_url;
        } else {
            $this->paypal_url = $this->paypal_sandbox_url;
        }
    }

    //return paypal communication url
    public function get_paypal_url() {
        return $this->paypal_url;
    }

    //validate the IPN
    public function is_valid_ipn() {

        $this->_log("..... Starting new IPN processing .....");

        // STEP 1: read POST data
        if (!count($_POST)) {
            $this->_log("No POST data found");
            return false;
        }

        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream. 
        $raw_post_data = file_get_contents('php://input');

        $serialize_data = serialize($_POST);
        $ipn_hash = md5(serialize($serialize_data));



        //check for duplicate data. if duplicate, do nothing. otherwise save the ipn
        if ($this->_is_duplicate_ipn($ipn_hash)) {
            $this->_log("Duplicate IPN: Hash# $ipn_hash");

            return false;
        } else {
            $this->_save_ipn($ipn_hash, get_array_value($_POST, "txn_id"), $serialize_data);

            $this->_log("IPN serialize data: $serialize_data ");
        }

        //so, we checked the duplicate ipn and it's a new ipn. go to next step for process 
        //check for valid receiver
        $receiver_email = get_array_value($_POST, "receiver_email");

        $business_email = get_array_value($_POST, "business");

        if (!($this->_is_valid_receiver($receiver_email) || $this->_is_valid_receiver($business_email))) {
            $this->_log("IPN receiver email does not matched with settings" . $receiver_email);
            return false;
        }


        //match the environment (sandbox/live) with paypal and system settings 
        $test_ipn = get_array_value($_POST, "test_ipn");
        if ($test_ipn == "1" && $this->paypal_config->paypal_live == "1") {
            $this->_log("IPN environment does not matched. Received IPN with test_ipn=1 but the system setting indicates live environment.");
            return false;
        }


        //check payment status
        /*
         * The status of the payment https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/:
         * 
          Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds for the transaction that was reversed have been returned to you.

          Completed: The payment has been completed, and the funds have been added successfully to your account balance.

          Created: A German ELV payment is made using Express Checkout.

          Denied: The payment was denied. This happens only if the payment was previously pending because of one of the reasons listed for the pending_reason variable or the Fraud_Management_Filters_x variable.

          Expired: This authorization has expired and cannot be captured.

          Failed: The payment has failed. This happens only if the payment was made from your customer's bank account.

          Pending: The payment is pending. See pending_reason for more information.

          Refunded: You refunded the payment.

          Reversed: A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from your account balance and returned to the buyer. The reason for the reversal is specified in the ReasonCode element.

          Processed: A payment has been accepted.

          Voided: This authorization has been voided.
         * 
         */



        $raw_post_array = explode('&', $raw_post_data);

        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // STEP 2: POST IPN data back to PayPal to validate
        $ch = curl_init($this->paypal_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        if (!($res = curl_exec($ch))) {
            $this->_log("IPN Procecing : " . curl_error($ch));

            curl_close($ch);
            exit;
        }
        curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly
        if (strcmp($res, "VERIFIED") == 0) {

            //now we'll only process the Completed status
            $payment_status = get_array_value($_POST, "payment_status");

            $this->_log("IPN verified: Payment status is " . $payment_status);
            if ($payment_status == "Completed") {

                return true;
            } else {
                return false;
            }
        } else if (strcmp($res, "INVALID") == 0) {

            $this->_log("IPN is not valid: Paypal handshake result is INVALID");
            return false;
        }
    }

    //save ipn to database
    private function _save_ipn($ipn_hash, $txn_id, $ipn_data) {
        $paypal_ipn_data = array("ipn_hash" => $ipn_hash, "transaction_id" => $txn_id, "ipn_data" => $ipn_data);
        return $this->ci->Paypal_ipn_model->save($paypal_ipn_data);
    }

    //get ipn from database by hash 
    private function _get_ipn($ipn_hash = "") {
        return $this->ci->Paypal_ipn_model->get_one_where(array("deleted" => 0, "ipn_hash" => $ipn_hash));
    }

    //check duplicate ipn
    private function _is_duplicate_ipn($ipn_hash = "") {
        if ($this->_get_ipn($ipn_hash)->ipn_hash == $ipn_hash) {
            return true;
        }
    }

    //check the ipn receiver is valid
    private function _is_valid_receiver($ipn_receiver) {
        if ($this->paypal_config->email == $ipn_receiver) {
            return true;
        }
    }

    //save log to a file if debug mode is enabled
    private function _log($message = "") {
        if ($this->debug) {
            try {
                error_log(date('[Y-m-d H:i e] ') . $message . PHP_EOL, 3, $this->paypal_log_file);
            } catch (Exception $e) {
                
            }
        }
    }

}
