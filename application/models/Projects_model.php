<?php

class Projects_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'projects';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $projects_table = $this->db->dbprefix('projects');
        $project_members_table = $this->db->dbprefix('project_members');
        $clients_table = $this->db->dbprefix('clients');
        $tasks_table = $this->db->dbprefix('tasks');
        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $projects_table.id=$id";
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $projects_table.client_id=$client_id";
        }

        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND $projects_table.status='$status'";
        }

        $statuses = get_array_value($options, "statuses");
        if ($statuses) {
            $where .= " AND (FIND_IN_SET($projects_table.status, '$statuses')) ";
        }


        $project_label = get_array_value($options, "project_label");
        if ($project_label) {
            $where .= " AND (FIND_IN_SET('$project_label', $projects_table.labels)) ";
        }


        $deadline = get_array_value($options, "deadline");
        if ($deadline) {
            $now = get_my_local_time("Y-m-d");
            if ($deadline === "expired") {
                $where .= " AND ($projects_table.deadline IS NOT NULL AND $projects_table.deadline<'$now')";
            } else {
                $where .= " AND ($projects_table.deadline IS NOT NULL AND $projects_table.deadline<='$deadline')";
            }
        }


        $extra_join = "";
        $extra_where = "";
        $user_id = get_array_value($options, "user_id");

        $starred_projects = get_array_value($options, "starred_projects");
        if ($starred_projects) {
            $where .= " AND FIND_IN_SET(':$user_id:',$projects_table.starred_by) ";
        }

        if (!$client_id && $user_id && !$starred_projects) {
            $extra_join = " LEFT JOIN (SELECT $project_members_table.user_id, $project_members_table.project_id FROM $project_members_table WHERE $project_members_table.user_id=$user_id AND $project_members_table.deleted=0 GROUP BY $project_members_table.project_id) AS project_members_table ON project_members_table.project_id= $projects_table.id ";
            $extra_where = " AND project_members_table.user_id=$user_id";
        }

        //prepare custom fild binding query
        $custom_fields = get_array_value($options, "custom_fields");
        $custom_field_query_info = $this->prepare_custom_field_query_string("projects", $custom_fields, $projects_table);
        $select_custom_fieds = get_array_value($custom_field_query_info, "select_string");
        $join_custom_fieds = get_array_value($custom_field_query_info, "join_string");

        $this->db->query('SET SQL_BIG_SELECTS=1');

        $sql = "SELECT $projects_table.*, $clients_table.company_name, $clients_table.currency_symbol,  total_points_table.total_points, completed_points_table.completed_points $select_custom_fieds
        FROM $projects_table
        LEFT JOIN $clients_table ON $clients_table.id= $projects_table.client_id
        LEFT JOIN (SELECT project_id, SUM(points) AS total_points FROM $tasks_table WHERE deleted=0 GROUP BY project_id) AS  total_points_table ON total_points_table.project_id= $projects_table.id
        LEFT JOIN (SELECT project_id, SUM(points) AS completed_points FROM $tasks_table WHERE deleted=0 AND status_id=3 GROUP BY project_id) AS  completed_points_table ON completed_points_table.project_id= $projects_table.id
        $extra_join   
        $join_custom_fieds    
        WHERE $projects_table.deleted=0 $where $extra_where
        ORDER BY $projects_table.start_date DESC";
        return $this->db->query($sql);
    }

    function get_label_suggestions() {
        $projects_table = $this->db->dbprefix('projects');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $projects_table
        WHERE $projects_table.deleted=0";
        return $this->db->query($sql)->row()->label_groups;
    }

    function count_project_status($options = array()) {
        $projects_table = $this->db->dbprefix('projects');
        $project_members_table = $this->db->dbprefix('project_members');

        $extra_join = "";
        $extra_where = "";
        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $extra_join = " LEFT JOIN (SELECT $project_members_table.user_id, $project_members_table.project_id FROM $project_members_table WHERE $project_members_table.user_id=$user_id AND $project_members_table.deleted=0 GROUP BY $project_members_table.project_id) AS project_members_table ON project_members_table.project_id= $projects_table.id ";
            $extra_where = " AND project_members_table.user_id=$user_id";
        }

        $sql = "SELECT $projects_table.status, COUNT($projects_table.id) as total
        FROM $projects_table
              $extra_join    
        WHERE $projects_table.deleted=0 AND ($projects_table.status='open' OR  $projects_table.status='completed') $extra_where
        GROUP BY $projects_table.status";
        $result = $this->db->query($sql)->result();

        $info = new stdClass();
        $info->open = 0;
        $info->completed = 0;
        foreach ($result as $value) {
            $status = $value->status;
            $info->$status = $value->total;
        }
        return $info;
    }

    function get_gantt_data($project_id = 0, $options = array()) {
        $tasks_table = $this->db->dbprefix('tasks');
        $milestones_table = $this->db->dbprefix('milestones');
        $users_table = $this->db->dbprefix('users');
        $task_status_table = $this->db->dbprefix('task_status');

        $where = "";

        $milestone_id = get_array_value($options, "milestone_id");
        if ($milestone_id) {
            $where .= " AND $tasks_table.milestone_id=$milestone_id";
        }

        $assigned_to = get_array_value($options, "assigned_to");
        if ($assigned_to) {
            $where .= " AND $tasks_table.assigned_to=$assigned_to";
        }

        $status_id = get_array_value($options, "status_id");
        if ($status_id) {
            $where .= " AND $tasks_table.status_id=$status_id";
        }

        $sql = "SELECT $tasks_table.id AS task_id, $tasks_table.title AS task_title, $tasks_table.status_id, $tasks_table.start_date, $tasks_table.deadline AS end_date, 
             $milestones_table.id AS milestone_id, $milestones_table.title AS milestone_title, $milestones_table.due_date AS milestone_due_date, $tasks_table.assigned_to, CONCAT($users_table.first_name, ' ', $users_table.last_name ) AS assigned_to_name,
             $task_status_table.title AS status_title, $task_status_table.color AS status_color
                FROM $tasks_table
                LEFT JOIN $milestones_table ON $milestones_table.id= $tasks_table.milestone_id
                LEFT JOIN $users_table ON $users_table.id= $tasks_table.assigned_to
                LEFT JOIN $task_status_table ON $task_status_table.id =  $tasks_table.status_id
        WHERE $tasks_table.deleted=0 AND $tasks_table.project_id=$project_id $where
        ORDER BY $tasks_table.start_date, $milestones_table.due_date DESC";
        return $this->db->query($sql)->result();
    }

    function add_remove_star($project_id, $user_id, $type = "add") {
        $projects_table = $this->db->dbprefix('projects');

        $action = " CONCAT($projects_table.starred_by,',',':$user_id:') ";
        $where = " AND FIND_IN_SET(':$user_id:',$projects_table.starred_by) = 0"; //don't add duplicate

        if ($type != "add") {
            $action = " REPLACE($projects_table.starred_by, ',:$user_id:', '') ";
            $where = "";
        }

        $sql = "UPDATE $projects_table SET $projects_table.starred_by = $action
        WHERE $projects_table.id=$project_id $where";
        return $this->db->query($sql);
    }

    function get_starred_projects($user_id) {
        $projects_table = $this->db->dbprefix('projects');

        $sql = "SELECT $projects_table.*
        FROM $projects_table
        WHERE $projects_table.deleted=0 AND FIND_IN_SET(':$user_id:',$projects_table.starred_by)
        ORDER BY $projects_table.title ASC";
        return $this->db->query($sql);
    }

    function delete_project_and_sub_items($project_id) {
        $projects_table = $this->db->dbprefix('projects');
        $tasks_table = $this->db->dbprefix('tasks');
        $milestones_table = $this->db->dbprefix('milestones');
        $project_files_table = $this->db->dbprefix('project_files');
        $project_comments_table = $this->db->dbprefix('project_comments');
        $activity_logs_table = $this->db->dbprefix('activity_logs');
        $notifications_table = $this->db->dbprefix('notifications');

        //get project files info to delete the files from directory 
        $project_files_sql = "SELECT * FROM $project_files_table WHERE $project_files_table.deleted=0 AND $project_files_table.project_id=$project_id; ";
        $project_files = $this->db->query($project_files_sql)->result();

        //get project comments info to delete the files from directory 
        $project_comments_sql = "SELECT * FROM $project_comments_table WHERE $project_comments_table.deleted=0 AND $project_comments_table.project_id=$project_id; ";
        $project_comments = $this->db->query($project_comments_sql)->result();

        //delete the project and sub items
        $delete_project_sql = "UPDATE $projects_table SET $projects_table.deleted=1 WHERE $projects_table.id=$project_id; ";
        $this->db->query($delete_project_sql);

        $delete_tasks_sql = "UPDATE $tasks_table SET $tasks_table.deleted=1 WHERE $tasks_table.project_id=$project_id; ";
        $this->db->query($delete_tasks_sql);

        $delete_milestones_sql = "UPDATE $milestones_table SET $milestones_table.deleted=1 WHERE $milestones_table.project_id=$project_id; ";
        $this->db->query($delete_milestones_sql);

        $delete_files_sql = "UPDATE $project_files_table SET $project_files_table.deleted=1 WHERE $project_files_table.project_id=$project_id; ";
        $this->db->query($delete_files_sql);

        $delete_comments_sql = "UPDATE $project_comments_table SET $project_comments_table.deleted=1 WHERE $project_comments_table.project_id=$project_id; ";
        $this->db->query($delete_comments_sql);

        $delete_activity_logs_sql = "UPDATE $activity_logs_table SET $activity_logs_table.deleted=1 WHERE $activity_logs_table.log_for='project' AND $activity_logs_table.log_for_id=$project_id; ";
        $this->db->query($delete_activity_logs_sql);

        $delete_notifications_sql = "UPDATE $notifications_table SET $notifications_table.deleted=1 WHERE $notifications_table.project_id=$project_id; ";
        $this->db->query($delete_notifications_sql);


        //delete the files from directory
        $comment_file_path = get_setting("timeline_file_path");
        foreach ($project_comments as $comment_info) {
            if ($comment_info->files && $comment_info->files != "a:0:{}") {
                $files = unserialize($comment_info->files);
                foreach ($files as $file) {
                    $source_path = $comment_file_path . get_array_value($file, "file_name");
                    delete_file_from_directory($source_path);
                }
            }
        }



        //delete the project files from directory
        $file_path = get_setting("project_file_path");
        foreach ($project_files as $file) {
            delete_file_from_directory($file_path . $file->project_id . "/" . $file->file_name);
        }

        return true;
    }

}
