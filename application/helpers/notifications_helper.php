<?php

/*
 * Define who are allowed to receive notifications
 * Using following terms:
 * team_members, team,
 * project_members, client_primary_contact, client_all_contacts, task_assignee, task_collaborators, comment_creator, leave_applicant, ticket_creator, ticket_assignee
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once './twilio/twilio-php-master/Twilio/autoload.php'; // Loads the library
use Twilio\Rest\Client;

if (!function_exists('get_notification_config')) {

    function get_notification_config($event = "", $key = "", $info_options = array()) {

        $task_link = function($options) {

            $url = "";
            $ajax_url = "";
            $id = "";

            if (isset($options->task_id)) {
                $ajax_url = get_uri("projects/task_view");
                $id = $options->task_id;
            }

            if (isset($options->project_id)) {
                $url = get_uri("projects/view/" . $options->project_id . "/tasks?task=" . $id);
            }



            return array("url" => $url, "ajax_modal_url" => $ajax_url, "id" => $id);
        };


        $project_link = function($options) {
            $url = "";
            if (isset($options->project_id)) {
                $url = get_uri("projects/view/" . $options->project_id);

                if ($options->event == "project_customer_feedback_added" || $options->event == "project_customer_feedback_replied") {
                    $url .= "/customer_feedback";
                } else if ($options->event == "project_comment_added" || $options->event == "project_comment_replied") {
                    $url .= "/comment";
                }
            }

            return array("url" => $url);
        };


        $project_file_link = function($options) {

            $url = "";
            $app_modal_url = "";
            $id = "";

            if (isset($options->project_id)) {
                $url = get_uri("projects/view/" . $options->project_id . "/files");
            }

            if (isset($options->project_file_id)) {
                $app_modal_url = get_uri("projects/view_file/" . $options->project_file_id);
                $id = $options->project_file_id;
            }

            return array("url" => $url, "app_modal_url" => $app_modal_url, "id" => $id);
        };


        $client_link = function($options) {
            $url = "";
            if (isset($options->client_id)) {
                $url = get_uri("clients/view/" . $options->client_id);
            }

            return array("url" => $url);
        };

        $leave_link = function($options) {
            $url = "";
            $ajax_url = "";
            $id = "";

            if (isset($options->leave_id)) {
                $url = get_uri("dashboard");
                $ajax_url = get_uri("leaves/application_details");
                $id = $options->leave_id;
            }

            return array("url" => $url, "ajax_modal_url" => $ajax_url, "id" => $id);
        };


        $ticket_link = function($options) {
            $url = "";
            if (isset($options->ticket_id)) {
                $url = get_uri("tickets/view/" . $options->ticket_id);
            }

            return array("url" => $url);
        };


        $invoice_link = function($options) {
            $url = "";
            if (isset($options->invoice_id)) {
                $url = get_uri("invoices/preview/" . $options->invoice_id);
            }

            return array("url" => $url);
        };

        $estimate_link = function($options) {
            $url = "";
            if (isset($options->estimate_id)) {
                $url = get_uri("estimates/preview/" . $options->estimate_id . "/1");
            }

            return array("url" => $url);
        };

        $estimate_request_link = function($options) {
            $url = "";
            if (isset($options->estimate_request_id)) {
                $url = get_uri("estimate_requests/view_estimate_request/" . $options->estimate_request_id);
            }

            return array("url" => $url);
        };

        $message_link = function($options) {
            $url = "";
            if (isset($options->actual_message_id)) {
                $message_id = isset($options->parent_message_id) && $options->parent_message_id ? $options->parent_message_id : $options->actual_message_id;
                $url = get_uri("messages/inbox/" . $message_id);
            }

            return array("url" => $url);
        };

        $announcement_link = function($options) {
            $url = "";
            if (isset($options->announcement_id)) {
                $url = get_uri("announcements/view/" . $options->announcement_id);
            }

            return array("url" => $url);
        };

        $event_link = function($options) {
            $url = "";
            $id = "";

            if (isset($options->event_id)) {
                $id = encode_id($options->event_id, "event_id");
                $url = get_uri("events/index/" . $id);
            }

            if (isset($options->task_id)) {
                $ajax_url = get_uri("events/view");
            }

            return array("url" => $url, "ajax_modal_url" => $ajax_url, "id" => $id);
        };




        $events = array(
            "project_created" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $project_link
            ),
            "project_deleted" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team")
            ),
            "project_task_created" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "task_assignee", "task_collaborators", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_updated" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "task_assignee", "task_collaborators", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_assigned" => array(
                "notify_to" => array("project_members", "task_assignee", "task_collaborators", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_started" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_finished" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_reopened" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_commented" => array(
                "notify_to" => array("mentioned_members", "project_members", "client_primary_contact", "client_all_contacts", "task_assignee", "task_collaborators", "team_members", "team"),
                "info" => $task_link
            ),
            "project_task_deleted" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "task_assignee", "task_collaborators", "team_members", "team"),
            ),
            "project_member_added" => array(
                "notify_to" => array("project_members", "team_members", "team"),
                "info" => $project_link
            ),
            "project_member_deleted" => array(
                "notify_to" => array("project_members", "team_members", "team")
            ),
            "project_file_added" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $project_file_link
            ),
            "project_file_deleted" => array(
                "notify_to" => array("project_members", "client_primary_contact", "client_all_contacts", "team_members", "team")
            ),
            "project_file_commented" => array(
                "notify_to" => array("mentioned_members", "project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $project_file_link
            ),
            "project_comment_added" => array(
                "notify_to" => array("mentioned_members", "project_members", "team_members", "team"),
                "info" => $project_link
            ),
            "project_comment_replied" => array(
                "notify_to" => array("mentioned_members", "project_members", "comment_creator", "team_members", "team"),
                "info" => $project_link
            ),
            "project_customer_feedback_added" => array(
                "notify_to" => array("mentioned_members", "project_members", "client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $project_link
            ),
            "project_customer_feedback_replied" => array(
                "notify_to" => array("mentioned_members", "project_members", "client_primary_contact", "client_all_contacts", "comment_creator", "team_members", "team"),
                "info" => $project_link
            ),
            "client_signup" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $client_link
            ),
            "invoice_online_payment_received" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $invoice_link
            ),
            "invoice_payment_confirmation" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts"),
                "info" => $invoice_link
            ),
            "recurring_invoice_created_vai_cron_job" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $invoice_link
            ),
            "invoice_due_reminder_before_due_date" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $invoice_link
            ),
            "invoice_overdue_reminder" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $invoice_link
            ),
            "recurring_invoice_creation_reminder" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $invoice_link
            ),
            "leave_application_submitted" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $leave_link
            ),
            "leave_approved" => array(
                "notify_to" => array("leave_applicant", "team_members", "team"),
                "info" => $leave_link
            ),
            "leave_assigned" => array(
                "notify_to" => array("leave_applicant", "team_members", "team"),
                "info" => $leave_link
            ),
            "leave_rejected" => array(
                "notify_to" => array("leave_applicant", "team_members", "team"),
                "info" => $leave_link
            ),
            "leave_canceled" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $leave_link
            ),
            "ticket_created" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "ticket_assignee", "team_members", "team"),
                "info" => $ticket_link
            ),
            "ticket_commented" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "ticket_creator", "ticket_assignee", "team_members", "team"),
                "info" => $ticket_link
            ),
            "ticket_closed" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "ticket_creator", "ticket_assignee", "team_members", "team"),
                "info" => $ticket_link
            ),
            "ticket_reopened" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "ticket_creator", "ticket_assignee", "team_members", "team"),
                "info" => $ticket_link
            ),
            "estimate_request_received" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $estimate_request_link
            ),
            "estimate_sent" => array(
                "notify_to" => array("client_primary_contact", "client_all_contacts", "team_members", "team"),
                "info" => $estimate_link
            ),
            "estimate_accepted" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $estimate_link
            ),
            "estimate_rejected" => array(
                "notify_to" => array("team_members", "team"),
                "info" => $estimate_link
            ),
            "new_message_sent" => array(
                "notify_to" => array("recipient"),
                "info" => $message_link
            ),
            "message_reply_sent" => array(
                "notify_to" => array("recipient"),
                "info" => $message_link
            ),
            "new_event_added_in_calendar" => array(
                "notify_to" => array("recipient"),
                "info" => $event_link
            ),
            "new_announcement_created" => array(
                "notify_to" => array("recipient"),
                "info" => $announcement_link
            )
        );

        if ($event) {
            $result = get_array_value($events, $event);
            if ($key && $result) {
                $key_result = get_array_value($result, $key);
                if ($info_options && $key_result) {
                    return $key_result($info_options);
                } else {
                    return $key_result;
                }
            } else {
                return $result;
            }
        } else {
            return $events;
        }
    }

}

/*
 * Send notification emails
 */
if (!function_exists('send_notification_emails')) {

    function send_notification_emails($notification_id, $email_notify_to, $extra_data = array()) {

        $ci = & get_instance();

        $notification = $ci->Notifications_model->get_email_notification($notification_id);

        if (!$notification) {
            return false;
        }

        $url = get_uri();
        $parser_data = array();
        $info = get_notification_config($notification->event, "info", $notification);

        $email_options = array();
        $attachement_url = null;

        if (is_array($info) && get_array_value($info, "url")) {
            $url = get_array_value($info, "url");
        }


        $parser_data["APP_TITLE"] = get_setting("app_title");
        $parser_data["COMPANY_NAME"] = get_setting("company_name");


        if ($notification->category == "ticket") {
            $email_template = $ci->Email_templates_model->get_final_template($notification->event);

            $parser_data["TICKET_ID"] = $notification->ticket_id;
            $parser_data["TICKET_TITLE"] = $notification->ticket_title;
            $parser_data["USER_NAME"] = $notification->user_name;
            $parser_data["TICKET_CONTENT"] = nl2br($notification->ticket_comment_description);
            $parser_data["TICKET_URL"] = $url;
        } else if ($notification->event == "invoice_payment_confirmation") {
            $email_template = $ci->Email_templates_model->get_final_template("invoice_payment_confirmation");
            $parser_data["PAYMENT_AMOUNT"] = to_currency($notification->payment_amount, $notification->client_currency_symbol);
            $parser_data["INVOICE_ID"] = get_invoice_id($notification->payment_invoice_id);
            $parser_data["INVOICE_URL"] = $url;
        } else if ($notification->event == "new_message_sent" || $notification->event == "message_reply_sent") {
            $email_template = $ci->Email_templates_model->get_final_template("message_received");

            $message_info = $ci->Messages_model->get_details(array("id" => $notification->actual_message_id))->row;

            //reply? find the subject from the parent meessage
            if ($notification->event == "message_reply_sent") {
                $main_message_info = $ci->Messages_model->get_details(array("id" => $message_info->message_id))->row;
                $parser_data["SUBJECT"] = $main_message_info->subject;
            }

            $parser_data["SUBJECT"] = $message_info->subject;
            $parser_data["USER_NAME"] = $message_info->user_name;
            $parser_data["MESSAGE_CONTENT"] = nl2br($message_info->message);
            $parser_data["MESSAGE_URL"] = $url;

            if ($message_info->files) {
                $email_options["attachments"] = prepare_attachment_of_files(get_setting("timeline_file_path"), $message_info->files);
            }
        } else if ($notification->event == "recurring_invoice_created_vai_cron_job" || $notification->event == "invoice_due_reminder_before_due_date" || $notification->event == "invoice_overdue_reminder" || $notification->event == "recurring_invoice_creation_reminder") {

            //get the specific email template
            if ($notification->event == "recurring_invoice_created_vai_cron_job") {
                $email_template = $ci->Email_templates_model->get_final_template("send_invoice");
            } else if ($notification->event == "invoice_due_reminder_before_due_date") {
                $email_template = $ci->Email_templates_model->get_final_template("invoice_due_reminder_before_due_date");
            } else if ($notification->event == "invoice_overdue_reminder") {
                $email_template = $ci->Email_templates_model->get_final_template("invoice_overdue_reminder");
            } else if ($notification->event == "recurring_invoice_creation_reminder") {
                $email_template = $ci->Email_templates_model->get_final_template("recurring_invoice_creation_reminder");
            }

            $invoice_data = get_invoice_making_data($notification->invoice_id);
            $invoice_info = get_array_value($invoice_data, "invoice_info");
            $invoice_total_summary = get_array_value($invoice_data, "invoice_total_summary");

            $primary_contact = $ci->Clients_model->get_primary_contact($invoice_info->client_id, true);

            $parser_data["INVOICE_ID"] = $notification->invoice_id;
            $parser_data["CONTACT_FIRST_NAME"] = $primary_contact->first_name;
            $parser_data["CONTACT_LAST_NAME"] = $primary_contact->last_name;
            $parser_data["BALANCE_DUE"] = to_currency($invoice_total_summary->balance_due, $invoice_total_summary->currency_symbol);
            $parser_data["DUE_DATE"] = format_to_date($invoice_info->due_date, false);
            $parser_data["PROJECT_TITLE"] = $invoice_info->project_title;
            $parser_data["INVOICE_URL"] = $url;


            $attachement_url = prepare_invoice_pdf($invoice_data, "send_email");
            $email_options["attachments"] = array(array("file_path" => $attachement_url));

            if ($notification->event == "recurring_invoice_creation_reminder") {
                $parser_data["NEXT_RECURRING_DATE"] = format_to_date($invoice_info->next_recurring_date, false);
            }

            //if invoice is sending to client, change the invoice status and last email sent date.
            $notify_to_terms = get_array_value($extra_data, "notify_to_terms");
            if (array_search("client_all_contacts", $notify_to_terms) !== false || array_search("client_primary_contact", $notify_to_terms) !== false) {
                $invoice_status_data = array("status" => "not_paid");


                //chenge last email sending time, if there is any email to client
                if (get_array_value($extra_data, "email_sending_to_client")) {
                    $invoice_status_data["last_email_sent_date"] = get_my_local_time();
                }

                $ci->Invoices_model->save($invoice_status_data, $notification->invoice_id);
            }
        } else if ($notification->event == "estimate_sent") {
            $email_template = $ci->Email_templates_model->get_final_template("general_notification");

            $parser_data["EVENT_TITLE"] = "<b>" . $notification->user_name . "</b> " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
            $parser_data["NOTIFICATION_URL"] = $url;

            $view_data["notification"] = $notification;
            $parser_data["EVENT_DETAILS"] = $ci->load->view("notifications/notification_description", $view_data, true);

            //attach a pdf copy of estimate
            $estimate_data = get_estimate_making_data($notification->estimate_id);
            $attachement_url = prepare_estimate_pdf($estimate_data, "send_email");
            $email_options["attachments"] = array(array("file_path" => $attachement_url));
        } else {
            $email_template = $ci->Email_templates_model->get_final_template("general_notification");

            $parser_data["EVENT_TITLE"] = "<b>" . $notification->user_name . "</b> " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
            $parser_data["NOTIFICATION_URL"] = $url;


            $view_data["notification"] = $notification;
            $parser_data["EVENT_DETAILS"] = $ci->load->view("notifications/notification_description", $view_data, true);
        }

        $parser_data["SIGNATURE"] = $email_template->signature;
        $parser_data["LOGO_URL"] = get_logo_url();
        $message = $ci->parser->parse_string($email_template->message, $parser_data, TRUE);

        $parser_data["EVENT_TITLE"] = $notification->user_name . " " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
        $subject = $ci->parser->parse_string($email_template->subject, $parser_data, TRUE);

        // error_log("event: " . $notification->event . PHP_EOL, 3, "notification.txt");
        // error_log("subject: " . $subject . PHP_EOL, 3, "notification.txt");
        // error_log("message: " . $message . PHP_EOL, 3, "notification.txt");

        if ($email_notify_to) {
            $email_notify_to_array = explode(",", $email_notify_to);
            foreach ($email_notify_to_array as $email_address) {
                send_app_mail($email_address, $subject, $message, $email_options);
            }
        }

        // delete the temp attachment
        if ($attachement_url && file_exists($attachement_url)) {
            unlink($attachement_url);
        }
    }

}
if (!function_exists('send_notification_sms')) {

    function send_notification_sms($notification_id, $sms_notify_to, $extra_data = array()) {

        $sid = 'ACe955f2c80ed676fb67d5f7b4a634fc4a';
        $token = '67d13eed62e8e7a287f66c2f6396da04';

        $fromNum = '+17035701026';

        $ci = & get_instance();

        $notification = $ci->Notifications_model->get_email_notification($notification_id);

        if (!$notification) {
            return false;
        }

        $url = get_uri();
        $parser_data = array();
        $info = get_notification_config($notification->event, "info", $notification);

        $email_options = array();
        $attachement_url = null;

        if (is_array($info) && get_array_value($info, "url")) {
            $url = get_array_value($info, "url");
        }


        $parser_data["APP_TITLE"] = get_setting("app_title");
        $parser_data["COMPANY_NAME"] = get_setting("company_name");


        if ($notification->category == "ticket") {
            $email_template = $ci->Email_templates_model->get_final_template($notification->event);

            $parser_data["TICKET_ID"] = $notification->ticket_id;
            $parser_data["TICKET_TITLE"] = $notification->ticket_title;
            $parser_data["USER_NAME"] = $notification->user_name;
            $parser_data["TICKET_CONTENT"] = nl2br($notification->ticket_comment_description);
            $parser_data["TICKET_URL"] = $url;
        } else if ($notification->event == "invoice_payment_confirmation") {
            $email_template = $ci->Email_templates_model->get_final_template("invoice_payment_confirmation");
            $parser_data["PAYMENT_AMOUNT"] = to_currency($notification->payment_amount, $notification->client_currency_symbol);
            $parser_data["INVOICE_ID"] = get_invoice_id($notification->payment_invoice_id);
            $parser_data["INVOICE_URL"] = $url;
        } else if ($notification->event == "new_message_sent" || $notification->event == "message_reply_sent") {
            $email_template = $ci->Email_templates_model->get_final_template("message_received");

            $message_info = $ci->Messages_model->get_details(array("id" => $notification->actual_message_id))->row;

            //reply? find the subject from the parent meessage
            if ($notification->event == "message_reply_sent") {
                $main_message_info = $ci->Messages_model->get_details(array("id" => $message_info->message_id))->row;
                $parser_data["SUBJECT"] = $main_message_info->subject;
            }

            $parser_data["SUBJECT"] = $message_info->subject;
            $parser_data["USER_NAME"] = $message_info->user_name;
            $parser_data["MESSAGE_CONTENT"] = nl2br($message_info->message);
            $parser_data["MESSAGE_URL"] = $url;

            if ($message_info->files) {
                $email_options["attachments"] = prepare_attachment_of_files(get_setting("timeline_file_path"), $message_info->files);
            }
        } else if ($notification->event == "recurring_invoice_created_vai_cron_job" || $notification->event == "invoice_due_reminder_before_due_date" || $notification->event == "invoice_overdue_reminder" || $notification->event == "recurring_invoice_creation_reminder") {

            //get the specific email template
            if ($notification->event == "recurring_invoice_created_vai_cron_job") {
                $email_template = $ci->Email_templates_model->get_final_template("send_invoice");
            } else if ($notification->event == "invoice_due_reminder_before_due_date") {
                $email_template = $ci->Email_templates_model->get_final_template("invoice_due_reminder_before_due_date");
            } else if ($notification->event == "invoice_overdue_reminder") {
                $email_template = $ci->Email_templates_model->get_final_template("invoice_overdue_reminder");
            } else if ($notification->event == "recurring_invoice_creation_reminder") {
                $email_template = $ci->Email_templates_model->get_final_template("recurring_invoice_creation_reminder");
            }

            $invoice_data = get_invoice_making_data($notification->invoice_id);
            $invoice_info = get_array_value($invoice_data, "invoice_info");
            $invoice_total_summary = get_array_value($invoice_data, "invoice_total_summary");

            $primary_contact = $ci->Clients_model->get_primary_contact($invoice_info->client_id, true);

            $parser_data["INVOICE_ID"] = $notification->invoice_id;
            $parser_data["CONTACT_FIRST_NAME"] = $primary_contact->first_name;
            $parser_data["CONTACT_LAST_NAME"] = $primary_contact->last_name;
            $parser_data["BALANCE_DUE"] = to_currency($invoice_total_summary->balance_due, $invoice_total_summary->currency_symbol);
            $parser_data["DUE_DATE"] = format_to_date($invoice_info->due_date, false);
            $parser_data["PROJECT_TITLE"] = $invoice_info->project_title;
            $parser_data["INVOICE_URL"] = $url;


            $attachement_url = prepare_invoice_pdf($invoice_data, "send_email");
            $email_options["attachments"] = array(array("file_path" => $attachement_url));

            if ($notification->event == "recurring_invoice_creation_reminder") {
                $parser_data["NEXT_RECURRING_DATE"] = format_to_date($invoice_info->next_recurring_date, false);
            }

            //if invoice is sending to client, change the invoice status and last email sent date.
            $notify_to_terms = get_array_value($extra_data, "notify_to_terms");
            if (array_search("client_all_contacts", $notify_to_terms) !== false || array_search("client_primary_contact", $notify_to_terms) !== false) {
                $invoice_status_data = array("status" => "not_paid");


                //chenge last email sending time, if there is any email to client
                if (get_array_value($extra_data, "email_sending_to_client")) {
                    $invoice_status_data["last_email_sent_date"] = get_my_local_time();
                }

                $ci->Invoices_model->save($invoice_status_data, $notification->invoice_id);
            }
        } else if ($notification->event == "estimate_sent") {
            $email_template = $ci->Email_templates_model->get_final_template("general_notification");

            $parser_data["EVENT_TITLE"] = "<b>" . $notification->user_name . "</b> " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
            $parser_data["NOTIFICATION_URL"] = $url;

            $view_data["notification"] = $notification;
            $parser_data["EVENT_DETAILS"] = $ci->load->view("notifications/notification_description", $view_data, true);

            //attach a pdf copy of estimate
            $estimate_data = get_estimate_making_data($notification->estimate_id);
            $attachement_url = prepare_estimate_pdf($estimate_data, "send_email");
            $email_options["attachments"] = array(array("file_path" => $attachement_url));
        } else {
            $email_template = $ci->Email_templates_model->get_final_template("general_notification");

            $parser_data["EVENT_TITLE"] = "<b>" . $notification->user_name . "</b> " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
            $parser_data["NOTIFICATION_URL"] = $url;


            $view_data["notification"] = $notification;
            $parser_data["EVENT_DETAILS"] = $ci->load->view("notifications/notification_description", $view_data, true);
        }

        $parser_data["SIGNATURE"] = $email_template->signature;
        $parser_data["LOGO_URL"] = get_logo_url();
        $message = $ci->parser->parse_string($email_template->message, $parser_data, TRUE);

        $parser_data["EVENT_TITLE"] = $notification->user_name . " " . sprintf(lang("notification_" . $notification->event), $notification->to_user_name);
        $subject = $ci->parser->parse_string($email_template->subject, $parser_data, TRUE);

        // error_log("event: " . $notification->event . PHP_EOL, 3, "notification.txt");
        // error_log("subject: " . $subject . PHP_EOL, 3, "notification.txt");
        // error_log("message: " . $message . PHP_EOL, 3, "notification.txt");
//        $html2TextConverter = new \Html2Text\Html2Text($message);
        $message = strip_tags(str_replace('View Details','',$message));
        if ($sms_notify_to) {
            $sms_notify_to_array = explode(",", $sms_notify_to);
            foreach ($sms_notify_to_array as $phone) {
                $client = new Client($sid, $token);
                $client->messages->create(
                    $phone,
                    array(
                        'from'=>$fromNum,
                        'body'=>strip_tags($message)
                    )
                );
//                send_app_mail($email_address, $subject, $message, $email_options);
            }
        }

        // delete the temp attachment
        if ($attachement_url && file_exists($attachement_url)) {
            unlink($attachement_url);
        }
    }

}