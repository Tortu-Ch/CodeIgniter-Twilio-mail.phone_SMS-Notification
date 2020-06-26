<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Todo extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    protected function validate_access($todo_info) {
        if ($this->login_user->id !== $todo_info->created_by) {
            redirect("forbidden");
        }
    }

    //load todo list view
    function index() {
        $this->check_module_availability("module_todo");

        $this->template->rander("todo/index");
    }

    function modal_form() {
        $view_data['model_info'] = $this->Todo_model->get_one($this->input->post('id'));

        $labels = explode(",", $this->Todo_model->get_label_suggestions($this->login_user->id));

        //check permission for saved todo list
        if ($view_data['model_info']->id) {
            $this->validate_access($view_data['model_info']);
        }

        $label_suggestions = array();
        foreach ($labels as $label) {
            if ($label && !in_array($label, $label_suggestions)) {
                $label_suggestions[] = $label;
            }
        }
        if (!count($label_suggestions)) {
            $label_suggestions = array("0" => "Important");
        }
        $view_data['label_suggestions'] = $label_suggestions;
        $this->load->view('todo/modal_form', $view_data);
    }

    function save() {
        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required"
        ));

        $id = $this->input->post('id');

        $data = array(
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description') ? $this->input->post('description') : "",
            "created_by" => $this->login_user->id,
            "labels" => $this->input->post('labels') ? $this->input->post('labels') : "",
            "start_date" => $this->input->post('start_date'),
        );

        $data = clean_data($data);
        
         //set null value after cleaning the data
        if (!$data["start_date"]) {
            $data["start_date"] = NULL;
        }
        
        if ($id) {
            //saving existing todo. check permission
            $todo_info = $this->Todo_model->get_one($id);

            $this->validate_access($todo_info);
        } else {
            $data['created_at'] = get_current_utc_time();
        }

        $save_id = $this->Todo_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* upadate a task status */

    function save_status() {

        validate_submitted_data(array(
            "id" => "numeric|required",
            "status" => "required"
        ));

        $this->access_only_team_members();
        $data = array(
            "status" => $this->input->post('status')
        );

        $save_id = $this->Todo_model->save($data, $this->input->post('id'));

        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, "message" => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, lang('error_occurred')));
        }
    }

    function delete() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        $todo_info = $this->Todo_model->get_one($id);
        $this->validate_access($todo_info);

        if ($this->input->post('undo')) {
            if ($this->Todo_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Todo_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    function list_data() {

        $status = $this->input->post('status') ? implode(",", $this->input->post('status')) : "";
        $options = array(
            "created_by" => $this->login_user->id,
            "status" => $status
        );

        $list_data = $this->Todo_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Todo_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    private function _make_row($data) {
        $title = modal_anchor(get_uri("todo/view/" . $data->id), $data->title, array("class" => "edit", "title" => lang('todo'), "data-post-id" => $data->id));
        $todo_labels = "";
        if ($data->labels) {
            $labels = explode(",", $data->labels);
            foreach ($labels as $label) {
                $todo_labels.="<span class='label label-info clickable'>" . $label . "</span> ";
            }
            $title.="<span class='pull-right'>" . $todo_labels . "</span>";
        }


        $status_class = "";
        $checkbox_class = "checkbox-blank";
        if ($data->status === "to_do") {
            $status_class = "b-warning";
        } else {
            $checkbox_class = "checkbox-checked";
            $status_class = "b-success";
        }

        $check_status = js_anchor("<span class='$checkbox_class'></span>", array('title' => "", "class" => "", "data-id" => $data->id, "data-value" => $data->status === "done" ? "to_do" : "done", "data-act" => "update-todo-status-checkbox"));

        $start_date_text = "";
        if (is_date_exists($data->start_date)) {
            $start_date_text = format_to_date($data->start_date, false);
            if (get_my_local_time("Y-m-d") > $data->start_date && $data->status != "done") {
                $start_date_text = "<span class='text-danger'>" . $start_date_text . "</span> ";
            } else if (get_my_local_time("Y-m-d") == $data->start_date && $data->status != "done") {
                $start_date_text = "<span class='text-warning'>" . $start_date_text . "</span> ";
            }
        }


        return array(
            $status_class,
            "<i class='hide'>" . $data->id . "</i>" . $check_status,
            $title,
            $data->start_date,
            $start_date_text,
            modal_anchor(get_uri("todo/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("todo/delete"), "data-action" => "delete"))
        );
    }

    function view() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $model_info = $this->Todo_model->get_one($this->input->post('id'));

        $this->validate_access($model_info);

        $view_data['model_info'] = $model_info;
        $this->load->view('todo/view', $view_data);
    }

}

/* End of file todo.php */
/* Location: ./application/controllers/todo.php */