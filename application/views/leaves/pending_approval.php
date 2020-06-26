<div class="table-responsive">
    <table id="pending-approval-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#pending-approval-table").appTable({
            source: '<?php echo_uri("leaves/pending_approval_list_data") ?>',
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

