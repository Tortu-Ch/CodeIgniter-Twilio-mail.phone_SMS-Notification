<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Knowledge_base extends CI_Controller {

    public $login_user;
    protected $access_type = "";
    protected $allowed_members = array();

    function __construct() {
        parent::__construct();

        $this->login_user = new stdClass();
        $login_user_id = $this->Users_model->login_user_id();
        if ($login_user_id) {
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


        $this->load->model("Help_categories_model");
        $this->load->model("Help_articles_model");
    }

    //show knowledge base page
    function index() {
        if (!get_setting("module_knowledge_base")) {
            show_404();
        }

        $type = "knowledge_base";
        $view_data["categories"] = $this->Help_categories_model->get_details(array("type" => $type, "only_active_categories" => true))->result();
        $view_data["type"] = $type;

        if (!isset($this->login_user->id)) {
            $view_data['topbar'] = "includes/public/topbar";
            $view_data['left_menu'] = false;
        }
        $this->template->rander("help_and_knowledge_base/index", $view_data);
    }

    //show knowledge base category
    function category($id) {
        if (!$id || !is_numeric($id)) {
            show_404();
        }

        $category_info = $this->Help_categories_model->get_one($id);
        if (!$category_info || !$category_info->id || $category_info->type != "knowledge_base") {
            show_404();
        }


        $view_data['page_type'] = "articles_list_view";
        $view_data['type'] = $category_info->type;
        $view_data['selected_category_id'] = $category_info->id;
        $view_data['categories'] = $this->Help_categories_model->get_details(array("type" => $category_info->type))->result();

        $view_data["articles"] = $this->Help_articles_model->get_articles_of_a_category($id)->result();
        $view_data["category_info"] = $category_info;

        if (!isset($this->login_user->id)) {
            $view_data['topbar'] = "includes/public/topbar";
            $view_data['left_menu'] = false;
        }

        $this->template->rander("help_and_knowledge_base/articles/view_page", $view_data);
    }

    //show article
    function view($id = 0) {
        if (!$id || !is_numeric($id)) {
            show_404();
        }

        $model_info = $this->Help_articles_model->get_details(array("id" => $id))->row();

        if (!$model_info || $model_info->type != "knowledge_base") {
            show_404();
        }

        $this->Help_articles_model->increas_page_view($id);


        $view_data['selected_category_id'] = $model_info->category_id;
        $view_data['type'] = $model_info->type;
        $view_data['categories'] = $this->Help_categories_model->get_details(array("type" => $model_info->type))->result();
        $view_data['page_type'] = "article_view";

        $view_data['article_info'] = $model_info;


        if (!isset($this->login_user->id)) {
            $view_data['topbar'] = "includes/public/topbar";
            $view_data['left_menu'] = false;
        }

        $this->template->rander('help_and_knowledge_base/articles/view_page', $view_data);
    }

    function get_article_suggestion() {
        $search = $this->input->post("search");
        if ($search) {
            $result = $this->Help_articles_model->get_suggestions("knowledge_base", $search);

            echo json_encode($result);
        }
    }
    
     // download files 
    function download_files($id = 0) {
        $info = $this->Help_articles_model->get_one($id);
        download_app_files(get_setting("timeline_file_path"), $info->files);
    }

}

/* End of file help.php */
/* Location: ./application/controllers/help.php */