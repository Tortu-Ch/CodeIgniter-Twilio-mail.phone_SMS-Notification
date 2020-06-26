<?php
require_once './twilio/twilio-php-master/Twilio/autoload.php'; // Loads the library

use Twilio\Rest\Client;

class Signin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('email');
    }

    function index() {
 
        if ($this->Users_model->login_user_id()) 
        {
            //redirect('dashboard/view');

        	$id = $this->session->user_id;
            $edata=array("id"=>$id);
            //echo "<pre>";print_r($edata);die;
            $inss=$this->Users_model->Check_phone_verifiction("users",$edata);
            $verifyid =  $inss[0]->phone_varifiction;
            $phonenumber =  $inss[0]->phone;
            if(!$phonenumber)
            {
                $this->session->set_flashdata('numbernotavi', 'Your phone number is not registered. Please contact your administer for more details'); 
                //$this->load->view('signin/index', $view_data);
                redirect('signin/sign_out');     
            }
            // else if($verifyid==1)
            // {
            //       redirect('dashboard/view');     
            // }    
            else
            {
                $this->session->set_flashdata('verfiynumber', 'Your phon not verified. can you please check your mobile .'); 
                $six_digit_random_number = mt_rand(100000, 999999);
                $data=array("phone_varifiction_number"=>$six_digit_random_number);
                $iid=array("id"=>$id);
                $this->Users_model->upd("users",$data,$iid);
                $this->send_sms($six_digit_random_number,$phonenumber);
                
                $view_data["form_type"] = "phone_verofiy";
                $this->load->view('signin/index', $view_data);

            }



        } else {

            $view_data["redirect"] = "";
            if (isset($_REQUEST["redirect"])) {
                $view_data["redirect"] = $_REQUEST["redirect"];
            }


            //check if there reCaptcha is enabled
            //if reCaptcha is enabled, check the validation
            if (get_setting("re_captcha_secret_key")) {
                $this->form_validation->set_rules('g-recaptcha-response', '', 'callback_check_recaptcha');
            }


            $this->form_validation->set_rules('email', '', 'callback_authenticate');
            $this->form_validation->set_error_delimiters('<span>', '</span>');


            if ($this->form_validation->run() == FALSE) {

                $this->load->view('signin/index', $view_data);
            } else 
                {


                if ($view_data["redirect"]) 
                {
                	redirect($view_data["redirect"]);
                } else 
                {
                    $id = $this->session->user_id;
                    $edata=array("id"=>$id);
                    $inss=$this->Users_model->Check_phone_verifiction("users",$edata);
                    $phonenumber =  $inss[0]->phone;
                    $verifyid =  $inss[0]->phone_varifiction;
                    if(!$phonenumber)
                    {
                         $this->session->set_flashdata('numbernotavi', 'Your phone number is not registered. Please contact your administer for more details'); 
                         // $this->load->view('signin/index', $view_data);
                        redirect('signin/sign_out');     
                    }
                    // else if($verifyid==1)
                    // {
                    //    redirect('dashboard/view');     
                    // }    
                    else
                    {
                        $six_digit_random_number = mt_rand(100000, 999999);
                        $data=array("phone_varifiction_number"=>$six_digit_random_number);
                        $iid=array("id"=>$id);
                        $this->Users_model->upd("users",$data,$iid);
                        $this->send_sms($six_digit_random_number,$phonenumber);
                        
                        $view_data["form_type"] = "phone_verofiy";
                        $this->load->view('signin/index', $view_data);
                    }

                    
                    
                }
            }
        }
    }

    function send_sms($data,$usrphonnumbe) {
    	// new client sid and tokan
          $sid = 'ACe955f2c80ed676fb67d5f7b4a634fc4a';
          $token = '67d13eed62e8e7a287f66c2f6396da04';

        $client = new Client($sid, $token);
        // Use the client to do fun stuff like send text messages!
        $send = $client->messages->create(
             $usrphonnumbe,

            array(
                 'from' => '+17035701026', // cline number
                'body' => "Your verification code is ". $data,
            )
        );
    }

    function check_number() 
    {
    $Code = $this->input->post("Code");
    $id = $this->session->user_id;
	$edata=array("id"=>$id);
	$inss=$this->Users_model->Check_phone_verifiction("users",$edata);
     $verifyid =  $inss[0]->phone_varifiction_number;

    	if($Code==$verifyid)
    	{	
    	
    		$id = $this->session->user_id;
    		$data=array("phone_varifiction"=>'1');
            $iid=array("id"=>$id);
            $this->Users_model->upd("users",$data,$iid);
    	 	redirect('dashboard/view');     	
    	}
    	else
    	{
    		// echo "NO";
    		// die();
    		$view_data["form_type"] = "phone_verofiy";
			$this->load->view('signin/index', $view_data);     
    	
    	}


    }


    function check_recaptcha($recaptcha_post_data) {

        $response = $this->is_valid_recaptcha($recaptcha_post_data);

        if ($response === true) 
        {
            return true;
        } else {
            $this->form_validation->set_message('check_recaptcha', lang("re_captcha_error-" . $response));
            return false;
        }
    }

    private function is_valid_recaptcha($recaptcha_post_data) {
        //load recaptcha lib
        require_once(APPPATH . "third_party/recaptcha/autoload.php");
        $recaptcha = new \ReCaptcha\ReCaptcha(get_setting("re_captcha_secret_key"));
        $resp = $recaptcha->verify($recaptcha_post_data, $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            return true;
        } else {

            $error = "";
            foreach ($resp->getErrorCodes() as $code) {
                $error = $code;
            }

            return $error;
        }
    }

    // check authentication
    function authenticate($email) {

        //don't check password if there is any error
        if (validation_errors()) {
            $this->form_validation->set_message('authenticate', "");
            return false;
        }


        $password = $this->input->post("password");
        if (!$this->Users_model->authenticate($email, $password)) {
            $this->form_validation->set_message('authenticate', lang("authentication_failed"));
            return false;
        }




        return true;
    }

    function sign_out() {
        $this->Users_model->sign_out();
    }

    //send an email to users mail with reset password link
    function send_reset_password_mail() {
        validate_submitted_data(array(
            "email" => "required|valid_email"
        ));


        //check if there reCaptcha is enabled
        //if reCaptcha is enabled, check the validation
        if (get_setting("re_captcha_secret_key")) {

            $response = $this->is_valid_recaptcha($this->input->post("g-recaptcha-response"));
       
            if ($response !== true) {
                
                if($response){
                    echo json_encode(array('success' => false, 'message' => lang("re_captcha_error-" . $response) ));
                }else{
                    echo json_encode(array('success' => false, 'message' => lang("re_captcha_expired") ));
                }
                
                return false;
            }
        }

        

        $email = $this->input->post("email");
        $existing_user = $this->Users_model->is_email_exists($email);

        //send reset password email if found account with this email
        if ($existing_user) {

            $email_template = $this->Email_templates_model->get_final_template("reset_password");
            
            $parser_data["ACCOUNT_HOLDER_NAME"] = $existing_user->first_name . " " . $existing_user->last_name;
            $parser_data["SIGNATURE"] = $email_template->signature;
            $parser_data["LOGO_URL"] = get_logo_url();
            $parser_data["SITE_URL"] = get_uri();
            $key = encode_id($this->encryption->encrypt($existing_user->email . '|' . (time() + (24 * 60 * 60))), "reset_password");
            $parser_data['RESET_PASSWORD_URL'] = get_uri("signin/new_password/" . $key);

            $message = $this->parser->parse_string($email_template->message, $parser_data, TRUE);
            if (send_app_mail($email, $email_template->subject, $message)) {

                // new client sid and tokan
          $sid = 'ACe955f2c80ed676fb67d5f7b4a634fc4a';
          $token = '67d13eed62e8e7a287f66c2f6396da04';
               $fullmessage = 'Hi '.$existing_user->first_name.' '.$existing_user->last_name.' A password reset request has been created for your account. can you pleases check your email'; 
         
        $client = new Client($sid, $token);
        // Use the client to do fun stuff like send text messages!
        $send = $client->messages->create(
             $existing_user->phone,
         
            array(
                
                  'from' => '+17035701026', // cline number
                'body' => $fullmessage,
            )
        );

                echo json_encode(array('success' => true, 'message' => lang("reset_info_send")));
            } else {
                echo json_encode(array('success' => false, 'message' => lang('error_occurred')));
            }
        } else {
            echo json_encode(array("success" => false, 'message' => lang("no_acount_found_with_this_email")));
            return false;
        }
    }

    //show forgot password recovery form
    function request_reset_password() {
        $view_data["form_type"] = "request_reset_password";
        $this->load->view('signin/index', $view_data);
    }

    //when user clicks to reset password link from his/her email, redirect to this url
    function new_password($key) {
        $valid_key = $this->is_valid_reset_password_key($key);

        if ($valid_key) {
            $email = get_array_value($valid_key, "email");

            if ($this->Users_model->is_email_exists($email)) {
                $view_data["key"] = $key;
                $view_data["form_type"] = "new_password";
                $this->load->view('signin/index', $view_data);
                return false;
            }
        }

        //else show error
        $view_data["heading"] = "Invalid Request";
        $view_data["message"] = "The key has expaired or something went wrong!";
        $this->load->view("errors/html/error_general", $view_data);
    }

    //finally reset the old password and save the new password
    function do_reset_password() {

        validate_submitted_data(array(
            "key" => "required",
            "password" => "required"
        ));


        $key = $this->input->post("key");
        $password = $this->input->post("password");
        $valid_key = $this->is_valid_reset_password_key($key);

        if ($valid_key) {
            $email = get_array_value($valid_key, "email");
            $user = $this->Users_model->is_email_exists($email);
            $user_data = array("password" => md5($password));
            if ($user->id && $this->Users_model->save($user_data, $user->id)) {
                echo json_encode(array("success" => true, 'message' => lang("password_reset_successfully") . " " . anchor("signin", lang("signin"))));
                return true;
            }
        }
        echo json_encode(array("success" => false, 'message' => lang("error_occurred")));
    }

    //check valid key
    private function is_valid_reset_password_key($key = "") {

        if ($key) {
            $key = decode_id($key, "reset_password");
            $key = $this->encryption->decrypt($key);
            $key = explode('|', $key);

            $email = get_array_value($key, "0");
            $expire_time = get_array_value($key, "1");

            if ($email && valid_email($email) && $expire_time && $expire_time > time()) {
                return array("email" => $email);
            }
        }
    }

}
