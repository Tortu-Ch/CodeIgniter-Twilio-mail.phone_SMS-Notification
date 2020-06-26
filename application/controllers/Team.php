<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Team extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->access_only_super_and_admin_and_manager();
    }

    function index() {
        $this->template->rander("team/index");
    }

    /* load team add/edit modal */

    function modal_form() {
        validate_submitted_data(array(
            "id" => "numeric"
        ));
        
        $team_members = $this->Users_model->get_all_where(array("deleted" => 0, "user_type" => "staff"))->result();
        $members_dropdown = array();

        foreach ($team_members as $team_member) {
            $members_dropdown[] = array("id" => $team_member->id, "text" => $team_member->first_name . " " . $team_member->last_name);
        }

        $view_data['members_dropdown'] = json_encode($members_dropdown);
        $view_data['model_info'] = $this->Team_model->get_one($this->input->post('id'));
        $this->load->view('team/modal_form', $view_data);
    }

    /* add/edit a team */

    function save() {

        validate_submitted_data(array(
            "id" => "numeric",
            "title" => "required",
            "members" => "required"
        ));

        $id = $this->input->post('id');
        $data = array(
            "title" => $this->input->post('title'),
            "members" => $this->input->post('members')
        );

        $save_id = $this->Team_model->save($data, $id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* delete/undo a team */

    function delete() {
        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Team_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Team_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of team prepared for datatable */

    function list_data() {
        $list_data = $this->Team_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* reaturn a row of team list table */

    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Team_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    /* prepare a row of team list table */

    private function _make_row($data) {
        $total_members = "<span class='label label-light w100'><i class='fa fa-users'></i> " . count(explode(",", $data->members)) . "</span>";
        return array($data->title,
            modal_anchor(get_uri("team/members_list"), $total_members, array("title" => lang('team_members'), "data-post-members" => $data->members)),
            modal_anchor(get_uri("team/modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_team'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_team'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("team/delete"), "data-action" => "delete"))
        );
    }

    function members_list() {
        $view_data['team_members'] = $this->Users_model->get_team_members($this->input->post('members'))->result();
        $this->load->view('team/members_list', $view_data);
    }

}

/* End of file team.php */
/* Location: ./application/controllers/team.php */