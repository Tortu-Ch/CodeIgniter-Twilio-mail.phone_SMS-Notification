<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('cron_job');
    }

    function index() {
        ini_set('max_execution_time', 300); //execute maximum 300 seconds 
        //wait at least 5 minute befor starting new cron job
        $last_cron_job_time = get_setting('last_cron_job_time');

        $current_time = strtotime(get_current_utc_time());
		
        if ($last_cron_job_time == "" || ($current_time > ($last_cron_job_time*1 + 300))) {
            $this->cron_job->run();
            $this->Settings_model->save_setting("last_cron_job_time", $current_time);
        }
    }

}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */