<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Items extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_team_members();
    }

    protected function validate_access_to_items() {
        $access_invoice = $this->get_access_info("invoice");
        $access_estimate = $this->get_access_info("estimate");

        //don't show the items if invoice/estimate module is not enabled
        if(!(get_setting("module_invoice") == "1" || get_setting("module_estimate") == "1" )){
            redirect("forbidden");
        }
        
        if ($this->login_user->is_admin) {
            return true;
        } else if ($access_invoice->access_type === "all" || $access_estimate->access_type === "all") {
            return true;
        } else {
            redirect("forbidden");
        }
    }

    //load note list view
    function index() {
        $this->validate_access_to_items();

        $this->template->rander("items/index");
    }

    /* load item modal */

    function modal_form() {
        $this->validate_access_to_items();

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $view_data['model_info'] = $this->Items_model->get_one($this->input->post('id'));

        $this->load->view('items/modal_form', $view_data);
    }

    /* add or edit an item */

    function save() {
        $this->validate_access_to_items();

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $id = $this->input->post('id');

        $item_data = array(
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "unit_type" => $this->input->post('unit_type'),
            "rate" => unformat_currency($this->input->post('item_rate'))
        );

        $item_id = $this->Items_model->save($item_data, $id);
        if ($item_id) {
            $options = array("id" => $item_id);
            $item_info = $this->Items_model->get_details($options)->row();
            echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* delete or undo an item */

    function delete() {
        $this->validate_access_to_items();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Items_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Items_model->get_details($options)->row();
                echo json_encode(array("success" => true, "id" => $item_info->id, "data" => $this->_make_item_row($item_info), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Items_model->delete($id)) {
                $item_info = $this->Items_model->get_one($id);
                echo json_encode(array("success" => true, "id" => $item_info->id, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of items, prepared for datatable  */

    function list_data() {
        $this->validate_access_to_items();

        $list_data = $this->Items_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of item list table */

    private function _make_item_row($data) {
        $type = $data->unit_type ? $data->unit_type : "";

        return array(
            $data->title,
            nl2br($data->description),
            $type,
            $data->rate,
            modal_anchor(get_uri("items/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("items/delete"), "data-action" => "delete"))
        );
    }

}

/* End of file items.php */
/* Location: ./application/controllers/items.php */