<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leaves extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_team_members();

        $this->init_permission_checker("leave");
    }

    //only admin or assigend members can access/manage other member's leave
    //none admin users who has limited permission to manage other members leaves, can't manage his/her own leaves
    protected function access_only_allowed_members($user_id = 0) {
        if ($this->access_type !== "all") {
            if ($user_id === $this->login_user->id || !array_search($user_id, $this->allowed_members)) {
                redirect("forbidden");
            }
        }
    }

    protected function can_delete_leave_application() {
        if ($this->login_user->is_admin || get_array_value($this->login_user->permissions, "can_delete_leave_application") == "1") {
            return true;
        }
    }

    function index() {
        $this->check_module_availability("module_leave");
        $this->template->rander("leaves/index");
    }

    //load assign leave modal 

    function assign_leave_modal_form($applicant_id = 0) {

        if ($applicant_id) {
            $view_data['team_members_info'] = $this->Users_model->get_one($applicant_id);
        } else {

            //show all members list to only admin and other members who has permission to manage all member's leave
            //show only specific members list who has limited access
            if ($this->access_type === "all") {
                $where = array("user_type" => "staff");
            } else {
                $where = array("user_type" => "staff", "id !=" => $this->login_user->id, "where_in" => array("id" => $this->allowed_members));
            }
            $view_data['team_members_dropdown'] = array("" => "-") + $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", $where);
        }

        $view_data['leave_types_dropdown'] = array("" => "-") + $this->Leave_types_model->get_dropdown_list(array("title"), "id", array("status" => "active"));
        $view_data['form_type'] = "assign_leave";
        $this->load->view('leaves/modal_form', $view_data);
    }

    //all team members can apply for leave
    function apply_leave_modal_form() {
        $view_data['leave_types_dropdown'] = array("" => "-") + $this->Leave_types_model->get_dropdown_list(array("title"), "id", array("status" => "active"));
        $view_data['form_type'] = "apply_leave";
        $this->load->view('leaves/modal_form', $view_data);
    }

    // save: assign leave 
    function assign_leave() {
        $leave_data = $this->_prepare_leave_form_data();
        $applicant_id = $this->input->post('applicant_id');
        $leave_data['applicant_id'] = $applicant_id;
        $leave_data['created_by'] = $this->login_user->id;
        $leave_data['checked_by'] = $this->login_user->id;
        $leave_data['checked_at'] = $leave_data['created_at'];
        $leave_data['status'] = "approved";

        //hasn't full access? allow to update only specific member's record, excluding loged in user's own record
        $this->access_only_allowed_members($leave_data['applicant_id']);

        $save_id = $this->Leave_applications_model->save($leave_data);
        if ($save_id) {
            log_notification("leave_assigned", array("leave_id" => $save_id, "to_user_id" => $applicant_id));
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* save: apply leave */

    function apply_leave() {
        $leave_data = $this->_prepare_leave_form_data();
        $leave_data['applicant_id'] = $this->login_user->id;
        $leave_data['created_by'] = 0;
        $leave_data['checked_at'] = "0000:00:00";
        $leave_data['status'] = "pending";

        $leave_data = clean_data($leave_data);

        $save_id = $this->Leave_applications_model->save($leave_data);
        if ($save_id) {
            log_notification("leave_application_submitted", array("leave_id" => $save_id));
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* prepare common data for a leave application both for apply a leave or assign a leave */

    private function _prepare_leave_form_data() {

        validate_submitted_data(array(
            "leave_type_id" => "required|numeric",
            "reason" => "required"
        ));

        $duration = $this->input->post('duration');
        $hours_per_day = 8;
        $hours = 0;
        $days = 0;

        if ($duration === "multiple_days") {

            validate_submitted_data(array(
                "start_date" => "required",
                "end_date" => "required"
            ));

            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');

            //calculate total days
            $d_start = new DateTime($start_date);
            $d_end = new DateTime($end_date);
            $d_diff = $d_start->diff($d_end);

            $days = $d_diff->days + 1;
            $hours = $days * $hours_per_day;
        } else if ($duration === "hours") {

            validate_submitted_data(array(
                "hour_date" => "required"
            ));

            $start_date = $this->input->post('hour_date');
            $end_date = $start_date;
            $hours = $this->input->post('hours');
            $days = $hours / $hours_per_day;
        } else {

            validate_submitted_data(array(
                "single_date" => "required"
            ));

            $start_date = $this->input->post('single_date');
            $end_date = $start_date;
            $hours = $hours_per_day;
            $days = 1;
        }

        $now = get_current_utc_time();
        $leave_data = array(
            "leave_type_id" => $this->input->post('leave_type_id'),
            "start_date" => $start_date,
            "end_date" => $end_date,
            "reason" => $this->input->post('reason'),
            "created_by" => $this->login_user->id,
            "created_at" => $now,
            "total_hours" => $hours,
            "total_days" => $days
        );

        return $leave_data;
    }

    // load pending approval tab
    function pending_approval() {
        $this->load->view("leaves/pending_approval");
    }

    // load all applications tab 
    function all_applications() {
        $this->load->view("leaves/all_applications");
    }

    // load leave summary tab
    function summary() {
        $view_data['team_members_dropdown'] = json_encode($this->_get_members_dropdown_list_for_filter());
        $view_data['leave_types_dropdown'] = json_encode($this->_get_leave_types_dropdown_list_for_filter());
        $this->load->view("leaves/summary", $view_data);
    }

    // list of pending leave application. prepared for datatable
    function pending_approval_list_data() {
        $options = array("status" => "pending", "access_type" => $this->access_type, "allowed_members" => $this->allowed_members);
        $list_data = $this->Leave_applications_model->get_list($options)->result();

        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    // list of all leave application. prepared for datatable 
    function all_application_list_data() {

        validate_submitted_data(array(
            "applicant_id" => "numeric"
        ));


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $applicant_id = $this->input->post('applicant_id');

        $options = array("start_date" => $start_date, "end_date" => $end_date, "applicant_id" => $applicant_id, "login_user_id" => $this->login_user->id, "access_type" => $this->access_type, "allowed_members" => $this->allowed_members);
        $list_data = $this->Leave_applications_model->get_list($options)->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    // list of leave summary. prepared for datatable
    function summary_list_data() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $applicant_id = $this->input->post('applicant_id');
        $leave_type_id = $this->input->post('leave_type_id');

        $options = array("start_date" => $start_date, "end_date" => $end_date, "access_type" => $this->access_type, "allowed_members" => $this->allowed_members, "applicant_id" => $applicant_id, "leave_type_id" => $leave_type_id);
        $list_data = $this->Leave_applications_model->Leave_applications_model->get_summary($options)->result();


        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row_for_summary($data);
        }
        echo json_encode(array("data" => $result));
    }

    // reaturn a row of leave application list table
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Leave_applications_model->get_list($options)->row();
        return $this->_make_row($data);
    }

    // prepare a row of leave application list table
    private function _make_row($data) {
        $meta_info = $this->_prepare_leave_info($data);
        $option_icon = "fa-info";
        if ($data->status === "pending") {
            $option_icon = "fa-bolt";
        }

        $actions = modal_anchor(get_uri("leaves/application_details"), "<i class='fa $option_icon'></i>", array("class" => "edit", "title" => lang('application_details'), "data-post-id" => $data->id));

        //checking the user permissiton to show/hide reject and approve button
        $can_manage_application = false;
        if ($this->access_type === "all") {
            $can_manage_application = true;
        } else if (array_search($data->applicant_id, $this->allowed_members) && $data->applicant_id !== $this->login_user->id) {
            $can_manage_application = true;
        }

        if ($this->can_delete_leave_application() && $can_manage_application) {
            $actions .= js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("leaves/delete"), "data-action" => "delete-confirmation"));
        }

        return array(
            get_team_member_profile_link($data->applicant_id, $meta_info->applicant_meta),
            $meta_info->leave_type_meta,
            $meta_info->date_meta,
            $meta_info->duration_meta,
            $meta_info->status_meta,
            $actions
        );
    }

    // prepare a row of leave application list table
    private function _make_row_for_summary($data) {
        $meta_info = $this->_prepare_leave_info($data);

        return array(
            get_team_member_profile_link($data->applicant_id, $meta_info->applicant_meta),
            $meta_info->leave_type_meta,
            $meta_info->duration_meta
        );
    }

    //return required style/format for a application
    private function _prepare_leave_info($data) {
        $image_url = get_avatar($data->applicant_avatar);
        $data->applicant_meta = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $data->applicant_name;

        if (isset($data->status)) {
            if ($data->status === "pending") {
                $status_class = "label-warning";
            } else if ($data->status === "approved") {
                $status_class = "label-success";
            } else if ($data->status === "rejected") {
                $status_class = "label-danger";
            } else {
                $status_class = "label-default";
            }
            $data->status_meta = "<span class='label $status_class'>" . lang($data->status) . "</span>";
        }

        if (isset($data->start_date)) {
            $date = format_to_date($data->start_date, FALSE);
            if ($data->start_date != $data->end_date) {
                $date = sprintf(lang('start_date_to_end_date_format'), format_to_date($data->start_date, FALSE), format_to_date($data->end_date, FALSE));
            }
            $data->date_meta = $date;
        }
        if ($data->total_days > 1) {
            $duration = $data->total_days . " " . lang("days");
        } else {
            $duration = $data->total_days . " " . lang("day");
        }

        if ($data->total_hours > 1) {
            $duration = $duration . " (" . $data->total_hours . " " . lang("hours") . ")";
        } else {
            $duration = $duration . " (" . $data->total_hours . " " . lang("hour") . ")";
        }
        $data->duration_meta = $duration;
        $data->leave_type_meta = "<span style='background-color:" . $data->leave_type_color . "' class='color-tag pull-left'></span>" . $data->leave_type_title;
        return $data;
    }

    // reaturn a row of leave application list table
    function application_details() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $applicaiton_id = $this->input->post('id');
        $info = $this->Leave_applications_model->get_details_info($applicaiton_id);
        if (!$info) {
            show_404();
        }


        //checking the user permissiton to show/hide reject and approve button
        $can_manage_application = false;
        if ($this->access_type === "all") {
            $can_manage_application = true;
        } else if (array_search($info->applicant_id, $this->allowed_members) && $info->applicant_id !== $this->login_user->id) {
            $can_manage_application = true;
        }
        $view_data['show_approve_reject'] = $can_manage_application;

        //has permission to manage the appliation? or is it own application?
        if (!$can_manage_application && $info->applicant_id !== $this->login_user->id) {
            redirect("forbidden");
        }

        $view_data['leave_info'] = $this->_prepare_leave_info($info);
        $this->load->view("leaves/application_details", $view_data);
    }

    //update leave status
    function update_status() {

        validate_submitted_data(array(
            "id" => "required|numeric",
            "status" => "required"
        ));

        $applicaiton_id = $this->input->post('id');
        $status = $this->input->post('status');
        $now = get_current_utc_time();

        $leave_data = array(
            "checked_by" => $this->login_user->id,
            "checked_at" => $now,
            "status" => $status
        );

        //only allow to updte the status = accept or reject for admin or specefic user
        //otherwise user can cancel only his/her own application
        $applicatoin_info = $this->Leave_applications_model->get_one($applicaiton_id);

        if ($status === "approved" || $status === "rejected") {
            $this->access_only_allowed_members($applicatoin_info->applicant_id);
        } else if ($status === "canceled" && $applicatoin_info->applicant_id != $this->login_user->id) {
            //any user can't cancel other user's leave application
            redirect("forbidden");
        }

        //user can update only the applications where status = pending
        if ($applicatoin_info->status != "pending" || !($status === "approved" || $status === "rejected" || $status === "canceled")) {
            redirect("forbidden");
        }

        $save_id = $this->Leave_applications_model->save($leave_data, $applicaiton_id);
        if ($save_id) {

            $notification_options = array("leave_id" => $applicaiton_id, "to_user_id" => $applicatoin_info->applicant_id);

            if ($status == "approved") {
                log_notification("leave_approved", $notification_options);
            } else if ($status == "rejected") {
                log_notification("leave_rejected", $notification_options);
            } else if ($status == "canceled") {
                log_notification("leave_canceled", $notification_options);
            }

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    //    delete a leave application

    function delete() {

        $id = $this->input->post('id');

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        if (!$this->can_delete_leave_application()) {
            redirect("forbidden");
        }

        $applicatoin_info = $this->Leave_applications_model->get_one($id);
        $this->access_only_allowed_members($applicatoin_info->applicant_id);


        if ($this->Leave_applications_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    //view leave list of login user
    function leave_info() {
        $this->check_module_availability("module_leave");

        $view_data['applicant_id'] = $this->login_user->id;
        if ($this->input->is_ajax_request()) {
            $this->load->view("team_members/leave_info", $view_data);
        } else {
            $view_data['page_type'] = "full";
            $this->template->rander("team_members/leave_info", $view_data);
        }
    }

    //summary dropdown list of team members

    private function _get_members_dropdown_list_for_filter() {

        if ($this->access_type === "all") {
            $where = array("user_type" => "staff");
        } else {
            if (!count($this->allowed_members)) {
                $where = array("user_type" => "nothing");
            } else {
                $allowed_members = $this->allowed_members;
                $allowed_members[] = $this->login_user->id;

                $where = array("user_type" => "staff", "where_in" => array("id" => $allowed_members));
            }
        }

        $members = $this->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", $where);

        $members_dropdown = array(array("id" => "", "text" => "- " . lang("team_member") . " -"));
        foreach ($members as $id => $name) {
            $members_dropdown[] = array("id" => $id, "text" => $name);
        }
        return $members_dropdown;
    }

    //summary dropdown list of leave type 

    private function _get_leave_types_dropdown_list_for_filter() {

        $leave_type = $this->Leave_types_model->get_dropdown_list(array("title"), "id", array("status" => "active"));

        $leave_type_dropdown = array(array("id" => "", "text" => "- " . lang("leave_type") . " -"));
        foreach ($leave_type as $id => $name) {
            $leave_type_dropdown[] = array("id" => $id, "text" => $name);
        }
        return $leave_type_dropdown;
    }

}

/* End of file leaves.php */
    /* Location: ./application/controllers/leaves.php */    