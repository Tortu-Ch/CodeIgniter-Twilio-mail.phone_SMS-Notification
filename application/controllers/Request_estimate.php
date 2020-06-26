<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Request_estimate extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!get_setting("module_estimate_request")) {
            show_404();
        }

        $view_data['topbar'] = "includes/public/topbar";
        $view_data['left_menu'] = false;

        $view_data["estimate_forms"] = $this->Estimate_forms_model->get_all_where(array("status" => "active", "public" => "1", "deleted" => 0))->result();
        $this->template->rander("request_estimate/index", $view_data);
    }

    function form($id = 0) {
        if (!get_setting("module_estimate_request")) {
            show_404();
        }

        if (!$id) {
            redirect("request_estimate");
        }


        $view_data['topbar'] = "includes/public/topbar";
        $view_data['left_menu'] = false;


        $model_info = $this->Estimate_forms_model->get_one_where(array("id" => $id, "public" => "1", "status" => "active", "deleted" => 0));

        if (get_setting("module_estimate_request") && $model_info->id) {
            $view_data['model_info'] = $model_info;
            $this->template->rander('request_estimate/estimate_request_form', $view_data);
        } else {
            show_404();
        }
    }

    //save estimate request from client
    function save_estimate_request() {


        $form_id = $this->input->post('form_id');

        validate_submitted_data(array(
            "form_id" => "required|numeric",
            "company_name" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required",
        ));


        $this->load->model("Leads_model");


        $options = array("related_to" => "estimate_form-" . $form_id);
        $form_fields = $this->Custom_fields_model->get_details($options)->result();

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "estimate");


        $leads_data = array(
            "company_name" => $this->input->post('company_name'),
            "address" => $this->input->post('address'),
            "city" => $this->input->post('city'),
            "state" => $this->input->post('state'),
            "zip" => $this->input->post('zip'),
            "country" => $this->input->post('country'),
            "phone" => $this->input->post('phone'),
            "first_name" => $this->input->post('first_name'),
            "last_name" => $this->input->post('last_name'),
            "email" => $this->input->post('email')
        );

        $leads_data = clean_data($leads_data);
        $lead_id = $this->Leads_model->save($leads_data);

        $request_data = array(
            "estimate_form_id" => $form_id,
            "created_by" => 0,
            "created_at" => get_current_utc_time(),
            "client_id" => 0,
            "lead_id" => $lead_id,
            "assigned_to" => 0,
            "status" => "new"
        );

        $request_data = clean_data($request_data);
        
        $request_data["files"] = $files_data; //don't clean serilized data

        $save_id = $this->Estimate_requests_model->save($request_data);
        if ($save_id) {

            //estimate request has been saved, now save the field values
            foreach ($form_fields as $field) {
                $value = $this->input->post("custom_field_" . $field->id);
                if ($value) {
                    $field_value_data = array(
                        "related_to_type" => "estimate_request",
                        "related_to_id" => $save_id,
                        "custom_field_id" => $field->id,
                        "value" => $value
                    );

                    $field_value_data = clean_data($field_value_data);

                    $this->Custom_field_values_model->save($field_value_data);
                }
            }


            //create notification
            log_notification("estimate_request_received", array("estimate_request_id" => $save_id, "user_id" => "999999999"));

            echo json_encode(array("success" => true, 'message' => lang('estimate_submission_message')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //prepare data for datatable for estimate form's field list
    function estimate_form_filed_list_data($id = 0) {

        $options = array("related_to" => "estimate_form-" . $id);
        $list_data = $this->Custom_fields_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_form_field_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //prepare a row of estimates form's field list
    private function _make_form_field_row($data) {

        $required = "";
        if ($data->required) {
            $required = "*";
        }

        $field = "<label data-id='$data->id' class='field-row'>$data->title $required</label>";
        $field.="<div class='form-group'>" . $this->load->view("custom_fields/input_" . $data->field_type, array("field_info" => $data), true) . "</div>";

        //extract estimate id from related_to field. 2nd index should be the id
        $estimate_form_id = get_array_value(explode("-", $data->related_to), 1);

        return array(
            $field,
            $data->sort,
            modal_anchor(get_uri("estimate_requests/estimate_form_field_modal_form/" . $estimate_form_id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_form'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("estimate_requests/estimate_form_field_delete"), "data-action" => "delete"))
        );
    }

    /* upload a file */

    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for ticket */

    function validate_file() {
        return validate_post_file($this->input->post("file_name"));
    }

}

/* End of file quotations.php */
/* Location: ./application/controllers/quotations.php */