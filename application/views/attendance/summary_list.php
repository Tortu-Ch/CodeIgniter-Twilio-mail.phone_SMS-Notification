<div class="table-responsive">
    <table id="attendance-summary-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#attendance-summary-table").appTable({
            source: '<?php echo_uri("attendance/summary_list_data/"); ?>',
            order: [[0, "desc"]],
            filterDropdown: [{name: "user_id", class: "w200", options: <?php echo $team_members_dropdown; ?>}],
            rangeDatepicker: [{startDate: {name: "start_date", value: moment().format("YYYY-MM-DD")}, endDate: {name: "end_date", value: moment().format("YYYY-MM-DD")}}],
            columns: [
                {title: "<?php echo lang("team_member"); ?>"},
                {title: "<?php echo lang("duration"); ?>", "class": "w20p text-right"},
                {title: "<?php echo lang("hours"); ?>", "class": "w20p text-right"}
            ],
            printColumns: [0, 1, 2],
            xlsColumns: [0, 1, 2],
            summation: [{column: 1, dataType: 'time'}, {column: 2, dataType: 'number'}]
        });
    });
</script>