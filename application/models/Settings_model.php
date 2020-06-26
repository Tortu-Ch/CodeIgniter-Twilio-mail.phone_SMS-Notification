<?php

class Settings_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'settings';
        parent::__construct($this->table);
    }

    function get_setting($setting_name) {
        $result = $this->db->get_where($this->table, array('setting_name' => $setting_name), 1);
        if ($result->num_rows() == 1) {
            return $result->row()->setting_value;
        }
    }

    function save_setting($setting_name, $setting_value, $type = "app") {
        $fields = array(
            'setting_name' => $setting_name,
            'setting_value' => $setting_value
        );

        $exists = $this->get_setting($setting_name);
        if ($exists === NULL) {
            $fields["type"] = $type; //type can't be updated

            return $this->db->insert($this->table, $fields);
        } else {
            $this->db->where('setting_name', $setting_name);
            $this->db->update($this->table, $fields);
        }
    }

    //find all app settings and login user's setting
    //user's settings are saved like this: user_[userId]_settings_name;
    function get_all_required_settings($user_id = 0) {
        $settings_table = $this->db->dbprefix('settings');
        $sql = "SELECT $settings_table.setting_name,  $settings_table.setting_value
        FROM $settings_table
        WHERE $settings_table.deleted=0 AND ($settings_table.type = 'app' OR ($settings_table.type ='user' AND $settings_table.setting_name LIKE 'user_" . $user_id . "_%'))";
        return $this->db->query($sql);
    }

}
