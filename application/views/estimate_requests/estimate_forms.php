<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1> <?php echo lang('estimate_request_forms'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("estimate_requests/estimate_request_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_form'), array("class" => "btn btn-default", "title" => lang('add_form'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="estimate-form-main-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-form-main-table").appTable({
            source: '<?php echo_uri("estimate_requests/estimate_forms_list_data") ?>',
            order: [[0, 'asc']],
            columns: [
                {title: "<?php echo lang("title"); ?>"},
                {title: "<?php echo lang("public"); ?>", "class": "w200"},
                {title: "<?php echo lang("status"); ?>", "class": "w200"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ]
        });
    });
</script>