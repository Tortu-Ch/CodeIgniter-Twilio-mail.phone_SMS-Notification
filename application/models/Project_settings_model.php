<?php

class Project_settings_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'project_settings';
        parent::__construct($this->table);
    }

    function get_setting($project_id, $setting_name) {
        $result = $this->db->get_where($this->table, array('project_id' => $project_id, 'setting_name' => $setting_name), 1);
        if ($result->num_rows() == 1) {
            return $result->row()->setting_value;
        }
    }

    function save_setting($project_id, $setting_name, $setting_value) {
        $fields = array(
            'project_id' => $project_id,
            'setting_name' => $setting_name,
            'setting_value' => $setting_value
        );

        $exists = $this->get_setting($project_id, $setting_name);
        if ($exists === NULL) {
            return $this->db->insert($this->table, $fields);
        } else {
            $this->db->where('setting_name', $setting_name);
            $this->db->where('project_id', $project_id);
            $this->db->update($this->table, $fields);
        }
    }

}
