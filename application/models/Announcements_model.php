<?php

class Announcements_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'announcements';
        parent::__construct($this->table);
    }

    function get_unread_announcements($user_id, $user_type) {
        $announcements_table = $this->db->dbprefix('announcements');
        $where = "";
        $now = get_my_local_time("Y-m-d");


        $where .= " AND FIND_IN_SET($user_id,$announcements_table.read_by) = 0";
        if ($user_type === "staff") {
            $where .= " AND FIND_IN_SET('all_members',$announcements_table.share_with)";
        } else if ($user_type === "client") {
            $where .= " AND FIND_IN_SET('all_clients',$announcements_table.share_with)";
        }
        $sql = "SELECT $announcements_table.*
        FROM $announcements_table
        WHERE $announcements_table.deleted=0 AND start_date<='$now' AND end_date>='$now' $where";
        return $this->db->query($sql);
    }

    function get_details($options = array()) {
        $announcements_table = $this->db->dbprefix('announcements');
        $users_table = $this->db->dbprefix('users');

        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $announcements_table.id=$id";
        }

        $share_with = get_array_value($options, "share_with");
        if ($share_with) {
            $where .= " AND FIND_IN_SET('$share_with', $announcements_table.share_with)";
        }

        $sql = "SELECT $announcements_table.*, CONCAT($users_table.first_name, ' ', $users_table.last_name) AS created_by_user, $users_table.image AS created_by_avatar
        FROM $announcements_table
        LEFT JOIN $users_table ON $users_table.id= $announcements_table.created_by
        WHERE $announcements_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function mark_as_read($id, $user_id) {
        $announcements_table = $this->db->dbprefix('announcements');
        $sql = "UPDATE $announcements_table SET $announcements_table.read_by = CONCAT($announcements_table.read_by,',',$user_id)
        WHERE $announcements_table.id=$id AND FIND_IN_SET($user_id,$announcements_table.read_by) = 0";
        return $this->db->query($sql);
    }

}
