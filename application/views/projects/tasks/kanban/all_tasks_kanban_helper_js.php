<script type="text/javascript">

    $(document).ready(function () {

        var scrollLeft = 0;
        $("#kanban-filters").appFilters({
            source: '<?php echo_uri("projects/all_tasks_kanban_data") ?>',
            targetSelector: '#load-kanban',
            reloadSelector: "#reload-kanban-button",
            search: {name: "search"},
            filterDropdown: [
                {name: "specific_user_id", class: "w150", options: <?php echo $team_members_dropdown; ?>},
                {name: "milestone_id", class: "w150", options: [{id: "", text: "- <?php echo lang('milestone'); ?> -"}], dependency: ["project_id"], dataSource: '<?php echo_uri("projects/get_milestones_for_filter") ?>'}, //milestone is dependent on project
                {name: "project_id", class: "w200", options: <?php echo $projects_dropdown; ?>, dependent: ["milestone_id"]}, //reset milestone on changing of project               
            ],
            singleDatepicker: [{name: "deadline", defaultText: "<?php echo lang('deadline') ?>",
                    options: [
                        {value: "expired", text: "<?php echo lang('expired') ?>"},
                        {value: moment().format("YYYY-MM-DD"), text: "<?php echo lang('today') ?>"},
                        {value: moment().add(1, 'days').format("YYYY-MM-DD"), text: "<?php echo lang('tomorrow') ?>"},
                        {value: moment().add(7, 'days').format("YYYY-MM-DD"), text: "<?php echo sprintf(lang('in_number_of_days'), 7); ?>"},
                        {value: moment().add(15, 'days').format("YYYY-MM-DD"), text: "<?php echo sprintf(lang('in_number_of_days'), 15); ?>"}
                    ]}],
            beforeRelaodCallback: function () {
                scrollLeft = $("#kanban-wrapper").scrollLeft();
            },
            afterRelaodCallback: function () {
                setTimeout(function () {
                    $("#kanban-wrapper").animate({scrollLeft: scrollLeft}, 'slow');
                }, 500);

            }
        });

    });

</script>