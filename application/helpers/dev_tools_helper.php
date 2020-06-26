<?php

//This helpers provided only for developers
//Don't include this in production/live project

$css = array(
    "assets/bootstrap/css/bootstrap.min.css",
    "assets/js/font-awesome/css/font-awesome.min.css",
    "assets/js/datatable/css/jquery.dataTables.min.css",
    "assets/js/datatable/TableTools/css/dataTables.tableTools.min.css",
    "assets/js/select2/select2.css",
    "assets/js/select2/select2-bootstrap.min.css",
    "assets/js/bootstrap-datepicker/css/datepicker3.css",
    "assets/js/bootstrap-timepicker/css/bootstrap-timepicker.min.css",
    "assets/js/x-editable/css/bootstrap-editable.css",
    "assets/js/dropzone/dropzone.min.css",
    "assets/js/magnific-popup/magnific-popup.css",
    "assets/js/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css",
    "assets/js/awesomplete/awesomplete.css",
    "assets/css/font.css",
    "assets/css/style.css"
);

$js = array(
    "assets/js/jquery-1.11.3.min.js",
    "assets/bootstrap/js/bootstrap.min.js",
    "assets/js/jquery-validation/jquery.validate.min.js",
    "assets/js/jquery-validation/jquery.form.js",
    "assets/js/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js",
    "assets/js/select2/select2.js",
    "assets/js/datatable/js/jquery.dataTables.min.js",
    "assets/js/datatable/TableTools/js/dataTables.tableTools.min.js",
    "assets/js/datatable/TableTools/js/dataTables.buttons.min.js",
    "assets/js/datatable/TableTools/js/buttons.html5.min.js",
    "assets/js/datatable/TableTools/js/buttons.print.min.js",
    "assets/js/datatable/TableTools/js/jszip.min.js",
    "assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
    "assets/js/bootstrap-timepicker/js/bootstrap-timepicker.min.js",
    "assets/js/x-editable/js/bootstrap-editable.min.js",
    "assets/js/fullcalendar/moment.min.js",
    "assets/js/dropzone/dropzone.min.js",
    "assets/js/magnific-popup/jquery.magnific-popup.min.js",
    "assets/js/sortable/sortable.min.js",
    "assets/js/notification_handler.js",
    "assets/js/general_helper.js",
    "assets/js/app.min.js"
);

//read file
function read_file_by_curl($path) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_POST, 1);

    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

//preapre app.all.css
function write_css($files) {
    merge_file($files, "assets/css/app.all.css");
}

//preapre app.all.js
function write_js($files) {
    merge_file($files, "assets/js/app.all.js");
}

//merge all files into one
function merge_file($files, $file_name) {
    $txt ="";
    foreach ($files as $file) {
        $txt .= file_get_contents(base_url($file));
    }

    file_put_contents($file_name, $txt);
}
