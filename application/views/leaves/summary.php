<div class="table-responsive">
    <table id="leave-summary-table" class="display" cellspacing="0"width="100%">
    </table>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $("#leave-summary-table").appTable({
            source: '<?php echo_uri("leaves/summary_list_data") ?>',
            filterDropdown: [
                {name: "leave_type_id", class: "w200", options: <?php echo $leave_types_dropdown; ?>},
                {name: "applicant_id", class: "w200", options: <?php echo $team_members_dropdown; ?>}
            ],
            dateRangeType: "yearly",
            columns: [
                {title: '<?php echo lang("applicant") ?>', "class": "w30p"},
                {title: '<?php echo lang("leave_type") ?>'},
                {title: '<?php echo lang("total_leave_yearly") ?>'}
            ],
            printColumns: [0, 1],
            xlsColumns: [0, 1]
        });
    }
    );
</script>