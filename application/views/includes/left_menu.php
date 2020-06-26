<div id="sidebar" class="box-content ani-width">
    <div id="sidebar-scroll">
        <ul class="" id="sidebar-menu">
            <?php
            
            $dashboard_menu = array("name" => "dashboard", "url" => "dashboard", "class" => "fa-desktop dashboard-menu");
            
            $selected_dashboard_id = get_setting("user_" . $this->login_user->id . "_dashboard");
            if ($selected_dashboard_id) {
                $dashboard_menu = array("name" => "dashboard", "url" => "dashboard/view/" . $selected_dashboard_id, "class" => "fa-desktop dashboard-menu");
            }
            
            
            if ($this->login_user->user_type == "staff") {

                $sidebar_menu = array();

                $sidebar_menu[] = $dashboard_menu;

                $permissions = $this->login_user->permissions;

                $access_expense = get_array_value($permissions, "expense");
                $access_invoice = get_array_value($permissions, "invoice");
                $access_ticket = get_array_value($permissions, "ticket");
                $access_client = get_array_value($permissions, "client");
                $access_timecard = get_array_value($permissions, "attendance");
                $access_leave = get_array_value($permissions, "leave");
                $access_estimate = get_array_value($permissions, "estimate");
                $access_items = ($this->login_user->is_admin || $access_invoice || $access_estimate);

                $manage_help_and_knowledge_base = ($this->login_user->is_admin || get_array_value($permissions, "help_and_knowledge_base"));
                $manage_timesheets = ($this->login_user->is_admin || get_array_value($permissions, "timesheet_manage_permission"));


                if (get_setting("module_timeline") == "1") {
                    $sidebar_menu[] = array("name" => "timeline", "url" => "timeline", "class" => " fa-comments font-18");
                }

                if (get_setting("module_event") == "1") {
                    $sidebar_menu[] = array("name" => "events", "url" => "events", "class" => "fa-calendar");
                }

                if (get_setting("module_note") == "1") {
                    $sidebar_menu[] = array("name" => "notes", "url" => "notes", "class" => "fa-book font-16");
                }

                if (get_setting("module_message") == "1") {
                    $sidebar_menu[] = array("name" => "messages", "url" => "messages", "class" => "fa-envelope", "devider" => true, "badge" => count_unread_message(), "badge_class" => "badge-secondary");
                }


                if ($this->login_user->is_admin || $access_client) {
                    $sidebar_menu[] = array("name" => "clients", "url" => "clients", "class" => "fa-briefcase");
                }




                $project_submenu = array(
                    array("name" => "all_projects", "url" => "projects/all_projects"),
                    array("name" => "tasks", "url" => "projects/all_tasks"));

                if ($manage_timesheets && get_setting("module_project_timesheet")) {
                    $project_submenu[] = array("name" => "timesheets", "url" => "projects/all_timesheets");
                }

                $sidebar_menu[] = array("name" => "projects", "url" => "projects", "class" => "fa-th-large",
                    "submenu" => $project_submenu
                );

                if (get_setting("module_estimate") && get_setting("module_estimate_request") && ($this->login_user->is_admin || $access_estimate)) {

                    $sidebar_menu[] = array("name" => "estimates", "url" => "estimates", "class" => "fa-file",
                        "submenu" => array(
                            array("name" => "estimate_list", "url" => "estimates"),
                            array("name" => "estimate_requests", "url" => "estimate_requests"),
                            array("name" => "estimate_forms", "url" => "estimate_requests/estimate_forms")
                        )
                    );
                } else if (get_setting("module_estimate") && ($this->login_user->is_admin || $access_estimate)) {
                    $sidebar_menu[] = array("name" => "estimates", "url" => "estimates", "class" => "fa-file");
                }

                if (get_setting("module_invoice") == "1" && ($this->login_user->is_admin || $access_invoice)) {
                    $sidebar_menu[] = array("name" => "invoices", "url" => "invoices", "class" => "fa-file-text");
                }

                if ($access_items && (get_setting("module_invoice") == "1" || get_setting("module_estimate") == "1" )) {
                    $sidebar_menu[] = array("name" => "items", "url" => "items", "class" => "fa-list-ul");
                }

                if ((get_setting("module_invoice") == "1" || get_setting("module_expense") == "1") && ($this->login_user->is_admin || $access_expense || $access_invoice)) {
                    $finance_submenu = array();
                    $finance_url = "";
                    $show_payments_menu = false;
                    $show_expenses_menu = false;


                    if (get_setting("module_invoice") == "1" && ($this->login_user->is_admin || $access_invoice)) {
                        $finance_submenu[] = array("name" => "invoice_payments", "url" => "invoice_payments");
                        $finance_url = "invoice_payments";
                        $show_payments_menu = true;
                    }
                    if (get_setting("module_expense") == "1" && ($this->login_user->is_admin || $access_expense)) {
                        $finance_submenu[] = array("name" => "expenses", "url" => "expenses");
                        $finance_url = "expenses";
                        $show_expenses_menu = true;
                    }

                    if ($show_expenses_menu && $show_payments_menu) {
                        $finance_submenu[] = array("name" => "income_vs_expenses", "url" => "expenses/income_vs_expenses");
                    }

                    $sidebar_menu[] = array("name" => "finance", "url" => $finance_url, "class" => "fa-money", "submenu" => $finance_submenu);
                }

                if (get_setting("module_ticket") == "1" && ($this->login_user->is_admin || $access_ticket)) {

                    $ticket_badge = 0;
                    if ($this->login_user->is_admin || $access_ticket === "all") {
                        $ticket_badge = count_new_tickets();
                    } else if ($access_ticket === "specific") {
                        $specific_ticket_permission = get_array_value($permissions, "ticket_specific");
                        $ticket_badge = count_new_tickets($specific_ticket_permission);
                    }

                    // 

                    $sidebar_menu[] = array("name" => "tickets", "url" => "tickets", "class" => "fa-life-ring", "devider" => true, "badge" => $ticket_badge, "badge_class" => "badge-secondary");
                }


                if (get_array_value($this->login_user->permissions, "hide_team_members_list") != "1") {
                    $sidebar_menu[] = array("name" => "team_members", "url" => "team_members", "class" => "fa-user font-16");
                }


                if (get_setting("module_attendance") == "1" && ($this->login_user->is_admin || $access_timecard)) {
                    $sidebar_menu[] = array("name" => "attendance", "url" => "attendance", "class" => "fa-clock-o font-16");
                } else if (get_setting("module_attendance") == "1") {
                    $sidebar_menu[] = array("name" => "attendance", "url" => "attendance/attendance_info", "class" => "fa-clock-o font-16");
                }

                if (get_setting("module_leave") == "1" && ($this->login_user->is_admin || $access_leave)) {
                    $sidebar_menu[] = array("name" => "leaves", "url" => "leaves", "class" => "fa-sign-out font-16", "devider" => true);
                } else if (get_setting("module_leave") == "1") {
                    $sidebar_menu[] = array("name" => "leaves", "url" => "leaves/leave_info", "class" => "fa-sign-out font-16", "devider" => true);
                }

                if (get_setting("module_announcement") == "1") {
                    $sidebar_menu[] = array("name" => "announcements", "url" => "announcements", "class" => "fa-bullhorn");
                }


                $module_help = get_setting("module_help") == "1" ? true : false;
                $module_knowledge_base = get_setting("module_knowledge_base") == "1" ? true : false;

                //prepere the help and suppor menues
                if ($module_help || $module_knowledge_base) {

                    $help_knowledge_base_menues = array();
                    $main_url = "help";

                    if ($module_help) {
                        $help_knowledge_base_menues[] = array("name" => "help", "url" => $main_url);
                    }

                    //push the help manage menu if user has access
                    if ($manage_help_and_knowledge_base && $module_help) {
                        $help_knowledge_base_menues[] = array("name" => "articles", "url" => "help/help_articles");
                        $help_knowledge_base_menues[] = array("name" => "categories", "url" => "help/help_categories");
                    }

                    if ($module_knowledge_base) {
                        $help_knowledge_base_menues[] = array("name" => "knowledge_base", "url" => "knowledge_base");
                    }

                    //push the knowledge_base manage menu if user has access
                    if ($manage_help_and_knowledge_base && $module_knowledge_base) {
                        $help_knowledge_base_menues[] = array("name" => "articles", "category" => "help", "url" => "help/knowledge_base_articles");
                        $help_knowledge_base_menues[] = array("name" => "categories", "category" => "help", "url" => "help/knowledge_base_categories");
                    }


                    if (!$module_help) {
                        $main_url = "knowledge_base";
                    }

                    $sidebar_menu[] = array("name" => "help_and_support", "url" => $main_url, "class" => "fa-question-circle",
                        "submenu" => $help_knowledge_base_menues
                    );
                }



                //if ($this->login_user->is_admin) {
                    $sidebar_menu[] = array("name" => "settings", "url" => "settings/general", "class" => "fa-wrench");
                //}
            } else {
                //client menu
                //get the array of hidden menu
                $hidden_menu = explode(",", get_setting("hidden_client_menus"));

                $sidebar_menu[] = $dashboard_menu;

                if (get_setting("module_event") == "1" && !in_array("events", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "events", "url" => "events", "class" => "fa-calendar");
                }

                //check message access settings for clients
                if (get_setting("module_message") && get_setting("client_message_users")) {
                    $sidebar_menu[] = array("name" => "messages", "url" => "messages", "class" => "fa-envelope", "badge" => count_unread_message());
                }

                if (!in_array("projects", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "projects", "url" => "projects/all_projects", "class" => "fa fa-th-large");
                }


                if (get_setting("module_estimate") && !in_array("estimates", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "estimates", "url" => "estimates", "class" => "fa-file");
                }

                if (get_setting("module_invoice") == "1") {
                    if (!in_array("invoices", $hidden_menu)) {
                        $sidebar_menu[] = array("name" => "invoices", "url" => "invoices", "class" => "fa-file-text");
                    }
                    if (!in_array("payments", $hidden_menu)) {
                        $sidebar_menu[] = array("name" => "invoice_payments", "url" => "invoice_payments", "class" => "fa-money");
                    }
                }

                if (get_setting("module_ticket") == "1" && !in_array("tickets", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "tickets", "url" => "tickets", "class" => "fa-life-ring");
                }

                if (get_setting("module_announcement") == "1" && !in_array("announcements", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "announcements", "url" => "announcements", "class" => "fa-bullhorn");
                }

                $sidebar_menu[] = array("name" => "users", "url" => "clients/users", "class" => "fa-user");
                $sidebar_menu[] = array("name" => "my_profile", "url" => "clients/contact_profile/" . $this->login_user->id, "class" => "fa-cog");

                if (get_setting("module_knowledge_base") == "1" && !in_array("knowledge_base", $hidden_menu)) {
                    $sidebar_menu[] = array("name" => "knowledge_base", "url" => "knowledge_base", "class" => "fa-question-circle");
                }
            }

            foreach ($sidebar_menu as $main_menu) {
                $submenu = get_array_value($main_menu, "submenu");
                $expend_class = $submenu ? " expand " : "";
                $active_class = active_menu($main_menu['name'], $submenu);
                $submenu_open_class = "";
                if ($expend_class && $active_class) {
                    $submenu_open_class = " open ";
                }

                $devider_class = get_array_value($main_menu, "devider") ? "devider" : "";
                $badge = get_array_value($main_menu, "badge");
                $badge_class = get_array_value($main_menu, "badge_class");
                ?>
                <li class="<?php echo $active_class . " " . $expend_class . " " . $submenu_open_class . " $devider_class"; ?> main">
                    <a href="<?php echo_uri($main_menu['url']); ?>">
                        <i class="fa <?php echo ($main_menu['class']); ?>"></i>
                        <span><?php echo lang($main_menu['name']); ?></span>
                        <?php
                        if ($badge) {
                            echo "<span class='badge $badge_class'>$badge</span>";
                        }
                        ?>
                    </a>
                    <?php
                    if ($submenu) {
                        echo "<ul>";
                        foreach ($submenu as $s_menu) {
                            ?>
                        <li>
                            <a href="<?php echo_uri($s_menu['url']); ?>">
                                <i class="dot fa fa-circle"></i>
                                <span><?php echo lang($s_menu['name']); ?></span>
                            </a>
                        </li>
                        <?php
                    }
                    echo "</ul>";
                }
                ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div><!-- sidebar menu end -->