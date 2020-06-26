<div id="page-content" class="p20 pb0 clearfix">

    <ul class="nav nav-tabs bg-white title" role="tablist">
        <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo lang("tasks"); ?></h4></li>

        <?php $this->load->view("projects/tasks/tabs", array("active_tab" => "tasks_kanban")); ?>       

        <div class="tab-title clearfix no-border">
            <div class="title-button-group">
                <?php
                if ($can_create_tasks) {
                    echo modal_anchor(get_uri("projects/task_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_task'), array("class" => "btn btn-default", "title" => lang('add_task')));
                }
                ?>
            </div>
        </div>
    </ul>
    <div class="p15 bg-white pb0">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-default" id="reload-kanban-button"><i class="fa fa-refresh"></i></button>
            </div>
            <div id="kanban-filters" class="col-md-11"></div>
        </div>
    </div>

    <div id="load-kanban"></div>
</div>

<?php $this->load->view("projects/tasks/kanban/all_tasks_kanban_helper_js"); ?>