<head>
    <?php $this->load->view('includes/meta'); ?>
    <?php $this->load->view('includes/helper_js'); ?>
    <?php $this->load->view('includes/plugin_language_js'); ?>

    <?php
    //We'll merge all css and js into sigle files. If you want to use the css separately, you can use it.
    /*

    $css = array(
        "assets/js/datatable/TableTools/css/dataTables.tableTools.min.css",
        "assets/js/datatable/responsive.dataTables.min.css",
        "assets/js/bootstrap-datepicker/css/datepicker3.css",
        "assets/js/bootstrap-timepicker/css/bootstrap-timepicker.min.css",
        "assets/js/x-editable/css/bootstrap-editable.css",
        "assets/js/dropzone/dropzone.min.css",
        "assets/js/magnific-popup/magnific-popup.css",
        "assets/js/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css",
        "assets/js/awesomplete/awesomplete.css",
        "assets/js/atwho/css/jquery.atwho.min.css",
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
        "assets/js/datatable/responsive.dataTables.min.js",
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
        "assets/js/flot/jquery.flot.min.js",
        "assets/js/flot/jquery.flot.pie.min.js",
        "assets/js/flot/jquery.flot.resize.min.js",
        "assets/js/flot/jquery.flot.categories.min.js",
        "assets/js/flot/curvedLines.js",
        "assets/js/flot/jquery.flot.tooltip.min.js",
        "assets/js/easypiechart/jquery.easypiechart.min.js",
        "assets/js/atwho/caret/jquery.caret.min.js",
        "assets/js/atwho/js/jquery.atwho.min.js",
        "assets/js/notification_handler.js",
        "assets/js/general_helper.js",
        "assets/js/app.min.js"
    );


    //to merge all files into one, we'll use this helper
    $this->load->helper('dev_tools');

    write_css($css);
    write_js($js);

    */


    load_css(array(
        "assets/bootstrap/css/bootstrap.min.css",
        "assets/js/font-awesome/css/font-awesome.min.css", //don't combine this css because of the fonts path
        "assets/js/datatable/css/jquery.dataTables.min.css", //don't combine this css because of the images path
        "assets/js/select2/select2.css", //don't combine this css because of the images path
        "assets/js/select2/select2-bootstrap.min.css",
        "assets/css/app.all.css",
        "assets/css/custom-style.css", //custom style should not be merged
    ));

    load_js(array(
        "assets/js/app.all.js",
    ));
    ?>
</head>
