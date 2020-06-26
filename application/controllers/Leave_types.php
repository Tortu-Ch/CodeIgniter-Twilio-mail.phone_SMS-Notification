<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_types extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_admin();
    }

    //load leave type list view
    function index() {
        $this->template->rander("leave_types/index");
    }

    //load leave type add/edit form
    function modal_form() {
        $view_data['model_info'] = $this->Leave_types_model->get_one($this->input->post('id'));
        $this->load->view('leave_types/modal_form', $view_data);
    }

    //save leave type
    function save() {

        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->input->post('id');
        $data = array(
            "title" => $this->input->post('title'),
            "status" => $this->input->post('status'),
            "description" => $this->input->post('description'),
            "color" => $this->input->post('color')
        );
        $save_id = $this->Leave_types_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //delete/undo a leve type
    function delete() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Leave_types_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Leave_types_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    //prepare leave types list data for datatable
    function list_data() {
        $list_data = $this->Leave_types_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row of leave types row
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Leave_types_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    //make a row of leave types row
    private function _make_row($data) {
        return array(
            "<span style='background-color:" . $data->color . "' class='color-tag pull-left'></span>" . $data->title,
            $data->description ? $data->description : "-",
            lang($data->status),
            modal_anchor(get_uri("leave_types/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_leave_type'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_leave_type'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("leave_types/delete"), "data-action" => "delete"))
        );
    }

}

/* End of file leave_types.php */
/* Location: ./application/controllers/leave_types.php */