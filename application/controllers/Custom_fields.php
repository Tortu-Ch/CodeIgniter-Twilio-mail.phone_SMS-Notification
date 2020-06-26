<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Custom_fields extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_super_and_admin_and_manager();
    }

    function index() {
        redirect("custom_fields/view");
    }

    function view($tab = "client") {
        $view_data["tab"] = $tab;
        $this->template->rander("custom_fields/settings/index", $view_data);
    }

    //add/edit fields
    function modal_form() {

        $model_info = $this->Custom_fields_model->get_one($this->input->post('id'));
        $related_to = $model_info->related_to;
        if (!$related_to) {
            $related_to = $this->input->post("related_to");
        }
        $view_data['model_info'] = $model_info;
        $view_data['related_to'] = $related_to;

        $this->load->view('custom_fields/settings/modal_form', $view_data);
    }

    //save/update custom field
    function save() {

        $id = $this->input->post('id');

        $validate = array(
            "id" => "numeric",
            "title" => "required",
            "related_to" => "required"
        );

        //field type is required when inserting
        if (!$id) {
            $validate["field_type"] = "required";
        }

        validate_submitted_data($validate);

        $related_to = $this->input->post('related_to');

        $data = array(
            "title" => $this->input->post('title'),
            "placeholder" => $this->input->post('placeholder'),
            "required" => $this->input->post('required') ? 1 : 0,
            "show_in_table" => $this->input->post('show_in_table') ? 1 : 0,
            "show_in_invoice" => $this->input->post('show_in_invoice') ? 1 : 0,
            "show_in_estimate" => $this->input->post('show_in_estimate') ? 1 : 0,
            "visible_to_admins_only" => $this->input->post('visible_to_admins_only') ? 1 : 0,
            "hide_from_clients" => $this->input->post('hide_from_clients') ? 1 : 0,
            "related_to" => $this->input->post('related_to'),
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
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'newData' => $id ? false : true, 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //prepare data for datatable for fields list
    function list_data($related_to) {
        // accessable from client and team members 

        $options = array("related_to" => $related_to);
        $list_data = $this->Custom_fields_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_field_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row of fields list
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Custom_fields_model->get_details($options)->row();
        return $this->_make_field_row($data);
    }

    //prepare a row of fields list
    private function _make_field_row($data) {

        $required = "";
        if ($data->required) {
            $required = "*";
        }

        $field = "<label data-id='$data->id' class='field-row'>$data->title $required</label>";
        $field .= "<div class='form-group'>" . $this->load->view("custom_fields/input_" . $data->field_type, array("field_info" => $data), true) . "</div>";



        return array(
            $field,
            $data->sort,
            modal_anchor(get_uri("custom_fields/modal_form/"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_field'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_field'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("custom_fields/delete"), "data-action" => "delete"))
        );
    }

    //update the sort value for the fields
    function update_field_sort_values($id = 0) {

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

    //delete/undo field
    function delete() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        if ($this->input->post('undo')) {
            if ($this->Custom_fields_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
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

    function contacts() {
        $this->load->view('custom_fields/settings/contacts');
    }

    function projects() {
        $this->load->view('custom_fields/settings/projects');
    }

    function tasks() {
        $this->load->view('custom_fields/settings/tasks');
    }

    function team_members() {
        $this->load->view('custom_fields/settings/team_members');
    }

    function tickets() {
        $this->load->view('custom_fields/settings/tickets');
    }

    function invoices() {
        $this->load->view('custom_fields/settings/invoices');
    }

    function events() {
        $this->load->view('custom_fields/settings/events');
    }

    function expenses() {
        $this->load->view('custom_fields/settings/expenses');
    }

    function estimates() {
        $this->load->view('custom_fields/settings/estimates');
    }

}

/* End of file custom_fields.php */
/* Location: ./application/controllers/custom_fields.php */