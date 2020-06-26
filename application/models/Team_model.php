<?php

class Team_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'team';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $team_table = $this->db->dbprefix('team');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where = " AND $team_table.id=$id";
        }

        $sql = "SELECT $team_table.*
        FROM $team_table
        WHERE $team_table.deleted=0 $where";
        return $this->db->query($sql);
    }

    function get_members($team_ids = array()) {
        $team_table = $this->db->dbprefix('team');
        $team_ids = implode(",", $team_ids);

        $sql = "SELECT $team_table.members
        FROM $team_table
        WHERE $team_table.deleted=0 AND id in($team_ids)";
        return $this->db->query($sql);
    }

}
