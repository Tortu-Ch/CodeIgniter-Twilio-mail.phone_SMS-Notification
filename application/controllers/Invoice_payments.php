<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_payments extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->init_permission_checker("invoice");
    }

    /* load invoice list view */

    function index() {
        if ($this->login_user->user_type === "staff") {
            $view_data['payment_method_dropdown'] = $this->get_payment_method_dropdown();
            $this->template->rander("invoices/payment_received", $view_data);
        } else {
            $view_data["client_info"] = $this->Clients_model->get_one($this->login_user->client_id);
            $view_data['client_id'] = $this->login_user->client_id;
            $view_data['page_type'] = "full";
            $this->template->rander("clients/payments/index", $view_data);
        }
    }

    function get_payment_method_dropdown() {
        $this->access_only_team_members();

        $payment_methods = $this->Payment_methods_model->get_all_where(array("deleted" => 0))->result();

        $payment_method_dropdown = array(array("id" => "", "text" => "- " . lang("payment_methods") . " -"));
        foreach ($payment_methods as $value) {
            $payment_method_dropdown[] = array("id" => $value->id, "text" => $value->title);
        }

        return json_encode($payment_method_dropdown);
    }

    //load the payment list yearly view
    function yearly() {
        $this->load->view("invoices/yearly_payments");
    }

    //load custom payment list
    function custom() {
        $this->load->view("invoices/custom_payments_list");
    }

    /* load payment modal */

    function payment_modal_form() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "numeric",
            "invoice_id" => "numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');

        $view_data['model_info'] = $this->Invoice_payments_model->get_one($this->input->post('id')); 
        
        if (!$invoice_id) {
            $invoice_id = $view_data['model_info']->invoice_id;
        }
        $view_data['payment_methods_dropdown'] = $this->Payment_methods_model->get_dropdown_list(array("title"), "id", array("online_payable" => 0, "deleted" => 0));
        $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoices/payment_modal_form', $view_data);
    }

    /* add or edit a payment */

    function save_payment() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "numeric",
            "invoice_id" => "required|numeric",
            "invoice_payment_method_id" => "required|numeric",
            "invoice_payment_date" => "required",
            "invoice_payment_amount" => "required"
        ));

        $id = $this->input->post('id');
        $invoice_id = $this->input->post('invoice_id');

        $invoice_payment_data = array(
            "invoice_id" => $invoice_id,
            "payment_date" => $this->input->post('invoice_payment_date'),
            "payment_method_id" => $this->input->post('invoice_payment_method_id'),
            "note" => $this->input->post('invoice_payment_note'),
            "amount" => unformat_currency($this->input->post('invoice_payment_amount')),
            "created_at" => get_current_utc_time(),
            "created_by" => $this->login_user->id,
        );

        $invoice_payment_id = $this->Invoice_payments_model->save($invoice_payment_data, $id);
        if ($invoice_payment_id) {

            //As receiving payment for the invoice, we'll remove the 'draft' status from the invoice 
            $this->Invoices_model->set_invoice_status_to_not_paid($invoice_id);

            if (!$id) { //show payment confirmation for new payments only
                log_notification("invoice_payment_confirmation", array("invoice_payment_id" => $invoice_payment_id, "invoice_id" => $invoice_id), "0");
            }
            //get payment data
            $options = array("id" => $invoice_payment_id);
            $item_info = $this->Invoice_payments_model->get_details($options)->row();
            echo json_encode(array("success" => true, "invoice_id" => $item_info->invoice_id, "data" => $this->_make_payment_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->invoice_id), 'id' => $invoice_payment_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* delete or undo a payment */

    function delete_payment() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Invoice_payments_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Invoice_payments_model->get_details($options)->row();
                echo json_encode(array("success" => true, "invoice_id" => $item_info->invoice_id, "data" => $this->_make_payment_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->invoice_id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Invoice_payments_model->delete($id)) {
                $item_info = $this->Invoice_payments_model->get_one($id);
                echo json_encode(array("success" => true, "invoice_id" => $item_info->invoice_id, "invoice_total_view" => $this->_get_invoice_total_view($item_info->invoice_id), 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of invoice payments, prepared for datatable  */

    function payment_list_data($invoice_id = 0) {
        $this->access_only_allowed_members();

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $payment_method_id = $this->input->post('payment_method_id');
        $options = array("start_date" => $start_date, "end_date" => $end_date, "invoice_id" => $invoice_id, "payment_method_id" => $payment_method_id);

        $list_data = $this->Invoice_payments_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_payment_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* list of invoice payments, prepared for datatable  */

    function payment_list_data_of_client($client_id = 0) {

        $this->access_only_allowed_members_or_client_contact($client_id);

        $options = array("client_id" => $client_id);
        $list_data = $this->Invoice_payments_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_payment_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* list of invoice payments, prepared for datatable  */

    function payment_list_data_of_project($project_id = 0) {
        $options = array("project_id" => $project_id);

        $list_data = $this->Invoice_payments_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_payment_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of invoice payment list table */

    private function _make_payment_row($data) {
        $invoice_url = "";
        $this->access_only_allowed_members_or_client_contact($data->client_id);

        if ($this->login_user->user_type == "staff") {
            $invoice_url = anchor(get_uri("invoices/view/" . $data->invoice_id), get_invoice_id($data->invoice_id));
        } else {
            $invoice_url = anchor(get_uri("invoices/preview/" . $data->invoice_id), get_invoice_id($data->invoice_id));
        }
        return array(
            $invoice_url,
            $data->payment_date,
            format_to_date($data->payment_date, false),
            $data->payment_method_title,
            $data->note,
            to_currency($data->amount, $data->currency_symbol),
            modal_anchor(get_uri("invoice_payments/payment_modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_payment'), "data-post-id" => $data->id, "data-post-invoice_id" => $data->invoice_id,))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("invoice_payments/delete_payment"), "data-action" => "delete"))
        );
    }

    /* invoice total section */

    private function _get_invoice_total_view($invoice_id = 0) {
        $view_data["invoice_total_summary"] = $this->Invoices_model->get_invoice_total_summary($invoice_id);
        $view_data["invoice_id"] = $invoice_id;
        return $this->load->view('invoices/invoice_total_section', $view_data, true);
    }

    function pay_invoice_via_stripe() {
        validate_submitted_data(array(
            "stripe_token" => "required",
            "invoice_id" => "required"
        ));

        $this->access_only_clients();

        $invoice_id = $this->input->post('invoice_id');
        $method_info = $this->Payment_methods_model->get_oneline_payment_method("stripe");

        //load stripe lib
        require_once(APPPATH . "third_party/Stripe/init.php");
        \Stripe\Stripe::setApiKey($method_info->secret_key);


        if (!$invoice_id) {
            redirect("forbidden");
        }

        $redirect_to = "invoices/preview/$invoice_id";

        try {

            //check payment token
            $card = $this->input->post('stripe_token');

            $invoice_data = (Object) get_invoice_making_data($invoice_id);
            $currency = $invoice_data->invoice_total_summary->currency;


            //check if partial payment allowed or not
            if (get_setting("allow_partial_invoice_payment_from_clients")) {
                $payment_amount = unformat_currency($this->input->post('payment_amount'));
            } else {
                $payment_amount = $invoice_data->invoice_total_summary->balance_due;
            }


            //validate payment amount
            if ($payment_amount < $method_info->minimum_payment_amount * 1) {
                $error_message = lang('minimum_payment_validation_message') . " " . to_currency($method_info->minimum_payment_amount, $currency . " ");
                $this->session->set_flashdata("error_message", $error_message);
                redirect($redirect_to);
            }



            //prepare stripe payment data

            $metadata = array(
                "invoice_id" => $invoice_id,
                "contact_user_id" => $this->login_user->id,
                "client_id" => $invoice_data->client_info->id
            );

            $stripe_data = array(
                "amount" => $payment_amount * 100, //convert to cents
                "currency" => $currency,
                "card" => $card,
                "metadata" => $metadata,
                "description" => get_invoice_id($invoice_id) . ", " . lang('amount') . ": " . to_currency($payment_amount, $currency . " ")
            );

            $charge = \Stripe\Charge::create($stripe_data);

            if ($charge->paid) {

                //payment complete, insert payment record
                $invoice_payment_data = array(
                    "invoice_id" => $invoice_id,
                    "payment_date" => get_my_local_time(),
                    "payment_method_id" => $method_info->id,
                    "note" => $this->input->post('invoice_payment_note'),
                    "amount" => $payment_amount,
                    "transaction_id" => $charge->id,
                    "created_at" => get_current_utc_time(),
                    "created_by" => $this->login_user->id,
                );

                $invoice_payment_id = $this->Invoice_payments_model->save($invoice_payment_data);
                if ($invoice_payment_id) {

                    //As receiving payment for the invoice, we'll remove the 'draft' status from the invoice 
                    $this->Invoices_model->set_invoice_status_to_not_paid($invoice_id);

                    log_notification("invoice_payment_confirmation", array("invoice_payment_id" => $invoice_payment_id, "invoice_id" => $invoice_id), "0");
                    log_notification("invoice_online_payment_received", array("invoice_payment_id" => $invoice_payment_id, "invoice_id" => $invoice_id));
                    $this->session->set_flashdata("success_message", lang("payment_success_message"));
                    redirect($redirect_to);
                } else {
                    $this->session->set_flashdata("error_message", lang("payment_card_charged_but_system_error_message"));
                    redirect($redirect_to);
                }
            } else {
                $this->session->set_flashdata("error_message", lang("card_payment_failed_error_message"));
                redirect($redirect_to);
            }
        } catch (Stripe_CardError $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        } catch (Stripe_InvalidRequestError $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        } catch (Stripe_AuthenticationError $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        } catch (Stripe_ApiConnectionError $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        } catch (Stripe_Error $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        } catch (Exception $e) {

            $error_data = $e->getJsonBody();
            $this->session->set_flashdata("error_message", $error_data['error']['message']);
            redirect($redirect_to);
        }
    }

    //load the expenses yearly chart view
    function yearly_chart() {
        $this->load->view("invoices/yearly_payments_chart");
    }

    function yearly_chart_data() {

        $months = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
        $result = array();

        $year = $this->input->post("year");
        if ($year) {
            $payments = $this->Invoice_payments_model->get_yearly_payments_chart($year);
            $values = array();
            foreach ($payments as $value) {
                $values[$value->month - 1] = $value->total; //in array the month january(1) = index(0)
            }

            foreach ($months as $key => $month) {
                $value = get_array_value($values, $key);
                $result[] = array(lang("short_" . $month), $value ? $value : 0);
            }

            echo json_encode(array("data" => $result));
        }
    }

}

/* End of file payments.php */
/* Location: ./application/controllers/payments.php */