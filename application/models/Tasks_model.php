<?php

class Tasks_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'tasks';
        parent::__construct($this->table);
        parent::init_activity_log("task", "title", "project", "project_id");
    }

    function schema() {
        return array(
            "id" => array(
                "label" => lang("id"),
                "type" => "int"
            ),
            "title" => array(
                "label" => lang("title"),
                "type" => "text"
            ),
            "description" => array(
                "label" => lang("description"),
                "type" => "text"
            ),
            "assigned_to" => array(
                "label" => lang("assigned_to"),
                "type" => "foreign_key",
                "linked_model" => $this->Users_model,
                "label_fields" => array("first_name", "last_name"),
            ),
            "collaborators" => array(
                "label" => lang("collaborators"),
                "type" => "foreign_key",
                "link_type" => "user_group_list",
                "linked_model" => $this->Users_model,
                "label_fields" => array("user_group_name"),
            ),
            "milestone_id" => array(
                "label" => lang("milestone"),
                "type" => "foreign_key",
                "linked_model" => $this->Milestones_model,
                "label_fields" => array("title"),
            ),
            "labels" => array(
                "label" => lang("labels"),
                "type" => "tag"
            ),
            "status" => array(
                "label" => lang("status"),
                "type" => "language_key" //we'are not using this field from 1.9 but don't delete it for existing data.
            ),
            "status_id" => array(
                "label" => lang("status"),
                "type" => "foreign_key",
                "linked_model" => $this->Task_status_model,
                "label_fields" => array("title"),
            ),
            "start_date" => array(
                "label" => lang("start_date"),
                "type" => "date"
            ),
            "deadline" => array(
                "label" => lang("deadline"),
                "type" => "date"
            ),
            "project_id" => array(
                "label" => lang("project"),
                "type" => "foreign_key"
            ),
            "points" => array(
                "label" => lang("points"),
                "type" => "int"
            ),
            "deleted" => array(
                "label" => lang("deleted"),
                "type" => "int"
            ),
            "sort" => array(
                "label" => lang("priority"),
                "type" => "int"
            )
        );
    }

    function get_details($options = array()) {
        $tasks_table = $this->db->dbprefix('tasks');
        $users_table = $this->db->dbprefix('users');
        $projects = $this->db->dbprefix('projects');
        $milestones_table = $this->db->dbprefix('milestones');
        $project_members_table = $this->db->dbprefix('project_members');
        $task_status_table = $this->db->dbprefix('task_status');

        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $tasks_table.id=$id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $tasks_table.project_id=$project_id";
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $projects.client_id=$client_id";
        }


        $status_ids = get_array_value($options, "status_ids");
        if ($status_ids) {
            $where .= " AND FIND_IN_SET($tasks_table.status_id,'$status_ids')";
        }

        $exclude_status_id = get_array_value($options, "exclude_status_id");
        if ($exclude_status_id) {
            $where .= " AND $tasks_table.status_id!=$exclude_status_id ";
        }


        $assigned_to = get_array_value($options, "assigned_to");
        if ($assigned_to) {
            $where .= " AND $tasks_table.assigned_to=$assigned_to";
        }

        $specific_user_id = get_array_value($options, "specific_user_id");
        if ($specific_user_id) {
            $where .= " AND ($tasks_table.assigned_to=$specific_user_id OR FIND_IN_SET('$specific_user_id', $tasks_table.collaborators))";
        }

        $project_status = get_array_value($options, "project_status");
        if ($project_status) {
            $where .= " AND FIND_IN_SET($projects.status,'$project_status')";
        }

        $milestone_id = get_array_value($options, "milestone_id");
        if ($milestone_id) {
            $where .= " AND $tasks_table.milestone_id=$milestone_id";
        }

        $deadline = get_array_value($options, "deadline");
        if ($deadline) {
            $now = get_my_local_time("Y-m-d");
            if ($deadline === "expired") {
                $where .= " AND (($tasks_table.deadline IS NOT NULL AND $tasks_table.deadline<'$now')  OR $milestones_table.due_date<'$now')";
            } else {
                $where .= " AND (($tasks_table.deadline IS NOT NULL AND $tasks_table.deadline<='$deadline') OR $milestones_table.due_date<='$deadline')";
            }
        }


        $extra_left_join = "";
        $project_member_id = get_array_value($options, "project_member_id");
        if ($project_member_id) {
            $where .= " AND $project_members_table.user_id=$project_member_id";
            $extra_left_join = " LEFT JOIN $project_members_table ON $tasks_table.project_id= $project_members_table.project_id AND $project_members_table.deleted=0 AND $project_members_table.user_id=$project_member_id";
        }

        $extra_select = ", 0 AS unread";
        $this->_set_unread_tasks_query($options, $tasks_table, $extra_select);


        //prepare custom fild binding query
        $custom_fields = get_array_value($options, "custom_fields");
        $custom_field_query_info = $this->prepare_custom_field_query_string("tasks", $custom_fields, $tasks_table);
        $select_custom_fieds = get_array_value($custom_field_query_info, "select_string");
        $join_custom_fieds = get_array_value($custom_field_query_info, "join_string");



        $sql = "SELECT $tasks_table.*, $task_status_table.key_name AS status_key_name, $task_status_table.title AS status_title,  $task_status_table.color AS status_color, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS assigned_to_user, $users_table.image as assigned_to_avatar, 
                    $projects.title AS project_title, $milestones_table.title AS milestone_title, IF($tasks_table.deadline IS NULL, $milestones_table.due_date,$tasks_table.deadline) AS deadline,
                    (SELECT GROUP_CONCAT($users_table.id, '--::--', $users_table.first_name, ' ', $users_table.last_name, '--::--' , IFNULL($users_table.image,'')) FROM $users_table WHERE FIND_IN_SET($users_table.id, $tasks_table.collaborators)) AS collaborator_list $select_custom_fieds 
                    $extra_select    
        FROM $tasks_table
        LEFT JOIN $users_table ON $users_table.id= $tasks_table.assigned_to
        LEFT JOIN $projects ON $tasks_table.project_id=$projects.id 
        LEFT JOIN $milestones_table ON $tasks_table.milestone_id=$milestones_table.id 
        LEFT JOIN $task_status_table ON $tasks_table.status_id = $task_status_table.id 
        $extra_left_join
        $join_custom_fieds    
        WHERE $tasks_table.deleted=0 $where";

        return $this->db->query($sql);
    }

    function get_kanban_details($options = array()) {
        $tasks_table = $this->db->dbprefix('tasks');
        $users_table = $this->db->dbprefix('users');
        $projects = $this->db->dbprefix('projects');
        $milestones_table = $this->db->dbprefix('milestones');
        $project_members_table = $this->db->dbprefix('project_members');

        $where = "";

        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $tasks_table.id=$id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $tasks_table.project_id=$project_id";
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $where .= " AND $projects.client_id=$client_id";
        }


        $status = get_array_value($options, "status");
        if ($status) {
            $where .= " AND FIND_IN_SET($tasks_table.status,'$status')";
        }

        $project_status = get_array_value($options, "project_status");
        if ($project_status) {
            $where .= " AND FIND_IN_SET($projects.status,'$project_status')";
        }

        $assigned_to = get_array_value($options, "assigned_to");
        if ($assigned_to) {
            $where .= " AND $tasks_table.assigned_to=$assigned_to";
        }

        $specific_user_id = get_array_value($options, "specific_user_id");
        if ($specific_user_id) {
            $where .= " AND ($tasks_table.assigned_to=$specific_user_id OR FIND_IN_SET('$specific_user_id', $tasks_table.collaborators))";
        }


        $milestone_id = get_array_value($options, "milestone_id");
        if ($milestone_id) {
            $where .= " AND $tasks_table.milestone_id=$milestone_id";
        }

        $deadline = get_array_value($options, "deadline");
        if ($deadline) {
            $now = get_my_local_time("Y-m-d");
            if ($deadline === "expired") {
                $where .= " AND (($tasks_table.deadline IS NOT NULL AND $tasks_table.deadline<'$now')  OR $milestones_table.due_date<'$now')";
            } else {
                $where .= " AND (($tasks_table.deadline IS NOT NULL AND $tasks_table.deadline<='$deadline') OR $milestones_table.due_date<='$deadline')";
            }
        }

        $search = get_array_value($options, "search");
        if ($search) {
            $where .= " AND ($tasks_table.title LIKE '%$search%' OR $tasks_table.labels LIKE '%$search%' OR $tasks_table.id='$search')";
        }


        $extra_left_join = "";
        $project_member_id = get_array_value($options, "project_member_id");
        if ($project_member_id) {
            $where .= " AND $project_members_table.user_id=$project_member_id";
            $extra_left_join = " LEFT JOIN $project_members_table ON $tasks_table.project_id= $project_members_table.project_id AND $project_members_table.deleted=0 AND $project_members_table.user_id=$project_member_id";
        }


        $extra_select = ", 0 AS unread";
        $this->_set_unread_tasks_query($options, $tasks_table, $extra_select);


        $sql = "SELECT $tasks_table.id, $tasks_table.title, $tasks_table.sort, IF($tasks_table.sort!=0, $tasks_table.sort, $tasks_table.id) AS new_sort, $tasks_table.assigned_to, $tasks_table.labels, $tasks_table.status_id, $tasks_table.project_id, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS assigned_to_user, $users_table.image as assigned_to_avatar $extra_select
        FROM $tasks_table
        LEFT JOIN $users_table ON $users_table.id= $tasks_table.assigned_to
        LEFT JOIN $projects ON $tasks_table.project_id=$projects.id 
        LEFT JOIN $milestones_table ON $tasks_table.milestone_id=$milestones_table.id 
        $extra_left_join    
        WHERE $tasks_table.deleted=0 $where 
        ORDER BY new_sort ASC";

        return $this->db->query($sql);
    }

    function _set_unread_tasks_query($options, $tasks_table, &$extra_select) {

        $notifications_table = $this->db->dbprefix("notifications");

        $unread_status_user_id = get_array_value($options, "unread_status_user_id");
        if ($unread_status_user_id) {
            $extra_select = ", (SELECT COUNT($notifications_table.task_id) FROM $notifications_table WHERE $notifications_table.deleted=0 AND $notifications_table.event='project_task_commented' AND $notifications_table.task_id=$tasks_table.id AND !FIND_IN_SET('$unread_status_user_id', $notifications_table.read_by) AND $notifications_table.user_id!=$unread_status_user_id) AS unread";
        }
    }

    function count_my_open_tasks($user_id) {
        $tasks_table = $this->db->dbprefix('tasks');
        $sql = "SELECT COUNT($tasks_table.id) AS total
        FROM $tasks_table
        WHERE $tasks_table.deleted=0  AND ($tasks_table.assigned_to=$user_id OR FIND_IN_SET('$user_id', $tasks_table.collaborators)) AND $tasks_table.status_id !=3";
        return $this->db->query($sql)->row()->total;
    }

    function get_label_suggestions($project_id) {
        $tasks_table = $this->db->dbprefix('tasks');
        $sql = "SELECT GROUP_CONCAT(labels) as label_groups
        FROM $tasks_table
        WHERE $tasks_table.deleted=0 AND $tasks_table.project_id=$project_id";
        return $this->db->query($sql)->row()->label_groups;
    }

    function get_my_projects_dropdown_list($user_id = 0) {
        $project_members_table = $this->db->dbprefix('project_members');
        $projects_table = $this->db->dbprefix('projects');

        $where = " AND $project_members_table.user_id=$user_id";

        $sql = "SELECT $project_members_table.project_id, $projects_table.title AS project_title
        FROM $project_members_table
        LEFT JOIN $projects_table ON $projects_table.id= $project_members_table.project_id
        WHERE $project_members_table.deleted=0 AND $projects_table.deleted=0 $where 
        GROUP BY $project_members_table.project_id";
        return $this->db->query($sql);
    }

    function get_task_statistics($options = array()) {
        $tasks_table = $this->db->dbprefix('tasks');
        $task_status_table = $this->db->dbprefix('task_status');

        try {
            $this->db->query("SET sql_mode = ''");
        } catch (Exception $e) {
            
        }
        $where = "";

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $tasks_table.project_id=$project_id";
        }

        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $where .= " AND $tasks_table.assigned_to=$user_id";
        }

        $sql = "SELECT COUNT($tasks_table.id) AS total, $tasks_table.status_id, $task_status_table.key_name, $task_status_table.title, $task_status_table.color
        FROM $tasks_table
        LEFT JOIN $task_status_table ON $task_status_table.id = $tasks_table.status_id
        WHERE $tasks_table.deleted=0 $where
        GROUP BY $tasks_table.status_id";
        return $this->db->query($sql)->result();
    }

    function set_task_comments_as_read($task_id, $user_id = 0) {
        $notifications_table = $this->db->dbprefix('notifications');

        $sql = "UPDATE $notifications_table SET $notifications_table.read_by = CONCAT($notifications_table.read_by,',',$user_id)
        WHERE $notifications_table.task_id=$task_id AND FIND_IN_SET($user_id, $notifications_table.read_by) = 0 AND $notifications_table.event='project_task_commented'";
        return $this->db->query($sql);
    }

}
