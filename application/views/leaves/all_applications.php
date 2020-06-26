<div class="table-responsive">
    <table id="all-application-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#all-application-table").appTable({
            source: '<?php echo_uri("leaves/all_application_list_data") ?>',
            dateRangeType: "monthly",
            columns: [
                {title: '<?php echo lang("applicant") ?>', "class": "w20p"},
                {title: '<?php echo lang("leave_type") ?>'},
                {title: '<?php echo lang("date") ?>', "class": "w20p"},
                {title: '<?php echo lang("duration") ?>', "class": "w20p"},
                {title: '<?php echo lang("status") ?>', "class": "w15p"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4]
        });
    });
</script>

