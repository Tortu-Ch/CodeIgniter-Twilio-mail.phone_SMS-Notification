<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1> <?php echo lang('estimate_requests'); ?></h1>
        </div>
        <div class="table-responsive">
            <table id="estimate-request-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-request-table").appTable({
            source: '<?php echo_uri("estimate_requests/estimate_request_list_data") ?>',
            order: [[4, 'desc']],
            filterDropdown: [{name: "assigned_to", class: "w150", options: <?php echo $assigned_to_dropdown; ?>}, {name: "status", class: "w150", options: <?php echo $statuses_dropdown; ?>}],
            columns: [
                {title: "<?php echo lang('id'); ?>"},
                {title: "<?php echo lang('client'); ?>"},
                {title: "<?php echo lang('title'); ?>"},
                {title: "<?php echo lang('assigned_to'); ?>"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("created_date") ?>', "iDataSort": 4},
                {title: "<?php echo lang('status'); ?>"},
                {title: "<i class='fa fa-bars'></i>", "class": "text-center dropdown-option w50"}
            ],
            printColumns: [0, 1, 2, 3, 5, 6]
        });
    });
</script>