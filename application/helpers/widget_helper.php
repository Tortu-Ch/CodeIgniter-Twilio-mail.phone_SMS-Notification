<?php

/**
 * get clock in/ clock out widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('clock_widget')) {

    function clock_widget($return_as_data = false) {
        $ci = get_instance();
        $view_data["clock_status"] = $ci->Attendance_model->current_clock_in_record($ci->login_user->id);
        return $ci->load->view("attendance/clock_widget", $view_data, $return_as_data);
    }

}

/**
 * activity logs widget for projects
 * @param array $params
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('activity_logs_widget')) {

    function activity_logs_widget($params = array(), $return_as_data = false) {
        $ci = get_instance();

        $limit = get_array_value($params, "limit");
        $limit = $limit ? $limit : "20";
        $offset = get_array_value($params, "offset");
        $offset = $offset ? $offset : "0";

        $params["user_id"] = $ci->login_user->id;
        $params["is_admin"] = $ci->login_user->is_admin;


        $logs = $ci->Activity_logs_model->get_details($params);
        $view_data["activity_logs"] = $logs->result;
        $view_data["result_remaining"] = $logs->found_rows - $limit - $offset;
        $view_data["next_page_offset"] = $offset + $limit;

        $view_data["log_for"] = get_array_value($params, "log_for");
        $view_data["log_for_id"] = get_array_value($params, "log_for_id");
        $view_data["log_type"] = get_array_value($params, "log_type");
        $view_data["log_type_id"] = get_array_value($params, "log_type_id");

        return $view_data["result_remaining"] = $ci->load->view("activity_logs/activity_logs_widget", $view_data, $return_as_data);
    }

}


/**
 * get timeline widget
 * @param array $params
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('timeline_widget')) {

    function timeline_widget($params = array(), $return_as_data = false) {
        $ci = get_instance();

        $limit = get_array_value($params, "limit");
        $limit = $limit ? $limit : "20";
        $offset = get_array_value($params, "offset");
        $offset = $offset ? $offset : "0";

        $is_first_load = get_array_value($params, "is_first_load");
        if ($is_first_load) {
            $view_data["is_first_load"] = true;
        } else {
            $view_data["is_first_load"] = false;
        }

        $logs = $ci->Posts_model->get_details($params);
        $view_data["posts"] = $logs->result;
        $view_data["result_remaining"] = $logs->found_rows - $limit - $offset;
        $view_data["next_page_offset"] = $offset + $limit;

        $user_id = get_array_value($params, "user_id");
        if ($user_id && !count($logs->result)) {
            //show a no post found message to user's wall for empty post list
            $ci->load->view("timeline/no_post_message");
        } else {
            return $ci->load->view("timeline/post_list", $view_data, $return_as_data);
        }
    }

}


/**
 * get announcement notice
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('announcements_alert_widget')) {

    function announcements_alert_widget($return_as_data = false) {
        $ci = get_instance();
        $announcements = $ci->Announcements_model->get_unread_announcements($ci->login_user->id, $ci->login_user->user_type)->result();
        $view_data["announcements"] = $announcements;
        return $ci->load->view("announcements/alert", $view_data, $return_as_data);
    }

}


/**
 * get tasks widget of loged in user
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_open_tasks_widget')) {

    function my_open_tasks_widget($return_as_data = false) {
        $ci = get_instance();
        $view_data["total"] = $ci->Tasks_model->count_my_open_tasks($ci->login_user->id);
        return $ci->load->view("projects/tasks/open_tasks_widget", $view_data, $return_as_data);
    }

}


/**
 * get tasks status widteg of loged in user
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_task_stataus_widget')) {

    function my_task_stataus_widget($custom_class = "", $return_as_data = false) {
        $ci = get_instance();
        $view_data["task_statuses"] = $ci->Tasks_model->get_task_statistics(array("user_id" => $ci->login_user->id));
        $view_data["custom_class"] = $custom_class;

        return $ci->load->view("projects/tasks/my_task_status_widget", $view_data, $return_as_data);
    }

}


/**
 * get todays event widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('events_today_widget')) {

    function events_today_widget($return_as_data = false) {
        $ci = get_instance();

        $options = array(
            "user_id" => $ci->login_user->id,
            "team_ids" => $ci->login_user->team_ids
        );

        if ($ci->login_user->user_type == "client") {
            $options["is_client"] = true;
        }

        $view_data["total"] = $ci->Events_model->count_events_today($options);
        return $ci->load->view("events/events_today", $view_data, $return_as_data);
    }

}


/**
 * get new posts widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('new_posts_widget')) {

    function new_posts_widget($return_as_data = false) {
        $ci = get_instance();
        $view_data["total"] = $ci->Posts_model->count_new_posts();
        return $ci->load->view("timeline/new_posts_widget", $view_data, $return_as_data);
    }

}


/**
 * get event list widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('events_widget')) {

    function events_widget($return_as_data = false) {
        $ci = get_instance();

        $options = array("user_id" => $ci->login_user->id, "limit" => 10, "team_ids" => $ci->login_user->team_ids);

        if ($ci->login_user->user_type == "client") {
            $options["is_client"] = true;
        }

        $view_data["events"] = $ci->Events_model->get_upcomming_events($options);

        return $ci->load->view("events/events_widget", $view_data, $return_as_data);
    }

}


/**
 * get event icons based on event sharing 
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('get_event_icon')) {

    function get_event_icon($share_with = "") {
        $icon = "";
        if (!$share_with) {
            $icon = "fa-lock";
        } else if ($share_with == "all") {
            $icon = "fa-globe";
        } else {
            $icon = "fa-at";
        }
        return $icon;
    }

}


/**
 * get open timers widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_open_timers')) {

    function my_open_timers($return_as_data = false) {
        $ci = get_instance();
        $timers = $ci->Timesheets_model->get_open_timers($ci->login_user->id);
        $view_data["timers"] = $timers->result();
        return $ci->load->view("projects/open_timers", $view_data, $return_as_data);
    }

}


/**
 * get income expense widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('income_vs_expenses_widget')) {

    function income_vs_expenses_widget($custom_class = "", $return_as_data = false) {
        $ci = get_instance();
        $info = $ci->Expenses_model->get_income_expenses_info();
        $view_data["income"] = $info->income ? $info->income : 0;
        $view_data["expenses"] = $info->expneses ? $info->expneses : 0;
        $view_data["custom_class"] = $custom_class;
        return $ci->load->view("expenses/income_expenses_widget", $view_data, $return_as_data);
    }

}


/**
 * get ticket status widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('ticket_status_widget')) {

    function ticket_status_widget($return_as_data = false) {
        $ci = get_instance();
        $statuses = $ci->Tickets_model->get_ticket_status_info()->result();

        $view_data["new"] = 0;
        $view_data["open"] = 0;
        $view_data["closed"] = 0;
        foreach ($statuses as $status) {
            if ($status->status === "new") {
                $view_data["new"] = $status->total;
            } else if ($status->status === "closed") {
                $view_data["closed"] = $status->total;
            } else {
                $view_data["open"] += $status->total;
            }
        }

        return $ci->load->view("tickets/ticket_status_widget", $view_data, $return_as_data);
    }

}


/**
 * get invoice statistics widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('invoice_statistics_widget')) {

    function invoice_statistics_widget($return_as_data = false) {
        $ci = get_instance();

        $options = array();
        if ($ci->login_user->user_type == "client") {
            $options["client_id"] = $ci->login_user->client_id;
        }

        $info = $ci->Invoices_model->invoice_statistics($options);

        $payments = array();
        $payments_array = array();

        $invoices = array();
        $invoices_array = array();

        for ($i = 1; $i <= 12; $i++) {
            $payments[$i] = 0;
            $invoices[$i] = 0;
        }

        foreach ($info->payments as $payment) {
            $payments[$payment->month] = $payment->total;
        }
        foreach ($info->invoices as $invoice) {
            $invoices[$invoice->month] = $invoice->total;
        }

        foreach ($payments as $key => $payment) {
            $payments_array[] = array($key, $payment);
        }

        foreach ($invoices as $key => $invoice) {
            $invoices_array[] = array($key, $invoice);
        }

        $view_data["payments"] = json_encode($payments_array);
        $view_data["invoices"] = json_encode($invoices_array);

        return $ci->load->view("invoices/invoice_statistics_widget", $view_data, $return_as_data);
    }

}


/**
 * get projects statistics widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('project_timesheet_statistics_widget')) {

    function project_timesheet_statistics_widget($return_as_data = false) {
        $ci = get_instance();

        $timesheets = array();
        $timesheets_array = array();

        $ticks = array();

        $today = get_my_local_time("Y-m-d");
        $start_date = date("Y-m-", strtotime($today)) . "01";
        $end_date = date("Y-m-t", strtotime($today));

        $timesheets_result = $ci->Timesheets_model->get_timesheet_statistics(array("start_date" => $start_date, "end_date" => $end_date, "user_id" => $ci->login_user->id))->result();
        $days_of_month = date("t", strtotime($today));

        for ($i = 0; $i <= $days_of_month; $i++) {
            $timesheets[$i] = 0;
        }

        foreach ($timesheets_result as $value) {
            $timesheets[$value->day * 1] = $value->total_sec / 60;
        }

        foreach ($timesheets as $key => $value) {
            $timesheets_array[] = array($key, $value);
        }

        for ($i = 0; $i <= $days_of_month; $i++) {
            $title = "";
            if ($i === 1) {
                $title = "01";
            } else if ($i === 5) {
                $title = "05";
            } else if ($i === 10) {
                $title = "10";
            } else if ($i === 15) {
                $title = "15";
            } else if ($i === 20) {
                $title = "20";
            } else if ($i === 25) {
                $title = "25";
            } else if ($i === 30) {
                $title = "30";
            }
            $ticks[] = array($i, $title);
        }

        $view_data["timesheets"] = json_encode($timesheets_array);
        $view_data["ticks"] = json_encode($ticks);
        return $ci->load->view("projects/timesheets/timesheet_wedget", $view_data, $return_as_data);
    }

}


/**
 * get timecard statistics
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('timecard_statistics_widget')) {

    function timecard_statistics_widget($return_as_data = false) {
        $ci = get_instance();

        $timecards = array();
        $timecards_array = array();

        $ticks = array();

        $today = get_my_local_time("Y-m-d");
        $start_date = date("Y-m-", strtotime($today)) . "01";
        $end_date = date("Y-m-t", strtotime($today));
        $options = array("start_date" => $start_date, "end_date" => $end_date, "user_id" => $ci->login_user->id);
        $timesheets_result = $ci->Attendance_model->get_timecard_statistics($options)->result();
        $days_of_month = date("t", strtotime($today));

        for ($i = 0; $i <= $days_of_month; $i++) {
            $timecards[$i] = 0;
        }

        foreach ($timesheets_result as $value) {
            $timecards[$value->day * 1] = $value->total_sec / 60;
        }

        foreach ($timecards as $key => $value) {
            $timecards_array[] = array($key, $value);
        }

        for ($i = 0; $i <= $days_of_month; $i++) {
            $title = "";
            if ($i === 1) {
                $title = "01";
            } else if ($i === 5) {
                $title = "05";
            } else if ($i === 10) {
                $title = "10";
            } else if ($i === 15) {
                $title = "15";
            } else if ($i === 20) {
                $title = "20";
            } else if ($i === 25) {
                $title = "25";
            } else if ($i === 30) {
                $title = "30";
            }
            $ticks[] = array($i, $title);
        }

        $view_data["timecards"] = json_encode($timecards_array);
        $view_data["ticks"] = json_encode($ticks);
        return $ci->load->view("attendance/timecard_statistics", $view_data, $return_as_data);
    }

}


/**
 * get count of clocked in /out users widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('count_clock_status_widget')) {

    function count_clock_status_widget($return_as_data = false) {
        $ci = get_instance();
        $info = $ci->Attendance_model->count_clock_status();
        $view_data["members_clocked_in"] = $info->members_clocked_in ? $info->members_clocked_in : 0;
        $view_data["members_clocked_out"] = $info->members_clocked_out ? $info->members_clocked_out : 0;
        return $ci->load->view("attendance/count_clock_status_widget", $view_data, $return_as_data);
    }

}


/**
 * get project count status widteg
 * @param integer $user_id
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('count_project_status_widget')) {

    function count_project_status_widget($user_id = 0, $return_as_data = false) {
        $ci = get_instance();
        $options = array(
            "user_id" => $user_id ? $user_id : $ci->login_user->id
        );
        $info = $ci->Projects_model->count_project_status($options);
        $view_data["project_open"] = $info->open;
        $view_data["project_completed"] = $info->completed;
        return $ci->load->view("projects/widgets/project_status_widget", $view_data, $return_as_data);
    }

}


/**
 * count total time widget
 * @param integer $user_id
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('count_total_time_widget')) {

    function count_total_time_widget($user_id = 0, $return_as_data = false) {
        $ci = get_instance();
        $options = array("user_id" => $user_id ? $user_id : $ci->login_user->id);
        $info = $ci->Attendance_model->count_total_time($options);
        $view_data["total_hours_worked"] = to_decimal_format($info->timecard_total / 60 / 60);
        $view_data["total_project_hours"] = to_decimal_format($info->timesheet_total / 60 / 60);
        return $ci->load->view("attendance/total_time_widget", $view_data, $return_as_data);
    }

}


/**
 * get social links widget
 * @param object $weblinks
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('social_links_widget')) {

    function social_links_widget($weblinks, $return_as_data = false) {
        $ci = get_instance();
        $view_data["weblinks"] = $weblinks;

        return $ci->load->view("users/social_links_widget", $view_data, $return_as_data);
    }

}


/**
 * count unread messages
 * @return number
 */
if (!function_exists('count_unread_message')) {

    function count_unread_message() {
        $ci = get_instance();
        return $ci->Messages_model->count_unread_message($ci->login_user->id);
    }

}


/**
 * count new tickets
 * @param string $ticket_types
 * @return number
 */
if (!function_exists('count_new_tickets')) {

    function count_new_tickets($ticket_types = "") {
        $ci = get_instance();
        return $ci->Tickets_model->count_new_tickets($ticket_types);
    }

}


/**
 * get all tasks kanban widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('all_tasks_kanban_widget')) {

    function all_tasks_kanban_widget($return_as_data = false) {
        $ci = get_instance();

        $projects = $ci->Tasks_model->get_my_projects_dropdown_list($ci->login_user->id)->result();
        $projects_dropdown = array(array("id" => "", "text" => "- " . lang("project") . " -"));
        foreach ($projects as $project) {
            if ($project->project_id && $project->project_title) {
                $projects_dropdown[] = array("id" => $project->project_id, "text" => $project->project_title);
            }
        }

        $team_members_dropdown = array(array("id" => "", "text" => "- " . lang("team_member") . " -"));
        $assigned_to_list = $ci->Users_model->get_dropdown_list(array("first_name", "last_name"), "id", array("deleted" => 0, "user_type" => "staff"));
        foreach ($assigned_to_list as $key => $value) {

            if ($key == $ci->login_user->id) {
                $team_members_dropdown[] = array("id" => $key, "text" => $value, "isSelected" => true);
            } else {
                $team_members_dropdown[] = array("id" => $key, "text" => $value);
            }
        }

        $view_data['team_members_dropdown'] = json_encode($team_members_dropdown);
        $view_data['projects_dropdown'] = json_encode($projects_dropdown);

        return $ci->load->view("projects/tasks/kanban/all_tasks_kanban_widget", $view_data, $return_as_data);
    }

}


/**
 * get todo lists widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('todo_list_widget')) {

    function todo_list_widget($return_as_data = false) {
        $ci = get_instance();
        return $ci->load->view("todo/todo_lists_widget", "", $return_as_data);
    }

}


/**
 * get invalid access widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('invalid_access_widget')) {

    function invalid_access_widget($return_as_data = false) {
        $ci = get_instance();
        return $ci->load->view("dashboards/custom_dashboards/invalid_access_widget", "", $return_as_data);
    }

}


/**
 * get open projects widget
 * @param integer $user_id
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('open_projects_widget')) {

    function open_projects_widget($user_id = 0, $return_as_data = false) {
        $ci = get_instance();
        $options = array(
            "user_id" => $user_id ? $user_id : $ci->login_user->id
        );
        $view_data["project_open"] = $ci->Projects_model->count_project_status($options)->open;
        return $ci->load->view("projects/widgets/open_projects_widget", $view_data, $return_as_data);
    }

}


/**
 * get completed projects widget
 * @param integer $user_id
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('completed_projects_widget')) {

    function completed_projects_widget($user_id = 0, $return_as_data = false) {
        $ci = get_instance();
        $options = array(
            "user_id" => $user_id ? $user_id : $ci->login_user->id
        );
        $view_data["project_completed"] = $ci->Projects_model->count_project_status($options)->completed;
        return $ci->load->view("projects/widgets/completed_projects_widget", $view_data, $return_as_data);
    }

}


/**
 * get count of clocked in users widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('count_clock_in_widget')) {

    function count_clock_in_widget($return_as_data = false) {
        $ci = get_instance();
        $info = $ci->Attendance_model->count_clock_status()->members_clocked_in;
        $view_data["members_clocked_in"] = $info ? $info : 0;
        return $ci->load->view("attendance/count_clock_in_widget", $view_data, $return_as_data);
    }

}


/**
 * get count of clocked out users widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('count_clock_out_widget')) {

    function count_clock_out_widget($return_as_data = false) {
        $ci = get_instance();
        $info = $ci->Attendance_model->count_clock_status()->members_clocked_out;
        $view_data["members_clocked_out"] = $info ? $info : 0;
        return $ci->load->view("attendance/count_clock_out_widget", $view_data, $return_as_data);
    }

}


/**
 * get user's open project list widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_open_projects_widget')) {

    function my_open_projects_widget($client_id = 0, $return_as_data = false) {
        $ci = get_instance();

        $options = array(
            "statuses" => "open",
            "user_id" => $ci->login_user->id
        );

        if ($ci->login_user->user_type == "client") {
            $options["client_id"] = $client_id;
        }

        $view_data["projects"] = $ci->Projects_model->get_details($options)->result();
        return $ci->load->view("projects/widgets/my_open_projects_widget", $view_data, $return_as_data);
    }

}


/**
 * get user's starred project list widget
 * @param integer $user_id
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_starred_projects_widget')) {

    function my_starred_projects_widget($user_id = 0, $return_as_data = false) {
        $ci = get_instance();

        $options = array(
            "user_id" => $user_id ? $user_id : $ci->login_user->id,
            "starred_projects" => true
        );

        $view_data["projects"] = $ci->Projects_model->get_details($options)->result();
        return $ci->load->view("projects/widgets/my_starred_projects_widget", $view_data, $return_as_data);
    }

}


/**
 * get sticky note widget for logged in user
 * @param string $custom_class
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('sticky_note_widget')) {

    function sticky_note_widget($custom_class = "", $return_as_data = false) {
        $ci = get_instance();
        return $ci->load->view("dashboards/sticky_note_widget", array("custom_class" => $custom_class), $return_as_data);
    }

}


/**
 * get ticket status small widget for current logged in user
 * @param integer $user_id
 * @param string $type ($type should be new/open/closed)
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('ticket_status_widget_small')) {

    function ticket_status_widget_small($data = array(), $return_as_data = false) {
        $ci = get_instance();
        $allowed_ticket_types = get_array_value($data, "allowed_ticket_types");
        $status = get_array_value($data, "status");

        $options = array("status" => $status);
        if ($ci->login_user->user_type == "staff") {
            $options["allowed_ticket_types"] = $allowed_ticket_types;
        } else {
            $options["client_id"] = $ci->login_user->client_id;
        }

        $view_data["total_tickets"] = $ci->Tickets_model->count_tickets($options);
        $view_data["status"] = $status;

        return $ci->load->view("tickets/ticket_status_widget_small", $view_data, $return_as_data);
    }

}


/**
 * get all team members widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('all_team_members_widget')) {

    function all_team_members_widget($return_as_data = false) {
        $ci = get_instance();
        $options = array("status" => "active", "user_type" => "staff");
        $view_data["members"] = $ci->Users_model->get_details($options)->result();
        return $ci->load->view("team_members/team_members_widget", $view_data, $return_as_data);
    }

}


/**
 * get all clocked in team members widget
 * @param array $data containing access permissions
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('clocked_in_team_members_widget')) {

    function clocked_in_team_members_widget($data = array(), $return_as_data = false) {
        $ci = get_instance();

        $options = array(
            "login_user_id" => $ci->login_user->id,
            "access_type" => get_array_value($data, "access_type"),
            "allowed_members" => get_array_value($data, "allowed_members"),
            "only_clocked_in_members" => true
        );

        $view_data["users"] = $ci->Attendance_model->get_details($options)->result();

        return $ci->load->view("team_members/clocked_in_team_members_widget", $view_data, $return_as_data);
    }

}


/**
 * get all clocked out team members widget
 * @param array $data containing access permissions
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('clocked_out_team_members_widget')) {

    function clocked_out_team_members_widget($data = array(), $return_as_data = false) {
        $ci = get_instance();

        $options = array(
            "login_user_id" => $ci->login_user->id,
            "access_type" => get_array_value($data, "access_type"),
            "allowed_members" => get_array_value($data, "allowed_members")
        );

        $view_data["users"] = $ci->Attendance_model->get_clocked_out_members($options)->result();
        return $ci->load->view("team_members/clocked_out_team_members_widget", $view_data, $return_as_data);
    }

}


/**
 * get active members widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('active_members_and_clients_widget')) {

    function active_members_and_clients_widget($user_type = "", $return_as_data = false) {
        $ci = get_instance();

        $options = array("user_type" => $user_type, "exclude_user_id" => $ci->login_user->id);

        $view_data["users"] = $ci->Users_model->get_active_members_and_clients($options)->result();
        $view_data["user_type"] = $user_type;
        return $ci->load->view("team_members/active_members_and_clients_widget", $view_data, $return_as_data);
    }

}


/**
 * get total invoices/payments/due value widget
 * @param string $type
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('get_invoices_value_widget')) {

    function get_invoices_value_widget($type = "", $return_as_data = false) {
        $ci = get_instance();

        $view_data["invoices_info"] = $ci->Invoices_model->get_invoices_total_and_paymnts();
        $view_data["type"] = $type;
        return $ci->load->view("invoices/total_invoices_value_widget", $view_data, $return_as_data);
    }

}


/**
 * get my tasks list widget
 * @param boolean $return_as_data
 * @return html
 */
if (!function_exists('my_tasks_list_widget')) {

    function my_tasks_list_widget($return_as_data = false) {
        $ci = get_instance();
        $view_data['task_statuses'] = $ci->Task_status_model->get_details()->result();
        return $ci->load->view("projects/tasks/my_tasks_list_widget", $view_data, $return_as_data);
    }

}


