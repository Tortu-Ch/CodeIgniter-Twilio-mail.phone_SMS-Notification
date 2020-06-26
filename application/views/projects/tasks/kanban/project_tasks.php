<div class="panel mb0">
    <div class="tab-title clearfix">
        <h4><?php echo lang('tasks') . " " . lang('kanban'); ?></h4>
        <div class="title-button-group">
            <?php
            if ($can_create_tasks) {
                echo modal_anchor(get_uri("projects/task_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_task'), array("class" => "btn btn-default", "title" => lang('add_task'), "data-post-project_id" => $project_id));
            }
            ?>
        </div>
    </div>
    <div class="p15 bg-white pb0">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-default" id="reload-kanban-button"><i class="fa fa-refresh"></i></button>
            </div>
            <div id="kanban-filters" class="col-md-11"></div>
        </div>
    </div>
</div>
<div id="load-kanban"></div>

<script type="text/javascript">

    $(document).ready(function () {
       var filterDropdown =[];
       
        if("<?php echo $this->login_user->user_type?>"=="staff"){
             filterDropdown = [
                {name: "specific_user_id", class: "w200", options: <?php echo $assigned_to_dropdown; ?>},
                {name: "milestone_id", class: "w200", options: <?php echo $milestone_dropdown; ?>}
            ];
        }else{
             filterDropdown = [
                {name: "milestone_id", class: "w200", options: <?php echo $milestone_dropdown; ?>}
            ];
        }
       

        var scrollLeft = 0;
        $("#kanban-filters").appFilters({
            source: '<?php echo_uri("projects/project_tasks_kanban_data/".$project_id) ?>',
            targetSelector: '#load-kanban',
            reloadSelector: "#reload-kanban-button",
            search: {name: "search"},
            filterDropdown: filterDropdown,
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