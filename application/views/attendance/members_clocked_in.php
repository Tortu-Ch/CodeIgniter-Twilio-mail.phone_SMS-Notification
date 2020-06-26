<div class="table-responsive">
    <table id="members-clocked-in-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#members-clocked-in-table").appTable({
            source: '<?php echo_uri("attendance/clocked_in_members_list_data/"); ?>',
            order: [[2, "desc"]],
            columns: [
                {title: "<?php echo lang("team_member"); ?>", "class": "w20p"},
                {visible: false, searchable: false},
                {title: "<?php echo lang("in_date"); ?>", "class": "w15p", iDataSort: 1},
                {title: "<?php echo lang("in_time"); ?>", "class": "w15p"}
            ],
            printColumns: [0, 2, 3],
            xlsColumns: [0, 2, 3],
            tableRefreshButton: true,
            columnShowHideOption:false
            
        });
    });
</script>