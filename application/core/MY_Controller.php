<?php

class MY_Controller extends CI_Controller {

    public $login_user;
    protected $access_type = "";
    protected $allowed_members = array();
    protected $allowed_ticket_types = array();
    protected $module_group = "";

    function __construct() {
        parent::__construct();

        //check user's login status, if not logged in redirect to signin page
        $login_user_id = $this->Users_model->login_user_id();
        if (!$login_user_id) {
            $uri_string = uri_string();

            if (!$uri_string || $uri_string === "signin") {
                redirect('signin');
            } else {
                redirect('signin?redirect=' . get_uri($uri_string));
            }
        }

        //initialize login users required information
        $this->login_user = $this->Users_model->get_access_info($login_user_id);

        //initialize login users access permissions
        if ($this->login_user->permissions) {
            $permissions = unserialize($this->login_user->permissions);
            $this->login_user->permissions = is_array($permissions) ? $permissions : array();
        } else {
            $this->login_user->permissions = array();
        }
    }

    //initialize the login user's permissions with readable format
    protected function init_permission_checker($module) {
        $info = $this->get_access_info($module);
        $this->access_type = $info->access_type;
        $this->allowed_members = $info->allowed_members;
        $this->allowed_ticket_types = $info->allowed_ticket_types;
        $this->module_group = $info->module_group;
    }

    //prepear the login user's permissions
    protected function get_access_info($group) {
        $info = new stdClass();
        $info->access_type = "";
        $info->allowed_members = array();
        $info->allowed_ticket_types = array();
        $info->module_group = $group;

        //admin users has access to everything
        if ($this->login_user->is_admin) {
            $info->access_type = "all";
        } else {

            //not an admin user? check module wise access permissions
            $module_permission = get_array_value($this->login_user->permissions, $group);

            if ($module_permission === "all") {
                //this user's has permission to access/manage everything of this module (same as admin)
                $info->access_type = "all";
            } else if ($module_permission === "specific") {
                //this user's has permission to access/manage sepcific items of this module

                $info->access_type = "specific";
                $module_permission = get_array_value($this->login_user->permissions, $group . "_specific");
                $permissions = explode(",", $module_permission);

                //check the accessable users list
                if ($group === "leave" || $group === "attendance" || $group === "team_member_update_permission" || $group === "timesheet_manage_permission") {
                    $info->allowed_members = array($this->login_user->id);
                    $allowed_teams = array();
                    foreach ($permissions as $vlaue) {
                        $permission_on = explode(":", $vlaue);
                        $type = get_array_value($permission_on, "0");
                        $type_value = get_array_value($permission_on, "1");
                        if ($type === "member") {
                            array_push($info->allowed_members, $type_value);
                        } else if ($type === "team") {
                            array_push($allowed_teams, $type_value);
                        }
                    }


                    if (count($allowed_teams)) {
                        $team = $this->Team_model->get_members($allowed_teams)->result();

                        foreach ($team as $value) {
                            if ($value->members) {
                                $members_array = explode(",", $value->members);
                                $info->allowed_members = array_merge($info->allowed_members, $members_array);
                            }
                        }
                    }
                } else if ($group === "ticket") {
                    //check the accessable ticket types
                    $info->allowed_ticket_types = $permissions;
                }
            }
        }
        return $info;
    }

    //only allowed to access for team members 
    protected function access_only_team_members() {
        if ($this->login_user->user_type !== "staff") {
            redirect("forbidden");
        }
    }

    //only allowed to access for admin users
    protected function access_only_admin() {
        if (!$this->login_user->is_admin) {
            redirect("forbidden");
        }
    }


    protected function access_only_super_and_admin() {
        if ((!$this->login_user->is_admin) && (!$this->login_user->role_title == 'Super Admin')) {
            redirect("forbidden");
        }
    }

    protected function access_only_super_and_admin_and_manager() {
        if ((!$this->login_user->is_admin) && (!$this->login_user->role_title == 'Super Admin') && (!$this->login_user->role_title == 'Manager')) {
            redirect("forbidden");
        }
    }

    //access only allowed team members
    protected function access_only_allowed_members() {
        if ($this->access_type === "all") {
            return true; //can access if user has permission
        } else if ($this->module_group === "ticket" && $this->access_type === "specific") {
            return true; //can access if it's tickets module and user has a pertial access
        } else {
            redirect("forbidden");
        }
    }

    //access only allowed team members or client contacts 
    protected function access_only_allowed_members_or_client_contact($client_id) {

        if ($this->access_type === "all") {
            return true; //can access if user has permission
        } else if ($this->module_group === "ticket" && $this->access_type === "specific") {
            return true; //can access if it's tickets module and user has a pertial access
        } else if ($this->login_user->client_id === $client_id) {
            return true; //can access if client id match 
        } else {
            redirect("forbidden");
        }
    }

    //allowed team members and clint himself can access  
    protected function access_only_allowed_members_or_contact_personally($user_id) {
        if (!($this->access_type === "all" || $user_id === $this->login_user->id)) {
            redirect("forbidden");
        }
    }

    //access all team members and client contact
    protected function access_only_team_members_or_client_contact($client_id) {
        if (!($this->login_user->user_type === "staff" || $this->login_user->client_id === $client_id)) {
            redirect("forbidden");
        }
    }

    //only allowed to access for admin users
    protected function access_only_clients() {
        if ($this->login_user->user_type != "client") {
            redirect("forbidden");
        }
    }

    //check module is enabled or not
    protected function check_module_availability($module_name) {
        if (get_setting($module_name) != "1") {
            redirect("forbidden");
        }
    }

    //check who has permission to create projects
    protected function can_create_projects() {
        if ($this->login_user->user_type == "staff") {
            if ($this->login_user->is_admin || get_array_value($this->login_user->permissions, "can_manage_all_projects") == "1") {
                return true;
            } else if (get_array_value($this->login_user->permissions, "can_create_projects") == "1") {
                return true;
            }
        } else {
            if (get_setting("client_can_create_projects")) {
                return true;
            }
        }
    }

    //check who has permission to view team members list
    protected function can_view_team_members_list() {
        if ($this->login_user->user_type == "staff") {
            if (get_array_value($this->login_user->permissions, "hide_team_members_list") == "1") {
                return false;
            } else {
                return true; //all members can see team members except the selected roles
            }
        }
        return false;
    }

}
