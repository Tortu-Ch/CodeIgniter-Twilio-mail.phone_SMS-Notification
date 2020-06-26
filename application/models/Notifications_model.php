<?php
class Notifications_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'notifications';
        parent::__construct($this->table);
    }

    function create_notification($event, $user_id, $options = array()) {
        $notification_settings_table = $this->db->dbprefix('notification_settings');
        $users_table = $this->db->dbprefix('users');
        $team_table = $this->db->dbprefix('team');
        $project_members_table = $this->db->dbprefix('project_members');
        $project_comments_table = $this->db->dbprefix('project_comments');
        $projects_table = $this->db->dbprefix('projects');
        $tasks_table = $this->db->dbprefix('tasks');
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $tickets_table = $this->db->dbprefix('tickets');
        $estimates_table = $this->db->dbprefix('estimates');
        $estimate_request_table = $this->db->dbprefix('estimate_requests');
        $messages_table = $this->db->dbprefix('messages');
        $invoices_table = $this->db->dbprefix('invoices');
        $roles_table = $this->db->dbprefix('roles');
        $events_table = $this->db->dbprefix('events');
        $announcements_table = $this->db->dbprefix('announcements');

        $notification_settings = $this->db->query("SELECT * FROM $notification_settings_table WHERE  $notification_settings_table.event='$event' AND ($notification_settings_table.enable_email OR $notification_settings_table.enable_web OR $notification_settings_table.enable_sms)")->row();
        if (!$notification_settings) {
            return false; //not notification settings found
        }

        $where = "";
        $notify_to_terms = $notification_settings->notify_to_terms;
        $project_id = get_array_value($options, "project_id");
        $task_id = get_array_value($options, "task_id");
        $leave_id = get_array_value($options, "leave_id");
        $ticket_id = get_array_value($options, "ticket_id");
        $project_comment_id = get_array_value($options, "project_comment_id");
        $ticket_comment_id = get_array_value($options, "ticket_comment_id");
        $project_file_id = get_array_value($options, "project_file_id");
        $post_id = get_array_value($options, "post_id");
        $to_user_id = get_array_value($options, "to_user_id");
        $activity_log_id = get_array_value($options, "activity_log_id");
        $client_id = get_array_value($options, "client_id");
        $invoice_payment_id = get_array_value($options, "invoice_payment_id");
        $invoice_id = get_array_value($options, "invoice_id");
        $estimate_id = get_array_value($options, "estimate_id");
        $estimate_request_id = get_array_value($options, "estimate_request_id");
        $actual_message_id = get_array_value($options, "actual_message_id");
        $parent_message_id = get_array_value($options, "parent_message_id");
        $event_id = get_array_value($options, "event_id");
        $announcement_id = get_array_value($options, "announcement_id");

        $extra_data = array();

        //prepare notifiy to terms 
        if ($notify_to_terms) {
            $notify_to_terms = explode(",", $notify_to_terms);
        } else {
            $notify_to_terms = array();
        }

        /*
         * Using following terms:
         * team_members, team,
         * project_members, client_primary_contact, client_all_contacts, task_assignee, task_collaborators, comment_creator, leave_applicant, ticket_creator, ticket_assignee, estimate_request_assignee
         */



        //find team members
        if ($notification_settings->notify_to_team_members) {
            $where .= " OR FIND_IN_SET($users_table.id, '$notification_settings->notify_to_team_members') ";
        }

        //find team
        if ($notification_settings->notify_to_team) {
            $where .= " OR FIND_IN_SET($users_table.id, (SELECT GROUP_CONCAT($team_table.members) AS team_users FROM $team_table WHERE $team_table.deleted=0 AND FIND_IN_SET($team_table.id, '$notification_settings->notify_to_team'))) ";
        }

        //find project members
        if (in_array("project_members", $notify_to_terms) && $project_id) {
            $where .= " OR FIND_IN_SET($users_table.id, (SELECT GROUP_CONCAT($project_members_table.user_id) AS proje_users FROM $project_members_table WHERE $project_members_table.deleted=0 AND $project_members_table.project_id=$project_id)) ";
        }

        //find task assignee
        if (in_array("task_assignee", $notify_to_terms) && $task_id) {
            $where .= " OR ($users_table.id=(SELECT $tasks_table.assigned_to FROM $tasks_table WHERE $tasks_table.id=$task_id)) ";
        }

        //find  task_collaborators
        if (in_array("task_collaborators", $notify_to_terms) && $task_id) {
            $where .= " OR (FIND_IN_SET($users_table.id, (SELECT $tasks_table.collaborators FROM $tasks_table WHERE $tasks_table.id=$task_id))) ";
        }


        //find client_all_contacts by project
        if (in_array("client_all_contacts", $notify_to_terms) && $project_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE FIND_IN_SET($users_table.client_id, (SELECT $projects_table.client_id FROM $projects_table WHERE $projects_table.id=$project_id))
                      )
                    ) ";
        }

        //find client_primary_contacts by project
        if (in_array("client_primary_contact", $notify_to_terms) && $project_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE $users_table.is_primary_contact=1 AND FIND_IN_SET($users_table.client_id, (SELECT $projects_table.client_id FROM $projects_table WHERE $projects_table.id=$project_id))
                      )
                    ) ";
        }


        //find client_all_contacts by ticket
        if (in_array("client_all_contacts", $notify_to_terms) && $ticket_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE FIND_IN_SET($users_table.client_id, (SELECT $tickets_table.client_id FROM $tickets_table WHERE $tickets_table.id=$ticket_id))
                      )
                    ) ";
        }

        //find client_primary_contacts by project
        if (in_array("client_primary_contact", $notify_to_terms) && $ticket_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE $users_table.is_primary_contact=1 AND FIND_IN_SET($users_table.client_id, (SELECT $tickets_table.client_id FROM $tickets_table WHERE $tickets_table.id=$ticket_id))
                      )
                    ) ";
        }

        //find ticket creator
        if (in_array("ticket_creator", $notify_to_terms) && $ticket_id) {
            $where .= " OR ($users_table.id=(SELECT $tickets_table.created_by FROM $tickets_table WHERE $tickets_table.id=$ticket_id)) ";
        }

        //find ticket assignee
        if (in_array("ticket_assignee", $notify_to_terms) && $ticket_id) {
            $where .= " OR ($users_table.id=(SELECT $tickets_table.assigned_to FROM $tickets_table WHERE $tickets_table.id=$ticket_id)) ";
        }

        //find estimate request assignee
        if (in_array("estimate_request_assignee", $notify_to_terms) && $estimate_request_id) {
            $where .= " OR ($users_table.id=(SELECT $estimate_request_id.assigned_to FROM $estimate_request_id WHERE $estimate_request_table.id=$estimate_request_id)) ";
        }



        //find client_all_contacts by ticket
        if (in_array("client_all_contacts", $notify_to_terms) && $estimate_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE FIND_IN_SET($users_table.client_id, (SELECT $estimates_table.client_id FROM $estimates_table WHERE $estimates_table.id=$estimate_id))
                      )
                    ) ";
        }

        //find client_primary_contacts by project
        if (in_array("client_primary_contact", $notify_to_terms) && $estimate_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE $users_table.is_primary_contact=1 AND FIND_IN_SET($users_table.client_id, (SELECT $estimates_table.client_id FROM $estimates_table WHERE $estimates_table.id=$estimate_id))
                      )
                    ) ";
        }


        //find project comment creator, comment id is not = id. It should be the the original comment_id
        if (in_array("comment_creator", $notify_to_terms) && $project_comment_id) {
            $where .= " OR ($users_table.id=(SELECT $project_comments_table.created_by FROM $project_comments_table WHERE $project_comments_table.id=$project_comment_id)) ";
        }



        //find leave_applicant
        if (in_array("leave_applicant", $notify_to_terms) && $leave_id) {
            $where .= " OR ($users_table.id=(SELECT $leave_applications_table.applicant_id FROM $leave_applications_table WHERE $leave_applications_table.id=$leave_id)) ";
        }


        //find message recipient
        if (in_array("recipient", $notify_to_terms) && $actual_message_id) {
            $where .= " OR ($users_table.id=(SELECT $messages_table.to_user_id FROM $messages_table WHERE $messages_table.id=$actual_message_id)) ";
        }

        //find mentioned members
        if (in_array("mentioned_members", $notify_to_terms) && $project_comment_id) {
            $comment_info = $this->Project_comments_model->get_one($project_comment_id);
            $mentioned_members = get_members_from_mention($comment_info->description);
            if ($mentioned_members) {
                $string_of_mentioned_members = implode(",", $mentioned_members);
                $where .= " OR FIND_IN_SET($users_table.id, '$string_of_mentioned_members')";
            }
        }

        //find event recipient
        if (in_array("recipient", $notify_to_terms) && $event_id) {

            //find the event and check the recipient
            $event_info = $this->db->query("SELECT $events_table.* FROM $events_table WHERE $events_table.id=$event_id")->row();

            //we are saving the share with data like this:
            //member:1,member:2,team:1
            //all
            //so, we've to retrive the users 


            if ($event_info->share_with === "all") {
                $where .= " OR $users_table.user_type = 'staff' "; //all team members
            } else {


                $share_with_array = explode(",", $event_info->share_with); // found an array like this array("member:1", "member:2", "team:1")

                $event_users = array();
                $event_team = array();
                $event_contact = array();

                foreach ($share_with_array as $share) {

                    $share_data = explode(":", $share);

                    if (get_array_value($share_data, '0') === "member") {
                        $event_users[] = get_array_value($share_data, '1');
                    } else if (get_array_value($share_data, '0') === "team") {
                        $event_team[] = get_array_value($share_data, '1');
                    } else if (get_array_value($share_data, '0') === "contact") {
                        $event_contact[] = get_array_value($share_data, '1');
                    }
                }

                //find team members
                if (count($event_users)) {
                    $where .= " OR FIND_IN_SET($users_table.id, '" . join(',', $event_users) . "') ";
                }

                //find team
                if (count($event_team)) {
                    $where .= " OR FIND_IN_SET($users_table.id, (SELECT GROUP_CONCAT($team_table.members) AS team_users FROM $team_table WHERE $team_table.deleted=0 AND FIND_IN_SET($team_table.id, '" . join(',', $event_team) . "'))) ";
                }

                //find client contacts
                if (count($event_contact)) {
                    $where .= " OR FIND_IN_SET($users_table.id, '" . join(',', $event_contact) . "') ";
                }
            }
        }


        //find announcement recipient
        if (in_array("recipient", $notify_to_terms) && $announcement_id) {
            $announcement_info = $this->db->query("SELECT $announcements_table.* FROM $announcements_table WHERE $announcements_table.id=$announcement_id")->row();

            $announcement_share_with = explode(",", $announcement_info->share_with);

            if (in_array("all_members", $announcement_share_with)) {
                $where .= " OR ($users_table.user_type='staff' AND $users_table.status='active' AND $users_table.deleted=0)";
            }
            if (in_array("all_clients", $announcement_share_with)) {
                $where .= " OR ($users_table.user_type='client' AND $users_table.status='active' AND $users_table.deleted=0)";
            }
        }


        //find client_all_contacts by invoice
        if (in_array("client_all_contacts", $notify_to_terms) && $invoice_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE FIND_IN_SET($users_table.client_id, (SELECT $invoices_table.client_id FROM $invoices_table WHERE $invoices_table.id=$invoice_id))
                      )
                    ) ";
        }

        //find client_primary_contacts by invoice
        if (in_array("client_primary_contact", $notify_to_terms) && $invoice_id) {
            $where .= " OR FIND_IN_SET( $users_table.id, (
                        SELECT GROUP_CONCAT($users_table.id) AS contact_users FROM $users_table WHERE $users_table.is_primary_contact=1 AND FIND_IN_SET($users_table.client_id, (SELECT $invoices_table.client_id FROM $invoices_table WHERE $invoices_table.id=$invoice_id))
                      )
                    ) ";
        }



        $sql = "SELECT $users_table.id, $users_table.email,  $users_table.phone, $users_table.enable_web_notification, $users_table.enable_sms_notification, $users_table.enable_email_notification, $users_table.user_type, $users_table.is_admin, $users_table.role_id,
                    $roles_table.permissions
                FROM $users_table
                LEFT JOIN $roles_table ON $roles_table.id = $users_table.role_id AND $roles_table.deleted = 0
                WHERE $users_table.deleted=0 AND $users_table.status='active' AND $users_table.id!=$user_id AND ($users_table.enable_web_notification=1 OR $users_table.enable_sms_notification=1 OR $users_table.enable_email_notification =1 )  AND (1=2 $where)";

        //echo $sql;
        $notify_to = $this->db->query($sql);



        //if it's a ticket related notification, we'll check the ticket type access permission for team members.
        $ticket_info = NULL;
        if ($ticket_id) {
            $ticket_info = $this->db->query("SELECT $tickets_table.* FROM $tickets_table WHERE $tickets_table.id=$ticket_id")->row();
        }


        $web_notify_to = "";
        $sms_notify_to = "";
        $email_notify_to = "";


        if ($notify_to->num_rows()) {
            foreach ($notify_to->result() as $user) {


                //check ticket type permission for team mebers before preparing the notifcation 
                if ($ticket_info && !$this->notify_to_this_user_for_this_ticket($ticket_info, $user)) {
                    continue; //skip next lines for this loop
                }


                //prepare web notify to list
                if ($notification_settings->enable_web && $user->enable_web_notification) {
                    if ($web_notify_to) {
                        $web_notify_to .= ",";
                    }
                    $web_notify_to .= $user->id;
                }

                //prepare sms notify to list
                if ($notification_settings->enable_sms && $user->enable_sms_notification) {
                    if ($sms_notify_to) {
                        $sms_notify_to .= ",";
                    }
                    $sms_notify_to .= $user->phone;
                }

                if ($user->enable_sms_notification && $user->user_type == "client") {
                    $extra_data["sms_sending_to_client"] = true;
                }

                //prepare email notify to list
                if ($notification_settings->enable_email && $user->enable_email_notification) {
                    if ($email_notify_to) {
                        $email_notify_to .= ",";
                    }
                    $email_notify_to .= $user->email;
                }

                //check if email sending to client
                if ($user->enable_email_notification && $user->user_type == "client") {
                    $extra_data["email_sending_to_client"] = true;
                }

            }
        }

        $data = array(
            "user_id" => $user_id,
            "description" => "",
            "created_at" => get_current_utc_time(),
            "notify_to" => $web_notify_to,
            "read_by" => "",
            "event" => $event,
            "project_id" => $project_id ? $project_id : "",
            "task_id" => $task_id ? $task_id : "",
            "project_comment_id" => $project_comment_id ? $project_comment_id : "",
            "ticket_id" => $ticket_id ? $ticket_id : "",
            "ticket_comment_id" => $ticket_comment_id ? $ticket_comment_id : "",
            "project_file_id" => $project_file_id ? $project_file_id : "",
            "leave_id" => $leave_id ? $leave_id : "",
            "post_id" => $post_id ? $post_id : "",
            "to_user_id" => $to_user_id ? $to_user_id : "",
            "activity_log_id" => $activity_log_id ? $activity_log_id : "",
            "client_id" => $client_id ? $client_id : "",
            "invoice_payment_id" => $invoice_payment_id ? $invoice_payment_id : "",
            "invoice_id" => $invoice_id ? $invoice_id : "",
            "estimate_request_id" => $estimate_request_id ? $estimate_request_id : "",
            "estimate_id" => $estimate_id ? $estimate_id : "",
            "actual_message_id" => $actual_message_id ? $actual_message_id : "",
            "parent_message_id" => $parent_message_id ? $parent_message_id : "",
            "event_id" => $event_id ? $event_id : "",
            "announcement_id" => $announcement_id ? $announcement_id : ""
        );

        $notification_id = $this->save($data);

        $extra_data["notify_to_terms"] = $notify_to_terms;

        //notification saved. send sms
        if ($notification_id && $sms_notify_to) {
            send_notification_sms($notification_id, $sms_notify_to, $extra_data);
        }

        //notification saved. send emails
        if ($notification_id && $email_notify_to) {
            send_notification_emails($notification_id, $email_notify_to, $extra_data);
        }

    }

    //if the ticket has been assigend to a team member, then only the assignee will get notificaiton
    //if the ticket is not been assigned, all allowed team members will get notification
    //client will always get notification

    private function notify_to_this_user_for_this_ticket($ticket_info, $user) {

        if ($user->user_type === "client") {
            return true; //we'll only check the ticket type access permission for staffs
        }


        if ($ticket_info->assigned_to) {
            //only assigne will get notification for a assigned ticket
            if ($ticket_info->assigned_to === $user->id) {
                return true;
            }
        } else {
            //ticket is not assigned yet
            //check who has access to this ticket and send notification
            if ($user->is_admin) {
                return true;
            } else {

                //check if user has permission to this ticket type
                $permissions = null;
                if ($user->permissions) {
                    $permissions = unserialize($user->permissions);
                    $permissions = is_array($permissions) ? $permissions : array();

                    $ticket_permission = get_array_value($permissions, "ticket");

                    if ($ticket_permission === "all") {
                        return true; //user has acces to all tickets
                    } else if ($ticket_permission === "specific") {

                        //user has access to specific ticket types
                        $allowed_ticket_types = explode(",", get_array_value($permissions, "ticket_specific"));
                        if (in_array($ticket_info->ticket_type_id, $allowed_ticket_types)) {
                            return true;
                        }
                    }
                }
            }
        }
    }

    /* prepare notifications of new events */

    function get_notifications($user_id, $offset = 0, $limit = 20) {
        $notifications_table = $this->db->dbprefix('notifications');
        $users_table = $this->db->dbprefix('users');
        $projects_table = $this->db->dbprefix('projects');
        $project_comments_table = $this->db->dbprefix('project_comments');
        $project_files_table = $this->db->dbprefix('project_files');
        $tasks_table = $this->db->dbprefix('tasks');
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $tickets_table = $this->db->dbprefix('tickets');
        $ticket_comments_table = $this->db->dbprefix('ticket_comments');
        $activity_logs_table = $this->db->dbprefix('activity_logs');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $posts_table = $this->db->dbprefix('posts');
        $invoices_table = $this->db->dbprefix('invoices');
        $clients_table = $this->db->dbprefix('clients');
        $events_table = $this->db->dbprefix('events');
        $announcements_table = $this->db->dbprefix('announcements');


        $sql = "SELECT SQL_CALC_FOUND_ROWS $notifications_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS user_name, $users_table.image AS user_image,
                 $projects_table.title AS project_title,
                 $project_comments_table.description AS project_comment_title,
                 $project_files_table.file_name AS project_file_title,
                 $tasks_table.title AS task_title,
                 $events_table.title AS event_title,    
                 $tickets_table.title AS ticket_title,
                 $ticket_comments_table.description AS ticket_comment_description,
                 $posts_table.description AS posts_title,
                 $announcements_table.title AS announcement_title,
                 $activity_logs_table.changes AS activity_log_changes, $activity_logs_table.log_type AS activity_log_type,
                 $leave_applications_table.start_date AS leave_start_date, $leave_applications_table.end_date AS leave_end_date,
                 $invoice_payments_table.invoice_id AS payment_invoice_id, $invoice_payments_table.amount AS payment_amount, (SELECT currency_symbol FROM $clients_table WHERE $clients_table.id=$invoices_table.client_id) AS client_currency_symbol,
                 (SELECT CONCAT($users_table.first_name, ' ', $users_table.last_name) FROM $users_table WHERE $users_table.id=$notifications_table.to_user_id) AS to_user_name,
                 FIND_IN_SET($user_id, $notifications_table.read_by) as is_read    
        FROM $notifications_table
        LEFT JOIN $projects_table ON $projects_table.id=$notifications_table.project_id
        LEFT JOIN $project_comments_table ON $project_comments_table.id=$notifications_table.project_comment_id
        LEFT JOIN $project_files_table ON $project_files_table.id=$notifications_table.project_file_id
        LEFT JOIN $tasks_table ON $tasks_table.id=$notifications_table.task_id
        LEFT JOIN $leave_applications_table ON $leave_applications_table.id=$notifications_table.leave_id
        LEFT JOIN $tickets_table ON $tickets_table.id=$notifications_table.ticket_id
        LEFT JOIN $ticket_comments_table ON $ticket_comments_table.id=$notifications_table.ticket_comment_id
        LEFT JOIN $posts_table ON $posts_table.id=$notifications_table.post_id
        LEFT JOIN $users_table ON $users_table.id=$notifications_table.user_id
        LEFT JOIN $activity_logs_table ON $activity_logs_table.id=$notifications_table.activity_log_id
        LEFT JOIN $invoice_payments_table ON $invoice_payments_table.id=$notifications_table.invoice_payment_id  
        LEFT JOIN $invoices_table ON $invoices_table.id=$notifications_table.invoice_id
        LEFT JOIN $events_table ON $events_table.id=$notifications_table.event_id
        LEFT JOIN $announcements_table ON $announcements_table.id=$notifications_table.announcement_id
        WHERE $notifications_table.deleted=0 AND FIND_IN_SET($user_id, $notifications_table.notify_to) != 0
        ORDER BY $notifications_table.id DESC LIMIT $offset, $limit";

        $data = new stdClass();
        $data->result = $this->db->query($sql)->result();
        $data->found_rows = $this->db->query("SELECT FOUND_ROWS() as found_rows")->row()->found_rows;
        return $data;
    }

    function get_email_notification($notification_id) {
        $notifications_table = $this->db->dbprefix('notifications');
        $users_table = $this->db->dbprefix('users');
        $projects_table = $this->db->dbprefix('projects');
        $project_comments_table = $this->db->dbprefix('project_comments');
        $project_files_table = $this->db->dbprefix('project_files');
        $tasks_table = $this->db->dbprefix('tasks');
        $leave_applications_table = $this->db->dbprefix('leave_applications');
        $tickets_table = $this->db->dbprefix('tickets');
        $ticket_comments_table = $this->db->dbprefix('ticket_comments');
        $activity_logs_table = $this->db->dbprefix('activity_logs');
        $invoice_payments_table = $this->db->dbprefix('invoice_payments');
        $posts_table = $this->db->dbprefix('posts');
        $invoices_table = $this->db->dbprefix('invoices');
        $clients_table = $this->db->dbprefix('clients');
        $events_table = $this->db->dbprefix('events');
        $notification_settings_table = $this->db->dbprefix('notification_settings');
        $announcement_table = $this->db->dbprefix('announcements');

        $sql = "SELECT $notifications_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS user_name,
                 $projects_table.title AS project_title,
                 $project_comments_table.description AS project_comment_title,
                 $project_files_table.file_name AS project_file_title,
                 $tasks_table.title AS task_title,
                 $events_table.title AS event_title,
                 $tickets_table.title AS ticket_title,
                 $ticket_comments_table.description AS ticket_comment_description,
                 $posts_table.description AS posts_title,
                 $announcement_table.title AS announcement_title,
                 $activity_logs_table.changes AS activity_log_changes, $activity_logs_table.log_type AS activity_log_type,
                 $leave_applications_table.start_date AS leave_start_date, $leave_applications_table.end_date AS leave_end_date,
                 $invoice_payments_table.invoice_id AS payment_invoice_id, $invoice_payments_table.amount AS payment_amount, (SELECT currency_symbol FROM $clients_table WHERE $clients_table.id=$invoices_table.client_id) AS client_currency_symbol,
                 (SELECT CONCAT($users_table.first_name, ' ', $users_table.last_name) FROM $users_table WHERE $users_table.id=$notifications_table.to_user_id) AS to_user_name,
                 $notification_settings_table.category
        FROM $notifications_table
        LEFT JOIN $projects_table ON $projects_table.id=$notifications_table.project_id
        LEFT JOIN $project_comments_table ON $project_comments_table.id=$notifications_table.project_comment_id
        LEFT JOIN $project_files_table ON $project_files_table.id=$notifications_table.project_file_id
        LEFT JOIN $tasks_table ON $tasks_table.id=$notifications_table.task_id
        LEFT JOIN $leave_applications_table ON $leave_applications_table.id=$notifications_table.leave_id
        LEFT JOIN $tickets_table ON $tickets_table.id=$notifications_table.ticket_id
        LEFT JOIN $ticket_comments_table ON $ticket_comments_table.id=$notifications_table.ticket_comment_id
        LEFT JOIN $posts_table ON $posts_table.id=$notifications_table.post_id
        LEFT JOIN $users_table ON $users_table.id=$notifications_table.user_id
        LEFT JOIN $activity_logs_table ON $activity_logs_table.id=$notifications_table.activity_log_id
        LEFT JOIN $invoice_payments_table ON $invoice_payments_table.id=$notifications_table.invoice_payment_id
        LEFT JOIN $invoices_table ON $invoices_table.id=$notifications_table.invoice_id
        LEFT JOIN $notification_settings_table ON $notification_settings_table.event=$notifications_table.event
        LEFT JOIN $events_table ON $events_table.id=$notifications_table.event_id
        LEFT JOIN $announcement_table ON $announcement_table.id=$notifications_table.announcement_id
        WHERE $notifications_table.id=$notification_id";

        return $this->db->query($sql)->row();

    }

    function count_notifications($user_id, $last_notification_checke_at = "0") {
        $notifications_table = $this->db->dbprefix('notifications');

        //we alos update the user's online status
        $users_table = $this->db->dbprefix('users');
        $now = get_current_utc_time();

        $this->db->query("UPDATE $users_table SET $users_table.last_online = '$now' WHERE $users_table.id=$user_id");

        //find notifications
        $sql = "SELECT COUNT($notifications_table.id) AS total_notifications
        FROM $notifications_table
        WHERE $notifications_table.deleted=0 AND FIND_IN_SET($user_id, $notifications_table.notify_to) != 0 AND FIND_IN_SET($user_id, $notifications_table.read_by) = 0
        AND timestamp($notifications_table.created_at)>timestamp('$last_notification_checke_at')";


        $result = $this->db->query($sql);
        if ($result->num_rows()) {
            return $result->row()->total_notifications;
        }
    }

    /* update message ustats */

    function set_notification_status_as_read($notification_id, $user_id = 0) {
        $notifications_table = $this->db->dbprefix('notifications');

        $sql = "UPDATE $notifications_table SET $notifications_table.read_by = CONCAT($notifications_table.read_by,',',$user_id)
        WHERE $notifications_table.id=$notification_id AND FIND_IN_SET($user_id, $notifications_table.read_by) = 0";
        return $this->db->query($sql);
    }

}
