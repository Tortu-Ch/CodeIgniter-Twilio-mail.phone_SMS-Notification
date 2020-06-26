<div class="panel">

    <?php if ($this->login_user->user_type == "staff") { ?>
        <div class="tab-title clearfix">
            <h4><?php echo lang('estimate_requests'); ?></h4>
        </div>
    <?php } ?>

    <div class="table-responsive">
        <table id="estimate-request-table" class="display" cellspacing="0" width="100%">            
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var fieldVisibility = false;
        if ("<?php echo $this->login_user->user_type; ?>" === "staff") {
            fieldVisibility = true;
        }

        $("#estimate-request-table").appTable({
            source: '<?php echo_uri("estimate_requests/estimate_requests_list_data_of_client/" . $client_id) ?>',
            order: [[0, 'desc']],
            columns: [
                {title: "<?php echo lang('id'); ?>"},
                {visible: false, searchable: false},
                {title: "<?php echo lang('title'); ?>"},
                {title: "<?php echo lang('assigned_to'); ?>", visible: fieldVisibility},
                {visible: false, searchable: false},
                {title: '<?php echo lang("created_date") ?>', "iDataSort": 3},
                {title: "<?php echo lang('status'); ?>"},
                {title: "<i class='fa fa-bars></i>'", "class": "text-center option w100", visible: fieldVisibility}
            ],
            printColumns: [0, 2, 3, 5, 6]
        });
    });
</script>