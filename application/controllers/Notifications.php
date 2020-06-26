<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notifications extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('notifications');
    }

    //load notifications view
    function index() {
        $view_data = $this->_prepare_notification_list();
        $this->template->rander("notifications/index", $view_data);

        if(isset($_GET['debug']) && $_GET['debug'] == '1'){
            echo '<br>';
            print_r($view_data);
            echo '<br>';
        }

    }

    function load_more($offset = 0) {
        $view_data = $this->_prepare_notification_list($offset);
        $this->load->view("notifications/list_data", $view_data);
    }

    function count_notifications() {
        $notifiations = $this->Notifications_model->count_notifications($this->login_user->id, $this->login_user->notification_checked_at);
        echo json_encode(array("success" => true, 'total_notifications' => $notifiations));
    }

    function get_notifications() {
        $view_data = $this->_prepare_notification_list();
        $view_data["result_remaining"] = false; //don't show load more option in notification popop
        echo json_encode(array("success" => true, 'notification_list' => $this->load->view("notifications/list", $view_data, true)));
    }

    function update_notification_checking_status() {
        $now = get_current_utc_time();
        $data = array("notification_checked_at" => $now);
        $this->Users_model->save($data, $this->login_user->id);
    }

    function set_notification_status_as_read($notification_id = 0) {
        if ($notification_id) {
            $this->Notifications_model->set_notification_status_as_read($notification_id, $this->login_user->id);
        }
    }

    private function _prepare_notification_list($offset = 0) {
        $notifiations = $this->Notifications_model->get_notifications($this->login_user->id, $offset);
        $view_data['notifications'] = $notifiations->result;
        $view_data['found_rows'] = $notifiations->found_rows;
        $next_page_offset = $offset + 20;
        $view_data['next_page_offset'] = $next_page_offset;
        $view_data['result_remaining'] = $notifiations->found_rows > $next_page_offset;
        return $view_data;
    }

}

/* End of file notifications.php */
/* Location: ./application/controllers/Notifications.php */