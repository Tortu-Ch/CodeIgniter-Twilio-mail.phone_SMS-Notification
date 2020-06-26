<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notes extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_team_members();
    }

    protected function validate_access_to_note($note_info) {
        if ($note_info->client_id) {
            //this is a client's note. check client access permission
            $access_info = $this->get_access_info("client");
            if ($access_info->access_type != "all") {
                redirect("forbidden");
            }
        } else if ($note_info->user_id) {
            //this is a user's note. check user's access permission.
            redirect("forbidden");
        } else {
            //this is a private note. only avaialble to creator
            if ($this->login_user->id !== $note_info->created_by) {
                redirect("forbidden");
            }
        }
    }

    //load note list view
    function index() {
        $this->check_module_availability("module_note");

        $this->template->rander("notes/index");
    }

    function modal_form() {
        $view_data['model_info'] = $this->Notes_model->get_one($this->input->post('id'));
        $view_data['project_id'] = $this->input->post('project_id') ? $this->input->post('project_id') : $view_data['model_info']->project_id;
        $view_data['client_id'] = $this->input->post('client_id') ? $this->input->post('client_id') : $view_data['model_info']->client_id;
        $view_data['user_id'] = $this->input->post('user_id') ? $this->input->post('user_id') : $view_data['model_info']->user_id;
        $labels = explode(",", $this->Notes_model->get_label_suggestions($this->login_user->id));

        //check permission for saved note
        if ($view_data['model_info']->id) {
            $this->validate_access_to_note($view_data['model_info']);
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
        $this->load->view('notes/modal_form', $view_data);
    }

    function save() {
        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required",
            "project_id" => "numeric",
            "client_id" => "numeric",
            "user_id" => "numeric"
        ));

        $id = $this->input->post('id');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "note");
        $new_files = unserialize($files_data);

        $data = array(
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "created_by" => $this->login_user->id,
            "labels" => $this->input->post('labels'),
            "project_id" => $this->input->post('project_id') ? $this->input->post('project_id') : 0,
            "client_id" => $this->input->post('client_id') ? $this->input->post('client_id') : 0,
            "user_id" => $this->input->post('user_id') ? $this->input->post('user_id') : 0
        );

        if ($id) {
            $note_info = $this->Notes_model->get_one($id);
            $timeline_file_path = get_setting("timeline_file_path");

            $new_files = update_saved_files($timeline_file_path, $note_info->files, $new_files);
        }

        $data["files"] = serialize($new_files);

        if ($id) {
            //saving existing note. check permission
            $note_info = $this->Notes_model->get_one($id);

            $this->validate_access_to_note($note_info);
        } else {
            $data['created_at'] = get_current_utc_time();
        }

        $data = clean_data($data);

        $save_id = $this->Notes_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function delete() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');

        $note_info = $this->Notes_model->get_one($id);
        $this->validate_access_to_note($note_info);

        if ($this->Notes_model->delete($id)) {
            //delete the files
            $file_path = get_setting("timeline_file_path");
            if ($note_info->files) {
                $files = unserialize($note_info->files);

                foreach ($files as $file) {
                    $source_path = $file_path . get_array_value($file, "file_name");
                    delete_file_from_directory($source_path);
                }
            }

            echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    function list_data($type = "", $id = 0) {
        $options = array();

        if ($type == "project" && $id) {
            $options["created_by"] = $this->login_user->id;
            $options["project_id"] = $id;
        } else if ($type == "client" && $id) {
            $options["client_id"] = $id;
        } else if ($type == "user" && $id) {
            $options["user_id"] = $id;
        } else {
            $options["created_by"] = $this->login_user->id;
            $options["my_notes"] = true;
        }


        $list_data = $this->Notes_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Notes_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    private function _make_row($data) {
        $title = modal_anchor(get_uri("notes/view/" . $data->id), $data->title, array("class" => "edit", "title" => lang('note'), "data-post-id" => $data->id));
        $note_labels = "";
        if ($data->labels) {
            $labels = explode(",", $data->labels);
            foreach ($labels as $label) {
                $note_labels .= "<span class='label label-info clickable'>" . $label . "</span> ";
            }
            $title .= "<br />" . $note_labels;
        }

        $files_link = "";
        if ($data->files) {
            $files = unserialize($data->files);
            if (count($files)) {
                foreach ($files as $file) {
                    $file_name = get_array_value($file, "file_name");
                    $link = " fa fa-" . get_file_icon(strtolower(pathinfo($file_name, PATHINFO_EXTENSION)));
                    $files_link .= js_anchor(" ", array('title' => "", "data-toggle" => "app-modal", "data-sidebar" => "0", "class" => "pull-left font-22 mr10 $link", "title" => remove_file_prefix($file_name), "data-url" => get_uri("notes/file_preview/" . $file_name)));
                }
            }
        }


        return array(
            $data->created_at,
            format_to_relative_time($data->created_at),
            $title,
            $files_link,
            modal_anchor(get_uri("notes/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_note'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_note'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("notes/delete"), "data-action" => "delete-confirmation"))
        );
    }

    function view() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $model_info = $this->Notes_model->get_one($this->input->post('id'));

        $this->validate_access_to_note($model_info);

        $view_data['model_info'] = $model_info;
        $this->load->view('notes/view', $view_data);
    }

    function file_preview($file_name = "") {
        if ($file_name) {
            $view_data["file_url"] = get_file_uri(get_setting("timeline_file_path") . $file_name);
            $view_data["is_image_file"] = is_image_file($file_name);
            $view_data["is_google_preview_available"] = is_google_preview_available($file_name);

            $this->load->view("notes/file_preview", $view_data);
        } else {
            show_404();
        }
    }

    /* upload a file */

    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file for notes */

    function validate_notes_file() {
        return validate_post_file($this->input->post("file_name"));
    }

}

/* End of file notes.php */
/* Location: ./application/controllers/notes.php */