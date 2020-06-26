<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller'] = array(
    'class' => '',
    'function' => 'check_verify',
    'filename' => 'check_phone_verify.php',
    'filepath' => 'hooks'
);

$hook['post_controller_constructor'] = array(
    'class' => '',
    'function' => 'init_settings',
    'filename' => 'init_settings.php',
    'filepath' => 'hooks'
);

