<?php
//check_phone_verify.php
function check_verify() {
    $ci = & get_instance();


    $currentURL = current_url(); //for simple URL
 
 	//$params = $_SERVER['QUERY_STRING']; //for parameters
	//$fullURL = $currentURL


     $login_user_id = $ci->Users_model->login_user_id();
     

    if($login_user_id) {
    	$edata=array("id"=>$login_user_id);
        $inss= $ci->Users_model->Check_phone_verifiction("users",$edata);
       	$verifyid =  $inss[0]->phone_varifiction;

        if(!$verifyid)
        {
        	if( $currentURL == 'https://garapp.azurewebsites.net/index.php/signin' ){
         	}else if($currentURL == 'https://garapp.azurewebsites.net/index.php/signin/check_number'){
        	}else{

	        	 redirect('signin');
        	}
        }
    }
    
}
