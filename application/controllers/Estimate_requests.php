<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estimate_requests extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->init_permission_checker("estimate");
    }

    //load the estimate requests view
    function index() {
        $this->check_module_availability("module_estimate_request");

        $this->access_only_allowed_members();

        //prepare assign to filter list
        $assigned_to_dropdown = array(array("id" => "", "text" => "- " . lang("assigned_to") . " -"));

        $assigned_to_list = $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", array("deleted" => 0, "user_type" => "staff"));
        foreach ($assigned_to_list as $key => $value) {
            $assigned_to_dropdown[] = array("id" => $key, "text" => $value);
        }

        $view_data['assigned_to_dropdown'] = json_encode($assigned_to_dropdown);

        //prepare status filter list
        $statuses_dropdown = array(
            array("id" => "", "text" => "- " . lang("status") . " -"),
            array("id" => "new", "text" => lang("new")),
            array("id" => "processing", "text" => lang("processing")),
            array("id" => "estimated", "text" => lang("estimated")),
            array("id" => "hold", "text" => lang("hold")),
            array("id" => "canceled", "text" => lang("canceled"))
        );

        $view_data['statuses_dropdown'] = json_encode($statuses_dropdown);

        $this->template->rander('estimate_requests/index', $view_data);
    }

    //view estimate request
    function view_estimate_request($id = 0) {

        $model_info = $this->Estimate_requests_model->get_details(array("id" => $id))->row();

        if ($model_info) {
            $this->access_only_allowed_members_or_client_contact($model_info->client_id);
        } else {
            show_404();
        }



        $view_data['model_info'] = $model_info;
        $view_data['status'] = $this->_get_estimate_status_label($model_info->status);

        $view_data['lead_info'] = "";

        $this->load->model("Leads_model");

        if (!$model_info->client_id && $model_info->lead_id) {
            $view_data['lead_info'] = $this->Leads_model->get_details(array("id" => $model_info->lead_id))->row();
        }


        //hide some info from client
        $view_data["show_actions"] = false;
        $view_data["show_client_info"] = false;
        $view_data["show_assignee"] = false;
        $view_data["show_download_option"] = false;

        if ($this->login_user->user_type == "staff") {
            $view_data["show_actions"] = true;
            $view_data["show_client_info"] = true;
            $view_data["show_assignee"] = true;
            $view_data["show_download_option"] = true;
        }


        $this->template->rander('estimate_requests/view_estimate_request', $view_data);
    }

    // download files 
    function download_estimate_request_files($id = 0) {
        $this->access_only_allowed_members();
        $info = $this->Estimate_requests_model->get_one($id);
        download_app_files(get_setting("timeline_file_path"), $info->files);
    }

    //prepare data for datatable for estimate request list
    function estimate_request_list_data() {
        $this->access_only_allowed_members();

        $options = array("assigned_to" => $this->input->post("assigned_to"), "status" => $this->input->post("status"));
        $list_data = $this->Estimate_requests_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_estimate_request_row($data);
        }
        
        echo json_encode(array("data" => $result));
    }

    /* load estimate requests tab  */

    function estimate_requests_for_client($client_id) {
        $this->access_only_allowed_members_or_client_contact($client_id);

        if ($client_id) {
            $view_data['client_id'] = $client_id;
            $this->load->view("clients/estimates/estimate_requests", $view_data);
        }
    }

    // list of estimate requests of a specific client, prepared for datatable 
    function estimate_requests_list_data_of_client($client_id) {
        $this->access_only_allowed_members_or_client_contact($client_id);

        $options = array("client_id" => $client_id, "status" => $this->input->post("status"));
        $list_data = $this->Estimate_requests_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_estimate_request_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //prepare a row of estimates request list
    private function _make_estimate_request_row($data) {
        $assigned_to = "-";

        if ($data->assigned_to) {
            $image_url = get_avatar($data->assigned_to_avatar);
            $assigned_to_user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $data->assigned_to_user";
            $assigned_to = get_team_member_profile_link($data->assigned_to, $assigned_to_user);
        }

        $status = $this->_get_estimate_status_label($data->status);

        $client = "";
        if ($data->company_name) {
            $client = anchor(get_uri("clients/view/" . $data->client_id), $data->company_name);
        } else if ($data->lead_company_name) {
            $client = $data->lead_company_name;
        }
        
        // Added by Li
        
        $create = '<li role="presentation">' . modal_anchor('', '<a href="https://becodemo.website/index.php/estimates/view/'.$data->id.'"><i class="fa fa-pencil"></i>' . lang('create').'</a>', array("title" => lang('estimate_request'), "data-post-view" => "details", "data-post-id" => $data->id)) . '</li>';
        
        $edit = '<li role="presentation">' . modal_anchor(get_uri("estimate_requests/edit_estimate_request_modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit'), array("title" => lang('estimate_request'), "data-post-view" => "details", "data-post-id" => $data->id)) . '</li>';

        $request_status = $this->load->view("estimate_requests/estimate_request_status_options", array("model_info" => $data), true);

        $delete = '<li role="presentation">' . js_anchor("<i class='fa fa-times fa-fw'></i>" . lang('delete'), array('title' => lang('delete_estimate_form'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("estimate_requests/delete_estimate_request"), "data-action" => "delete-confirmation")) . '</li>';

        $options = '<span class="dropdown inline-block">
                        <button class="btn btn-default dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-cogs"></i>&nbsp;
                             <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">' .$create . $edit . $request_status . $delete . '</ul>
                    </span>';


        return array(
            anchor(get_uri("estimate_requests/view_estimate_request/" . $data->id), lang("estimate_request") . " - " . $data->id),
            $client,
            $data->form_title,
            $assigned_to,
            $data->created_at,
            format_to_datetime($data->created_at),
            $status,
            $options
        );
    }

    //get a row of estimate request list
    private function _estimate_request_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Estimate_requests_model->get_details($options)->row();
        return $this->_make_estimate_request_row($data);
    }

    //delete/undo estimate request
    function delete_estimate_request() {
        $this->access_only_allowed_members();


        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        if ($this->Estimate_requests_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    private function _get_estimate_status_label($status = "") {
        $status_class = "label-default";

        if ($status === "new") {
            $status_class = "label-warning";
        } else if ($status === "processing") {
            $status_class = "label-primary";
        } else if ($status === "hold") {
            $status_class = "label-default";
        } else if ($status === "canceled") {
            $status_class = "label-danger";
        } else if ($status === "estimated") {
            $status_class = "label-success";
        }

        return "<span class='label $status_class large'>" . lang($status) . "</span>";
    }

    //prepare data for datatable for estimate request field list
    function estimate_request_filed_list_data($id = 0) {

        $model_info = $this->Estimate_requests_model->get_one($id);

        if ($model_info) {
            $this->access_only_allowed_members_or_client_contact($model_info->client_id);
        } else {
            show_404();
        }


        $options = array("related_to_type" => "estimate_request", "related_to_id" => $id);
        $list_data = $this->Custom_field_values_model->get_details($options)->result();

        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_estimate_request_field_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //prepare a row of estimates request's field list row
    private function _make_estimate_request_field_row($data) {
        $field = "<p class='clearfix'><i class='fa fa-check-circle'></i><strong class=''> $data->custom_field_title </strong> </p>";
        $field .= "<div class='pl15'>" . $this->load->view("custom_fields/output_" . $data->custom_field_type, array("value" => $data->value), true) . "</div>";
        return array(
            $field,
            $data->sort
        );
    }

    //load the estimate request froms view
    function estimate_forms() {
        $this->access_only_allowed_members();

        $this->template->rander('estimate_requests/estimate_forms');
    }

    //add/edit form of estimate request form 
    function estimate_request_modal_form() {
        $this->access_only_allowed_members();

        $view_data['model_info'] = $this->Estimate_forms_model->get_one($this->input->post('id'));
        $this->load->view('estimate_requests/estimate_request_modal_form', $view_data);
    }

    //save/update estimate request form
    function save_estimate_request_form() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->input->post('id');
        $public = $this->input->post('public');
        $enable_attachment = $this->input->post('enable_attachment');

        $data = array(
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "status" => $this->input->post('status'),
            "public" => $public ? 1 : 0,
            "enable_attachment" => $enable_attachment ? 1 : 0
        );


        $save_id = $this->Estimate_forms_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_form_row_data($save_id), 'newData' => $id ? false : true, 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //delete/undo estimate request form
    function delete_estimate_request_form() {
        $this->access_only_allowed_members();


        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        if ($this->input->post('undo')) {
            if ($this->Estimate_forms_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_form_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Estimate_forms_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    //prepare data for datatable for estimate forms list
    function estimate_forms_list_data() {
        $this->access_only_allowed_members();

        $list_data = $this->Estimate_forms_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_form_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row of estimate forms list
    private function _form_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Estimate_forms_model->get_details($options)->row();
        return $this->_make_form_row($data);
    }

    //prepare a row of estimates forms list
    private function _make_form_row($data) {
        $title = anchor(get_uri("estimate_requests/edit_estimate_form/" . $data->id), $data->title, array("class" => "edit", "title" => lang('edit_estimate_form'), "data-post-id" => $data->id));

        $public = "";
        if ($data->public) {
            $public = anchor("request_estimate/form/" . $data->id, lang("yes") . "<i class='fa fa-external-link ml10'></i>", array("target" => "_blank", "class" => ""));
        } else {
            $public = lang("no");
        }

        return array(
            $title,
            $public,
            lang($data->status),
            modal_anchor(get_uri("estimate_requests/estimate_request_modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_form'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_estimate_form'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("estimate_requests/delete_estimate_request_form"), "data-action" => "delete"))
        );
    }

    //edit estimate request form
    function edit_estimate_form($id = 0) {
        $this->access_only_allowed_members();

        $model_info = $this->Estimate_forms_model->get_one($id);
        $view_data['model_info'] = $model_info;
        $this->template->rander('estimate_requests/edit_estimate_form', $view_data);
    }

    //update assigne to field for estimate request
    function edit_estimate_request_modal_form() {

        $this->access_only_allowed_members();


        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $model_info = $this->Estimate_requests_model->get_one($this->input->post("id"));
        //prepare assign to list
        $assigned_to_dropdown = array("" => "-") + $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", array("deleted" => 0, "user_type" => "staff"));
        $view_data['assigned_to_dropdown'] = $assigned_to_dropdown;
        $view_data['model_info'] = $model_info;

        $this->load->view('estimate_requests/edit_estimate_request_modal_form', $view_data);
    }

    //update estimate request assigne to
    function update_estimate_request() {
        $this->access_only_allowed_members();

        $id = $this->input->post('id');

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $data = array(
            "assigned_to" => $this->input->post('assigned_to')
        );

        $save_id = $this->Estimate_requests_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //update estimate request status
    function change_estimate_request_status($id, $status) {
        $this->access_only_allowed_members();

        if ($id && ($status == "processing" || $status == "estimated" || $status == "hold" || $status == "canceled")) {
            $data = array("status" => $status);

            $save_id = $this->Estimate_requests_model->save($data, $id);
            if ($save_id) {
                echo json_encode(array("success" => true, 'message' => lang('record_saved')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
            }
        }
    }

    //view estimate request form
    function preview_estimate_form($id = 0) {
        $this->access_only_allowed_members();

        $model_info = $this->Estimate_forms_model->get_one($id);
        $view_data['model_info'] = $model_info;
        $this->template->rander('estimate_requests/preview_estimate_form', $view_data);
    }

    //add/edit form of estimate request form field 
    function estimate_form_field_modal_form($estimate_form_id = 0) {
        $this->access_only_allowed_members();

        $view_data['model_info'] = $this->Custom_fields_model->get_one($this->input->post('id'));
        $view_data['estimate_form_id'] = $estimate_form_id;
        $this->load->view('estimate_requests/estimate_form_field_modal_form', $view_data);
    }

    //save/update estimate request form field
    function save_estimate_form_field() {
        $this->access_only_allowed_members();


        $id = $this->input->post('id');

        $validate = array(
            "id" => "numeric",
            "title" => "required",
            "estimate_form_id" => "required"
        );

        //field type is required when inserting
        if (!$id) {
            $validate["field_type"] = "required";
        }

        validate_submitted_data($validate);


        $related_to = "estimate_form-" . $this->input->post('estimate_form_id');

        $data = array(
            "title" => $this->input->post('title'),
            "placeholder" => $this->input->post('placeholder'),
            "required" => $this->input->post('required') ? 1 : 0,
            "related_to" => $related_to,
            "options" => $this->input->post('options') ? $this->input->post('options') : ""
        );

        if (!$id) {
            $data["field_type"] = $this->input->post('field_type');
        }


        if (!$id) {
            //get sort value
            $max_sort_value = $this->Custom_fields_model->get_max_sort_value($related_to);
            $data["sort"] = $max_sort_value * 1 + 1; //increase sort value
        }

        $save_id = $this->Custom_fields_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_form_filed_row_data($save_id), 'newData' => $id ? false : true, 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //prepare data for datatable for estimate form's field list
    function estimate_form_filed_list_data($id = 0) {
        // accessable from client and team members 

        $options = array("related_to" => "estimate_form-" . $id);
        $list_data = $this->Custom_fields_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_form_field_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row of estimate form's field list
    private function _form_filed_row_data($id) {
        $options = array("id" => $id);
        $data = $this->Custom_fields_model->get_details($options)->row();
        return $this->_make_form_field_row($data);
    }

    //prepare a row of estimates form's field list
    private function _make_form_field_row($data) {

        $required = "";
        if ($data->required) {
            $required = "*";
        }

        $field = "<label data-id='$data->id' class='field-row'>$data->title $required</label>";
        $field .= "<div class='form-group'>" . $this->load->view("custom_fields/input_" . $data->field_type, array("field_info" => $data), true) . "</div>";

        //extract estimate id from related_to field. 2nd index should be the id
        $estimate_form_id = get_array_value(explode("-", $data->related_to), 1);

        return array(
            $field,
            $data->sort,
            modal_anchor(get_uri("estimate_requests/estimate_form_field_modal_form/" . $estimate_form_id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_form'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_estimate_form'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("estimate_requests/estimate_form_field_delete"), "data-action" => "delete"))
        );
    }

    //update the sort value for the fields
    function update_form_field_sort_values($id = 0) {
        $this->access_only_allowed_members();

        $sort_values = $this->input->post("sort_values");
        if ($sort_values) {

            //extract the values from the comma separated string
            $sort_array = explode(",", $sort_values);


            //update the value in db
            foreach ($sort_array as $value) {
                $sort_item = explode("-", $value); //extract id and sort value

                $id = get_array_value($sort_item, 0);
                $sort = get_array_value($sort_item, 1);

                $data = array("sort" => $sort);
                $this->Custom_fields_model->save($data, $id);
            }
        }
    }

    //delete/undo estimate request form field
    function estimate_form_field_delete() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        if ($this->input->post('undo')) {
            if ($this->Custom_fields_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_form_filed_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Custom_fields_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    //show a modal to choose a from for request an estimate from client side

    function request_an_estimate_modal_form() {
        $this->access_only_clients();

        $view_data["estimate_forms"] = $this->Estimate_forms_model->get_all_where(array("status" => "active", "deleted" => 0))->result();
        $this->load->view("estimate_requests/request_an_estimate_modal_form", $view_data);
    }

    //view estimate request form from client side
    function submit_estimate_request_form($id = 0) {
        $this->access_only_clients();

        $model_info = $this->Estimate_forms_model->get_one_where(array("id" => $id, "status" => "active", "deleted" => 0));

        if (get_setting("module_estimate_request") && $model_info->id) {
            $view_data['model_info'] = $model_info;
            $this->template->rander('estimate_requests/submit_estimate_request_form', $view_data);
        } else {
            show_404();
        }
    }

    //save estimate request from client
    function save_estimate_request() {

        $this->access_only_clients();

        $form_id = $this->input->post('form_id');

        validate_submitted_data(array(
            "form_id" => "required|numeric"
        ));


        $options = array("related_to" => "estimate_form-" . $form_id);
        $form_fields = $this->Custom_fields_model->get_details($options)->result();

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "estimate");

        $request_data = array(
            "estimate_form_id" => $form_id,
            "created_by" => $this->login_user->id,
            "created_at" => get_current_utc_time(),
            "client_id" => $this->login_user->client_id,
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

            log_notification("estimate_request_received", array("estimate_request_id" => $save_id));

            $this->session->set_flashdata("success_message", lang("estimate_submission_message"));

            echo json_encode(array("success" => true, 'message' => lang('estimate_submission_message'), 'estimate_id' => $save_id));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
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