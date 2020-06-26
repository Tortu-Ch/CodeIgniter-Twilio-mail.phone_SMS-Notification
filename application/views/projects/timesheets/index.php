<div class="panel panel-default">
    <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo lang("timesheets"); ?></h4></li>

        <li><a id="timesheet-details-button" role="presentation" href="javascript:;" data-target="#timesheet-details"><?php echo lang("details"); ?></a></li>
        <li><a role="presentation" href="<?php echo_uri("projects/timesheet_summary/" . $project_id); ?>" data-target="#timesheet-summary"><?php echo lang('summary'); ?></a></li>

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
                <?php
                if ($can_update_settings) {
                    echo modal_anchor(get_uri("projects/settings_modal_form"), "<i class='fa fa fa-cog'></i> " . lang('settings'), array("class" => "btn btn-default", "title" => lang('settings'), "data-post-project_id" => $project_id));
                }

                if ($can_add_log) {
                    echo modal_anchor(get_uri("projects/timelog_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('log_time'), array("class" => "btn btn-default", "title" => lang('log_time'), "data-post-project_id" => $project_id));
                }
                ?>
            </div>
        </div>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="timesheet-details">
            <div class="table-responsive">
                <table id="project-timesheet-table" class="display" width="100%">  
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="timesheet-summary"></div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#timesheet-details-button").trigger("click");

        var optionVisibility = false;
        if ("<?php echo $this->login_user->user_type; ?>" == "staff") {
            optionVisibility = true;
        }


        $("#project-timesheet-table").appTable({
            source: '<?php echo_uri("projects/timesheet_list_data/") ?>',
            filterParams: {project_id: "<?php echo $project_id; ?>"},
            order: [[3, "desc"]],
            filterDropdown: [{name: "user_id", class: "w200", options: <?php echo $project_members_dropdown; ?>}, {name: "task_id", class: "w200", options: <?php echo $tasks_dropdown; ?>}],
            rangeDatepicker: [{startDate: {name: "start_date", value: ""}, endDate: {name: "end_date", value: ""}, showClearButton: true}],
            columns: [
                {title: "<?php echo lang('member') ?>"},
                {visible: false, searchable: false},
                {title: "<?php echo lang('task') ?>"},
                {visible: false, searchable: false},
                {title: "<?php echo lang('start_time') ?>", "iDataSort": 3},
                {visible: false, searchable: false},
                {title: "<?php echo lang('end_time') ?>", "iDataSort": 5},
                {title: "<?php echo lang('total') ?>", "class": "text-right"},
                {title: '<i class="fa fa-comment"></i>', "class": "text-center w50"},
                {visible: optionVisibility, title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 2, 4, 6, 7],
            xlsColumns: [0, 2, 4, 6, 7],
            summation: [{column: 7, dataType: 'time'}]
        });
    });
</script>