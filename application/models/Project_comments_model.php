<?php

class Project_comments_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'project_comments';
        parent::__construct($this->table);
    }

    function schema() {
        return array(
            "id" => array(
                "label" => lang("id"),
                "type" => "int"
            ),
            "created_by" => array(
                "label" => lang("created_by"),
                "type" => "foreign_key",
                "linked_model" => $this->Users_model,
                "label_fields" => array("first_name", "last_name"),
            ),
            "created_at" => array(
                "label" => lang("created_date"),
                "type" => "date_time"
            ),
            "description" => array(
                "label" => lang("comment"),
                "type" => "text"
            ),
            "project_id" => array(
                "label" => lang("project"),
                "type" => "foreign_key",
                "linked_model" => $this->Projects_model,
                "label_fields" => array("title"),
            ),
            "task_id" => array(
                "label" => lang("task"),
                "type" => "foreign_key",
                "linked_model" => $this->Tasks_model,
                "label_fields" => array("id"),
            ),
            "file_id" => array(
                "label" => lang("project"),
                "type" => "foreign_key",
                "linked_model" => $this->Project_files_model,
                "label_fields" => array("id"),
            ),
            "customer_feedback_id" => array(
                "label" => lang("feedback"),
                "type" => "foreign_key",
                "linked_model" => $this->Project_comments_model,
                "label_fields" => array("description"),
            ),
            "comment_id" => array(
                "label" => lang("comment"),
                "type" => "foreign_key",
                "linked_model" => $this->Project_comments_model,
                "label_fields" => array("description"),
            ),
            "deleted" => array(
                "label" => lang("deleted"),
                "type" => "int"
            )
        );
    }

    function get_details($options = array()) {
        $project_comments_table = $this->db->dbprefix('project_comments');
        $users_table = $this->db->dbprefix('users');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $project_comments_table.id=$id";
        }

        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $where .= " AND $project_comments_table.project_id=$project_id AND $project_comments_table.task_id=0 AND $project_comments_table.file_id=0 and $project_comments_table.customer_feedback_id=0";
        }

        $task_id = get_array_value($options, "task_id");
        if ($task_id) {
            $where .= " AND $project_comments_table.task_id=$task_id";
        }

        $file_id = get_array_value($options, "file_id");
        if ($file_id) {
            $where .= " AND $project_comments_table.file_id=$file_id";
        }

        $customer_feedback_id = get_array_value($options, "customer_feedback_id");
        if ($customer_feedback_id) {
            $where .= " AND $project_comments_table.customer_feedback_id=$customer_feedback_id";
        }


        //show the main comments in descending mode
        //but show the replies in ascedning mode
        $sort = " DESC";
        $comment_id = get_array_value($options, "comment_id");
        if ($comment_id) {
            $where .= " AND $project_comments_table.comment_id=$comment_id";
            $sort = "ASC";
        } else {
            $where .= " AND $project_comments_table.comment_id=0";
        }

        $sql = "SELECT $project_comments_table.*, $project_comments_table.id AS parent_commment_id, CONCAT($users_table.first_name, ' ',$users_table.last_name) AS created_by_user, $users_table.image as created_by_avatar, $users_table.user_type,
            (SELECT COUNT($project_comments_table.id) as total_replies FROM $project_comments_table WHERE $project_comments_table.comment_id=parent_commment_id) AS total_replies
        FROM $project_comments_table
        LEFT JOIN $users_table ON $users_table.id= $project_comments_table.created_by
        WHERE $project_comments_table.deleted=0 $where
        ORDER BY $project_comments_table.created_at $sort";

        return $this->db->query($sql);
    }

    function save_comment($data) {
        //set extra info
        $comment_id = get_array_value($data, "comment_id");
        $file_id = get_array_value($data, "file_id");
        $task_id = get_array_value($data, "task_id");
        $customer_feedback_id = get_array_value($data, "customer_feedback_id");

        if (get_array_value($data, "description")) {
            parent::init_activity_log("project_comment", "description", "project", "project_id");
        }

        if ($comment_id) {
            $comment_info = parent::get_one($comment_id);
            $reply_type = "project_comment_reply";
            $data["project_id"] = $comment_info->project_id;
            $type = "";
            $type_id = "";
            if ($comment_info->task_id) {
                $data["task_id"] = $comment_info->task_id;
                $type = "task";
                $type_id = "task_id";
                $reply_type = "task_comment_reply";
            } else if ($comment_info->file_id) {
                $data["file_id"] = $comment_info->file_id;
                $type = "file";
                $type_id = "file_id";
                $reply_type = "file_comment_reply";
            } else if ($comment_info->customer_feedback_id) {
                $data["customer_feedback_id"] = $comment_info->customer_feedback_id;
                $type = "customer_feedback";
                $type_id = "customer_feedback_id";
                $reply_type = "customer_feedback_reply";
            }
            parent::init_activity_log($reply_type, "description", "project", "project_id", $type, $type_id);
        } else if ($file_id) {
            $file_info = $this->Project_files_model->get_one($file_id);
            $data["project_id"] = $file_info->project_id;
            parent::init_activity_log("project_comment", "description", "project", "project_id", "file", "file_id");
        } else if ($task_id) {
            $task_info = $this->Tasks_model->get_one($task_id);
            $data["project_id"] = $task_info->project_id;

            if (get_array_value($data, "description")) {
                parent::init_activity_log("task_comment", "description", "project", "project_id", "task", "task_id");
            }
        } else if ($customer_feedback_id) {
            $data["project_id"] = $customer_feedback_id;
            parent::init_activity_log("customer_feedback", "description", "project", "project_id", "customer_feedback", "customer_feedback_id");
        }
        return parent::save($data);
    }

}
