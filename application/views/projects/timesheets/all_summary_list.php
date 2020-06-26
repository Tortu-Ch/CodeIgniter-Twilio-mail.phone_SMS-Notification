<div class="table-responsive">
    <table id="all-timesheet-summary-table" class="display" cellspacing="0" width="100%">            
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#all-timesheet-summary-table").appTable({
            source: '<?php echo_uri("projects/timesheet_summary_list_data/"); ?>',
            filterDropdown: [
                {name: "user_id", class: "w200", options: <?php echo $members_dropdown; ?>},
                {name: "project_id", class: "w200", options: <?php echo $projects_dropdown; ?>, dependency: ["client_id"], dataSource: '<?php echo_uri("projects/get_projects_of_selected_client_for_filter") ?>', selfDependency: true}, //projects are dependent on client. but we have to show all projects, if there is no selected client
<?php if ($this->login_user->is_admin || get_array_value($this->login_user->permissions, "client")) { ?>
                    {name: "client_id", class: "w200", options: <?php echo $clients_dropdown; ?>, dependent: ["project_id"]}, //reset projects on changing of client
<?php } ?>
                {name: "group_by", class: "w200", options: <?php echo $group_by_dropdown; ?>},
            ],
            rangeDatepicker: [{startDate: {name: "start_date", value: moment().format("YYYY-MM-DD")}, endDate: {name: "end_date", value: moment().format("YYYY-MM-DD")}, showClearButton: true}],
            columns: [
                {title: "<?php echo lang("project"); ?>"},
                {title: "<?php echo lang("member"); ?>"},
                {title: "<?php echo lang("task"); ?>"},
                {title: "<?php echo lang("duration"); ?>", "class": "w15p text-right"},
                {title: "<?php echo lang("hours"); ?>", "class": "w15p  text-right"}
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4],
            summation: [{column: 3, dataType: 'time'}, {column: 4, dataType: 'number'}],
            onRelaodCallback: function (tableInstance, filterParams) {

                //we'll show/hide the task/member column based on the group by status

                if (filterParams && filterParams.group_by === "member") {
                    //show member
                    showHideAppTableColumn(tableInstance, 0, false);
                    showHideAppTableColumn(tableInstance, 1, true);
                    showHideAppTableColumn(tableInstance, 2, false);
                } else if (filterParams && filterParams.group_by === "project") {
                    //show project
                    showHideAppTableColumn(tableInstance, 0, true);
                    showHideAppTableColumn(tableInstance, 1, false);
                    showHideAppTableColumn(tableInstance, 2, false);
                } else if (filterParams && filterParams.group_by === "task") {
                    //show task
                    showHideAppTableColumn(tableInstance, 0, false);
                    showHideAppTableColumn(tableInstance, 1, false);
                    showHideAppTableColumn(tableInstance, 2, true);
                } else {
                    //show all
                    showHideAppTableColumn(tableInstance, 0, true);
                    showHideAppTableColumn(tableInstance, 1, true);
                    showHideAppTableColumn(tableInstance, 2, true);
                }

                //clear this status for next time load
                clearAppTableState(tableInstance);
            }
        });
    });
</script>