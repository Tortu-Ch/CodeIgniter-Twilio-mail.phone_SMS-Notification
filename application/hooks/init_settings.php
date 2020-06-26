<?php

function init_settings() {
    $ci = & get_instance();

    $login_user_id = $ci->Users_model->login_user_id();
    
    $settings = $ci->Settings_model->get_all_required_settings($login_user_id)->result();
    foreach ($settings as $setting) {
        $ci->config->set_item($setting->setting_name, $setting->setting_value);
    }

    $language = get_setting('user_' . $login_user_id . '_personal_language') ? get_setting('user_' . $login_user_id . '_personal_language') : get_setting("language");

    $ci->lang->load('default', $language);
    $ci->lang->load('custom', $language); //load custom after loading the default. because custom will overwrite the default file.
}
