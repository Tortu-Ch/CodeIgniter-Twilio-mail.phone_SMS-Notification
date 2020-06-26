<div id="page-content" class="p20 pb0 clearfix">
    <div class="row">
        <div class="col-md-12">
            <div class="page-title clearfix">
                <h1>
                    <?php if ($project_info->status == "open") { ?>
                        <i class="fa fa-th-large" title="<?php echo lang("open"); ?>"></i>
                    <?php } else if ($project_info->status == "completed") { ?>
                        <i class="fa fa-check-circle" title="<?php echo lang("completed"); ?>"></i>
                    <?php } else if ($project_info->status == "hold") { ?>
                        <i class="fa fa-pause" title="<?php echo lang("hold"); ?>"></i> 
                    <?php } else if ($project_info->status == "canceled") { ?>
                        <i class="fa fa-times" title="<?php echo lang("canceled"); ?>"></i> 
                    <?php } ?>

                    <?php echo $project_info->title; ?>

                    <span id="star-mark">
                        <?php
                        if ($is_starred) {
                            $this->load->view('projects/star/starred', array("project_id" => $project_info->id));
                        } else {
                            $this->load->view('projects/star/not_starred', array("project_id" => $project_info->id));
                        }
                        ?>
                    </span>    
                </h1>

                <div class="title-button-group" id="project-timer-box">
                    <?php if ($show_actions_dropdown) { ?>
                        <span class="dropdown inline-block">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-left" role="menu">
                                <?php if ($project_info->status == "open") { ?>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("projects/change_status/$project_info->id/completed"), "<i class='fa fa-check-circle'></i> " . lang('mark_project_as_completed'), array("class" => "", "title" => lang('mark_project_as_completed'), "data-reload-on-success" => "1")); ?> </li>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("projects/change_status/$project_info->id/hold"), "<i class='fa fa-pause'></i> " . lang('mark_project_as_hold'), array("class" => "", "title" => lang('mark_project_as_hold'), "data-reload-on-success" => "1")); ?> </li>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("projects/change_status/$project_info->id/canceled"), "<i class='fa fa-times'></i> " . lang('mark_project_as_canceled'), array("class" => "", "title" => lang('mark_project_as_canceled'), "data-reload-on-success" => "1")); ?> </li>
                                <?php } ?>
                                <?php if ($project_info->status != "open") { ?>
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("projects/change_status/$project_info->id/open"), "<i class='fa fa-th-large'></i> " . lang('mark_project_as_open'), array("class" => "", "title" => lang('mark_project_as_open'), "data-reload-on-success" => "1")); ?> </li>
                                    <?php
                                }
                                echo "<li role='presentation'>" . modal_anchor(get_uri("projects/clone_project_modal_form"), "<i class='fa fa-copy'></i> " . lang('clone_project'), array("class" => "", "data-post-id" => $project_info->id, "title" => lang('clone_project'))) . " </li>";
                                echo "<li role='presentation'>" . modal_anchor(get_uri("projects/modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit_project'), array("class" => "edit", "title" => lang('edit_project'), "data-post-id" => $project_info->id)) . " </li>";
                                ?>

                            </ul>
                        </span>
                    <?php } ?>
                    <?php
                    if ($show_timmer) {
                        $this->load->view("projects/project_timer");
                    }
                    ?>
                </div>
            </div>
            <ul id="project-tabs" data-toggle="ajax-tab" class="nav nav-tabs classic" role="tablist">
                <?php if ($this->login_user->user_type === "staff") { ?>
                    <li><a role="presentation" href="<?php echo_uri("projects/overview/" . $project_info->id); ?>" data-target="#project-overview-section"><?php echo lang('overview'); ?></a></li>
                    <li><a role="presentation" href="<?php echo_uri("projects/tasks/" . $project_info->id); ?>" data-target="#project-tasks-section"><?php echo lang('tasks')." ".lang("list"); ?></a></li>
                    <li><a role="presentation" href="<?php echo_uri("projects/tasks_kanban/" . $project_info->id); ?>" data-target="#project-tasks-kanban-section"><?php echo lang('tasks')." ".lang("kanban"); ?></a></li>
                    <?php if ($show_milestone_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/milestones/" . $project_info->id); ?>" data-target="#project-milestones-section"> <?php echo lang('milestones'); ?></a></li>
                    <?php } ?>
                    <?php if ($show_gantt_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/gantt/" . $project_info->id); ?>" data-target="#project-gantt-section"> <?php echo lang('gantt'); ?></a></li>
                    <?php } ?>

                    <?php if ($show_note_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/notes/" . $project_info->id); ?>" data-target="#project-notes-section"> <?php echo lang('notes'); ?></a></li>
                    <?php } ?>
                    <li><a role="presentation" href="<?php echo_uri("projects/files/" . $project_info->id); ?>" data-target="#project-files-section"> <?php echo lang('files'); ?></a></li>
                    <li><a role="presentation" href="<?php echo_uri("projects/comments/" . $project_info->id); ?>" data-target="#project-comments-section"> <?php echo lang('comments'); ?></a></li>
                    <li><a role="presentation" href="<?php echo_uri("projects/customer_feedback/" . $project_info->id); ?>" data-target="#project-customer-feedback-section"> <?php echo lang('customer_feedback'); ?></a></li>

                    <?php if ($show_timesheet_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/timesheets/" . $project_info->id); ?>" data-target="#project-timesheets-section"> <?php echo lang('timesheets'); ?></a></li>
                    <?php } ?>

                    <?php if ($show_invoice_info) { ?>
                        <li><a  role="presentation" href="<?php echo_uri("projects/invoices/" . $project_info->id); ?>" data-target="#project-invoices"> <?php echo lang('invoices'); ?></a></li>
                        <li><a  role="presentation" href="<?php echo_uri("projects/payments/" . $project_info->id); ?>" data-target="#project-payments"> <?php echo lang('payments'); ?></a></li>
                    <?php } ?>
                        
                    <?php if ($show_expense_info) { ?>
                        <li><a  role="presentation" href="<?php echo_uri("projects/expenses/" . $project_info->id); ?>" data-target="#project-expenses"> <?php echo lang('expenses'); ?></a></li>
                    <?php } ?>   

                <?php } else { ?>
                    <li><a role="presentation" href="<?php echo_uri("projects/overview_for_client/" . $project_info->id); ?>" data-target="#project-overview-section"><?php echo lang('overview'); ?></a></li>                   

                    <?php if ($show_tasks) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/tasks/" . $project_info->id); ?>" data-target="#project-tasks-section"><?php echo lang('task')." ".lang("list"); ?></a></li>
                        <li><a role="presentation" href="<?php echo_uri("projects/tasks_kanban/" . $project_info->id); ?>" data-target="#project-tasks-kanban-section"><?php echo lang('task')." ".lang("kanban"); ?></a></li>
                    <?php } ?>
                        
                    <?php if ($show_files) { ?>    
                        <li><a role="presentation" href="<?php echo_uri("projects/files/" . $project_info->id); ?>" data-target="#project-files-section"> <?php echo lang('files'); ?></a></li>
                    <?php } ?>

                    <li><a role="presentation" href="<?php echo_uri("projects/customer_feedback/" . $project_info->id); ?>" data-target="#project-customer-feedback-section"> <?php echo lang('comments'); ?></a></li>

                    <?php if ($show_milestone_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/milestones/" . $project_info->id); ?>" data-target="#project-milestones-section"> <?php echo lang('milestones'); ?></a></li>
                    <?php } ?>

                    <?php if ($show_gantt_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/gantt/" . $project_info->id); ?>" data-target="#project-gantt-section"> <?php echo lang('gantt'); ?></a></li>
                    <?php } ?>
                        
                    <?php if ($show_timesheet_info) { ?>
                        <li><a role="presentation" href="<?php echo_uri("projects/timesheets/" . $project_info->id); ?>" data-target="#project-timesheets-section"> <?php echo lang('timesheets'); ?></a></li>
                    <?php } ?>    

                <?php } ?>


            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active" id="project-overview-section" style="min-height: 200px;"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-tasks-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-tasks-kanban-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-milestones-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-gantt-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-files-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-comments-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-customer-feedback-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-notes-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-timesheets-section"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-invoices"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-payments"></div>
                <div role="tabpanel" class="tab-pane fade" id="project-expenses"></div>

            </div>
        </div>
    </div>
</div>


<?php
//if we get any task parameter, we'll show the task details modal automatically
$preview_task_id = get_array_value($_GET, 'task');
if ($preview_task_id) {
    echo modal_anchor(get_uri("projects/task_view"), "", array("id" => "preview_task_link", "title" => lang('task_info') . " #$preview_task_id", "data-post-id" => $preview_task_id));
}
?>

<?php
load_css(array(
    "assets/js/gantt-chart/gantt.css",
));
load_js(array(
    "assets/js/gantt-chart/gantt.js",
));
?>

<script type="text/javascript">
    RELOAD_PROJECT_VIEW_AFTER_UPDATE = true;

    $(document).ready(function () {
        var tab = "<?php echo $tab; ?>";
        if (tab === "comment") {
            $("[data-target=#project-comments-section]").trigger("click");
        } else if (tab === "customer_feedback") {
            $("[data-target=#project-customer-feedback-section]").trigger("click");
        } else if (tab === "files") {
            $("[data-target=#project-files-section]").trigger("click");
        } else if (tab === "gantt") {
            $("[data-target=#project-gantt-section]").trigger("click");
        } else if (tab === "tasks") {
            $("[data-target=#project-tasks-section]").trigger("click");
        } else if (tab === "tasks_kanban") {
            $("[data-target=#project-tasks-kanban-section]").trigger("click");
        } else if (tab === "milestones") {
            $("[data-target=#project-milestones-section]").trigger("click");
        } 
        
        
        //open task details modal automatically 
     
        if ($("#preview_task_link").length) {
            $("#preview_task_link").trigger("click");
        }

    });
</script>