<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announcements extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->init_permission_checker("announcement");
    }

    //show announcements list
    function index() {
        $this->check_module_availability("module_announcement");

        $view_data["show_add_button"] = true;
        if ($this->access_type !== "all") {
            $view_data["show_add_button"] = false;
        }
        $view_data["show_option"] = true;
        if($this->access_type !== "all"){
            $view_data["show_option"] = false;
        }
        $this->template->rander("announcements/index", $view_data);
    }

    //show add/edit announcement form
    function form($id = 0) {
        $this->access_only_allowed_members();

        $view_data['model_info'] = $this->Announcements_model->get_one($id);
        $view_data['share_with'] = $id ? explode(",", $view_data['model_info']->share_with) : array("all_members");
        $this->template->rander('announcements/modal_form', $view_data);
    }

    //show a specific announcement
    function view($id = "") {
        if ($id) {
            //show only the allowed announcement
            $options = array("id" => $id);

            $options = $this->_prepare_access_options($options);

            $announcement = $this->Announcements_model->get_details($options)->row();
            if ($announcement) {
                $view_data['announcement'] = $announcement;

                //mark the announcement as read for loged in user
                $this->Announcements_model->mark_as_read($id, $this->login_user->id);
                return $this->template->rander("announcements/view", $view_data);
            }
        }

        //not matched the requirement. show 404 page
        show_404();
    }

    private function _prepare_access_options($options) {
        if ($this->access_type !== "all") {
            if ($this->login_user->user_type === "staff") {
                $options["share_with"] = "all_members";
            } else if ($this->login_user->user_type === "client") {
                $options["share_with"] = "all_clients";
            } else {
                $options["share_with"] = "none";
            }
        }
        return $options;
    }

    //mark the announcement as read for loged in user
    function mark_as_read($id) {
        $this->Announcements_model->mark_as_read($id, $this->login_user->id);
    }

    //add/edit an announcement
    function save() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required",
            "start_date" => "required",
            "end_date" => "required"
        ));

        $id = $this->input->post('id');

        $target_path = get_setting("timeline_file_path");
        $files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "announcement");
        $new_files = unserialize($files_data);

        $data = array(
            "title" => $this->input->post('title'),
            "description" => decode_ajax_post_data($this->input->post('description')),
            "start_date" => $this->input->post('start_date'),
            "end_date" => $this->input->post('end_date'),
            "created_by" => $this->login_user->id,
            "created_at" => get_current_utc_time(),
            "share_with" => $this->input->post('share_with') ? implode(",", $this->input->post('share_with')) : ""
        );

        //is editing? update the files if required
        if ($id) {
            $expense_info = $this->Announcements_model->get_one($id);
            $timeline_file_path = get_setting("timeline_file_path");

            $new_files = update_saved_files($timeline_file_path, $expense_info->files, $new_files);
        }

        $data["files"] = serialize($new_files);


        if (!$id) {
            $data["read_by"] = 0; //set default value
        }


        $save_id = $this->Announcements_model->save($data, $id);


        //send log notification
        if (!$id) {
            if ($data["share_with"]) {
                log_notification("new_announcement_created", array("announcement_id" => $save_id));
            }
        }


        if ($save_id) {
            $this->session->set_flashdata("success_message", lang('record_saved'));
            redirect(get_uri("announcements/form/" . $save_id));
        } else {
            $this->session->set_flashdata("error_message", lang('error_occurred'));
            redirect(get_uri("announcements/form/"));
        }
    }

    // upload a file 
    function upload_file() {
        $this->access_only_allowed_members();

        upload_file_to_temp();
    }

    // check valid file for ticket 

    function validate_announcement_file() {
        return validate_post_file($this->input->post("file_name"));
    }

    // download files 
    function download_announcement_files($id = 0) {

        $options = array("id" => $id);
        $options = $this->_prepare_access_options($options);

        $info = $this->Announcements_model->get_details($options)->row();

        download_app_files(get_setting("timeline_file_path"), $info->files);
    }

    //delete/undo an announcement
    function delete() {
        $this->access_only_allowed_members();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Announcements_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Announcements_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    //perepare the list data for announcement list
    function list_data() {

        //show only the allowed announcements
        $options = array();
        if ($this->access_type !== "all") {
            if ($this->login_user->user_type === "staff") {
                $options["share_with"] = "all_members";
            } else if ($this->login_user->user_type === "client") {
                $options["share_with"] = "all_clients";
            } else {
                $options["share_with"] = "none";
            }
        }

        $list_data = $this->Announcements_model->get_details($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row of announcement list row
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Announcements_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    //make a row of announcement list
    private function _make_row($data) {
        $image_url = get_avatar($data->created_by_avatar);
        $user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span> $data->created_by_user";
        $option = "";
        if ($this->access_type === "all") {
            $option = anchor(get_uri("announcements/form/" . $data->id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_announcement')))
                    . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_announcement'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("announcements/delete"), "data-action" => "delete"));
        }
        return array(
            anchor(get_uri("announcements/view/" . $data->id), $data->title, array("class" => "", "title" => lang('view'))),
            get_team_member_profile_link($data->created_by, $user),
            $data->start_date,
            format_to_date($data->start_date, false),
            $data->end_date,
            format_to_date($data->end_date, false),
            $option
        );
    }

}

/* End of file announcements.php */
/* Location: ./application/controllers/announcements.php */