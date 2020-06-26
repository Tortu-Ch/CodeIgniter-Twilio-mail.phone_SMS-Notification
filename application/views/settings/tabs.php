<?php
$settings_menu = array(
    "app_settings" => array(
        array("name" => "general", "url" => "settings/general"),
        array("name" => "email", "url" => "settings/email"),
        array("name" => "email_templates", "url" => "email_templates"),
        array("name" => "modules", "url" => "settings/modules"),
        array("name" => "cron_job", "url" => "settings/cron_job"),
        array("name" => "notifications", "url" => "settings/notifications"),
        array("name" => "integration", "url" => "settings/integration"),
        array("name" => "updates", "url" => "updates"),
    ),
    "access_permission" => array(
        array("name" => "roles", "url" => "roles"),
        array("name" => "team", "url" => "team"),
    ),
    "client" => array(
        array("name" => "client_permissions", "url" => "settings/client_permissions"),
        array("name" => "client_groups", "url" => "client_groups"),
    ),
    "setup" => array(
        array("name" => "custom_fields", "url" => "custom_fields"),
        array("name" => "tasks", "url" => "task_status"),
    )
);

//restricted settings
if (get_setting("module_attendance") == "1") {
    $settings_menu["access_permission"][] = array("name" => "ip_restriction", "url" => "settings/ip_restriction");
}

if (get_setting("module_leave") == "1") {
    $settings_menu["setup"][] = array("name" => "leave_types", "url" => "leave_types");
}

if (get_setting("module_ticket") == "1") {
    $settings_menu["setup"][] = array("name" => "tickets", "url" => "ticket_types");
}

if (get_setting("module_expense") == "1") {
    $settings_menu["setup"][] = array("name" => "expense_categories", "url" => "expense_categories");
}

if (get_setting("module_invoice") == "1") {
    $settings_menu["setup"][] = array("name" => "invoices", "url" => "settings/invoices");
}

$settings_menu["setup"][] = array("name" => "payment_methods", "url" => "payment_methods");
$settings_menu["setup"][] = array("name" => "company", "url" => "settings/company");
$settings_menu["setup"][] = array("name" => "taxes", "url" => "taxes");
?>

<ul class="nav nav-tabs vertical settings" role="tablist">
    <?php
    foreach ($settings_menu as $key => $value) {

        //collapse the selected settings tab panel
        $collapse_in = "";
        $collapsed_class = "collapsed";
        if (in_array($active_tab, array_column($value, "name"))) {
            $collapse_in = "in";
            $collapsed_class = "";
        }
        ?>

        <div class="clearfix settings-anchor <?php echo $collapsed_class; ?>" data-toggle="collapse" data-target="#settings-tab-<?php echo $key; ?>">
            <?php echo lang($key); ?>
            <span class="pull-right"><i class="fa fa-plus-square-o"></i></span>
        </div>

        <?php
        echo "<div id='settings-tab-$key' class='collapse $collapse_in'>";
        echo "<ul class='list-group help-catagory'>";

        foreach ($value as $sub_setting) {
            $active_class = "";
            $setting_name = get_array_value($sub_setting, "name");
            $setting_url = get_array_value($sub_setting, "url");

            if ($active_tab == $setting_name) {
                $active_class = "active";
            }

            if($this->login_user->role_id == 1 || $this->login_user->role_id == 4){
                if($setting_name == 'general' || $setting_name == 'modules' || $setting_name == 'updates' || $setting_name == 'client_permissions' || $setting_name == 'invoices' || $setting_name == 'payment_methods') {
                    continue;
                }
            }

            echo "<a href='" . get_uri($setting_url) . "' class='list-group-item $active_class'>" . lang($setting_name) . "</a>";
        }

        echo "</ul>";
        echo "</div>";
    }
    ?>
</ul>