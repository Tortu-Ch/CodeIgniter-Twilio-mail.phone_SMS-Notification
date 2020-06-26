<?php

class Forbidden extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $view_data["heading"] = "403 Forbidden";
        $view_data["message"] = "You don't have  permission to access this module.";
        if ($this->input->is_ajax_request()) {
            $view_data["no_css"] = true;
        }
        $this->load->view("errors/html/error_general", $view_data);
    }

}
