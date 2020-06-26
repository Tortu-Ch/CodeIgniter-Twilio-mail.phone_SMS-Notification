<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To process the notifications we'll use this.
 * This controller will be called via curl 
 * 
 * Purpose of this process is to reduce the processing time in main thread.
 * 
 */

class Notification_processor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('notifications');
    }

    //don't show anything here
    function index() {
        redirect("forbidden");
    }

    function create_notification() {

        ini_set('max_execution_time', 300); //300 seconds 
        //error_log(date('[Y-m-d H:i:s e] ') . " Process Notification: " . serialize($_POST) . PHP_EOL, 3, "error.log");
        //validate notification request

        $event = decode_id(get_array_value($_POST, "event"), "notification");

        if (!$event) {
            die("Access Denied!");
        }

        $notification_data = get_notification_config($event);

        if (!is_array($notification_data)) {
            die("Access Denied!!");
        }

        $user_id = get_array_value($_POST, "user_id");
        $activity_log_id = get_array_value($_POST, "activity_log_id");


        $options = array(
            "project_id" => get_array_value($_POST, "project_id"),
            "task_id" => get_array_value($_POST, "task_id"),
            "project_comment_id" => get_array_value($_POST, "project_comment_id"),
            "ticket_id" => get_array_value($_POST, "ticket_id"),
            "ticket_comment_id" => get_array_value($_POST, "ticket_comment_id"),
            "project_file_id" => get_array_value($_POST, "project_file_id"),
            "leave_id" => get_array_value($_POST, "leave_id"),
            "post_id" => get_array_value($_POST, "post_id"),
            "to_user_id" => get_array_value($_POST, "to_user_id"),
            "activity_log_id" => get_array_value($_POST, "activity_log_id"),
            "client_id" => get_array_value($_POST, "client_id"),
            "invoice_payment_id" => get_array_value($_POST, "invoice_payment_id"),
            "invoice_id" => get_array_value($_POST, "invoice_id"),
            "estimate_id" => get_array_value($_POST, "estimate_id"),
            "estimate_request_id" => get_array_value($_POST, "estimate_request_id"),
            "actual_message_id" => get_array_value($_POST, "actual_message_id"),
            "parent_message_id" => get_array_value($_POST, "parent_message_id"),
            "event_id" => get_array_value($_POST, "event_id"),
            "announcement_id" => get_array_value($_POST, "announcement_id")
        );


        //clasified the task modification parts
        if ($event == "project_task_updated") {
            $this->_clasified_task_modification($event, $options, $activity_log_id); //overwrite event and  options
        }

        //save reminder date
        $this->_save_reminder_date($event, $options);

        //error_log("announcement_id: " . $options["announcement_id"] . PHP_EOL, 3, "notification.txt");
        //error_log("announcement_share_with: " . $options["announcement_share_with"] . PHP_EOL, 3, "notification.txt");

        $this->Notifications_model->create_notification($event, $user_id, $options);
    }

    private function _clasified_task_modification(&$event, &$options, $activity_log_id = 0) {

        //find out what types of changes has made
        if ($activity_log_id) {
            $activity = $this->Activity_logs_model->get_one($activity_log_id);
            if ($activity && $activity->changes) {

                $changes = unserialize($activity->changes);


                //only chaged assigned_to field?
                if (is_array($changes) && count($changes) == 1 && get_array_value($changes, "assigned_to")) {
                    $event = "project_task_assigned";
                    $assigned_to = get_array_value($changes, "assigned_to");
                    $new_assigned_to = get_array_value($assigned_to, "to");

                    $options["to_user_id"] = $new_assigned_to;
                    $options["activity_log_id"] = ""; //remove activity log id
                }


                //only chaged status field? find out the change event
                if (is_array($changes) && count($changes) == 1 && get_array_value($changes, "status")) {

                    $status = get_array_value($changes, "status");
                    $new_status = get_array_value($status, "to");

                    if ($new_status == "1") {
                        $event = "project_task_reopened";
                    } else if ($new_status == "3") {
                        $event = "project_task_finished";
                    } else {
                        $event = "project_task_started";
                    }
                    $options["activity_log_id"] = ""; //remove activity log id
                }
            }
        }
    }

    //to prevent multiple reminder, we'll save the reminder date
    private function _save_reminder_date(&$event, &$options) {
        //save invoices reminder dates 
        $invoice_id = get_array_value($options, "invoice_id");
        if ($invoice_id) {
            $invoice_reminder_date = array();
            if ($event == "invoice_due_reminder_before_due_date" || $event == "invoice_overdue_reminder") {
                $invoice_reminder_date["due_reminder_date"] = get_my_local_time();
            }
            if ($event == "recurring_invoice_creation_reminder") {
                $invoice_reminder_date["recurring_reminder_date"] = get_my_local_time();
            }
            if (count($invoice_reminder_date)) {
                $this->Invoices_model->save($invoice_reminder_date, $invoice_id);
            }
        }
    }

}

/* End of file notifications.php */
/* Location: ./application/controllers/Notifications.php */