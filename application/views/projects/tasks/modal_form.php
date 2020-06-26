<?php echo form_open(get_uri("projects/save_task"), array("id" => "task-form", "class" => "general-form", "role" => "form")); ?>
<div id="tasks-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
        <div class="form-group">
            <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "title",
                    "name" => "title",
                    "value" => $model_info->title,
                    "class" => "form-control",
                    "placeholder" => lang('title'),
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class=" col-md-3"><?php echo lang('description'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "description",
                    "name" => "description",
                    "value" => $model_info->description,
                    "class" => "form-control",
                    "placeholder" => lang('description'),
                ));
                ?>
            </div>
        </div>
        <?php if (!$project_id) { ?>
            <div class="form-group">
                <label for="project_id" class=" col-md-3"><?php echo lang('project'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_dropdown("project_id", $projects_dropdown, array(), "class='select2 validate-hidden' id='project_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="points" class="col-md-3"><?php echo lang('points'); ?>
                <span class="help" data-toggle="tooltip" title="<?php echo lang('task_point_help_text'); ?>"><i class="fa fa-question-circle"></i></span>
            </label>

            <div class="col-md-9">
                <?php
                echo form_dropdown("points", $points_dropdown, array($model_info->points), "class='select2'");
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="milestone_id" class=" col-md-3"><?php echo lang('milestone'); ?></label>
            <div class="col-md-9" id="dropdown-apploader-section">
                <?php
                echo form_input(array(
                    "id" => "milestone_id",
                    "name" => "milestone_id",
                    "value" => $model_info->milestone_id,
                    "class" => "form-control",
                    "placeholder" => lang('milestone')
                ));
                ?>
            </div>
        </div>

        <?php if ($show_assign_to_dropdown) { ?>
            <div class="form-group">
                <label for="assigned_to" class=" col-md-3"><?php echo lang('assign_to'); ?></label>
                <div class="col-md-9" id="dropdown-apploader-section">
                    <?php
                    echo form_input(array(
                        "id" => "assigned_to",
                        "name" => "assigned_to",
                        "value" => $model_info->assigned_to,
                        "class" => "form-control",
                        "placeholder" => lang('assign_to')
                    ));
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label for="collaborators" class=" col-md-3"><?php echo lang('collaborators'); ?></label>
                <div class="col-md-9" id="dropdown-apploader-section">
                    <?php
                    echo form_input(array(
                        "id" => "collaborators",
                        "name" => "collaborators",
                        "value" => $model_info->collaborators,
                        "class" => "form-control",
                        "placeholder" => lang('collaborators')
                    ));
                    ?>
                </div>
            </div>

        <?php } ?>

        <div class="form-group">
            <label for="status_id" class=" col-md-3"><?php echo lang('status'); ?></label>
            <div class="col-md-9">
                <?php
                foreach ($statuses as $status) {
                    $task_status[$status->id] = $status->key_name ? lang($status->key_name) : $status->title;
                }

                echo form_dropdown("status_id", $task_status, array($model_info->status_id), "class='select2'");
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="project_labels" class=" col-md-3"><?php echo lang('labels'); ?></label>
            <div class=" col-md-9" id="dropdown-apploader-section">
                <?php
                echo form_input(array(
                    "id" => "project_labels",
                    "name" => "labels",
                    "value" => $model_info->labels,
                    "class" => "form-control",
                    "placeholder" => lang('labels')
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="start_date" class=" col-md-3"><?php echo lang('start_date'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "start_date",
                    "name" => "start_date",
                    "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                    "class" => "form-control",
                    "placeholder" => "YYYY-MM-DD"
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="deadline" class=" col-md-3"><?php echo lang('deadline'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "deadline",
                    "name" => "deadline",
                    "value" => is_date_exists($model_info->deadline) ? $model_info->deadline : "",
                    "class" => "form-control",
                    "placeholder" => "YYYY-MM-DD"
                ));
                ?>
            </div>
        </div>
        <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 

        <?php $this->load->view("includes/dropzone_preview"); ?>
    </div>

    <div class="modal-footer">
        <div id="link-of-task-view" class="hide">
            <?php
            echo modal_anchor(get_uri("projects/task_view"), "", array());
            ?>
        </div>

        <?php if (!$model_info->id) { ?>
            <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class="fa fa-camera"></i> <?php echo lang("upload_file"); ?></button>
        <?php } ?>

        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
        <button id="save-and-show-button" type="button" class="btn btn-info"><span class="fa fa-check-circle"></span> <?php echo lang('save_and_show'); ?></button>
        <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>




<script type="text/javascript">
    $(document).ready(function () {

<?php if (!$model_info->id) { ?>
            var uploadUrl = "<?php echo get_uri("projects/upload_file"); ?>";
            var validationUri = "<?php echo get_uri("projects/validate_project_file"); ?>";

            var dropzone = attachDropzoneWithForm("#tasks-dropzone", uploadUrl, validationUri);
<?php } ?>
        //send data to show the task after save
        window.showAddNewModal = false;

        $("#save-and-show-button").click(function () {
            window.showAddNewModal = true;
            $(this).trigger("submit");

        });
        var taskInfoText = "<?php echo lang('task_info') ?>";

        window.taskForm = $("#task-form").appForm({
            closeModalOnSuccess: false,
            onSuccess: function (result) {
                $("#task-table").appTable({newData: result.data, dataId: result.id});
                $("#reload-kanban-button").trigger("click");

                $("#save_and_show_value").append(result.save_and_show_link);

                if (window.showAddNewModal) {
                    var $taskViewLink = $("#link-of-task-view").find("a");
                    $taskViewLink.attr("data-title", taskInfoText + "#" + result.id);
                    $taskViewLink.attr("data-post-id", result.id);

                    $taskViewLink.trigger("click");
                } else {
                    window.taskForm.closeModal();
                }
            }
        });
        $("#task-form .select2").select2();
        $("#title").focus();

        setDatePicker("#start_date, #end_date, #deadline");

        //load all related data of the selected project
        $("#project_id").select2().on("change", function () {
            var projectId = $(this).val();
            if ($(this).val()) {
                $('#milestone_id').select2("destroy");
                $("#milestone_id").hide();
                $('#assigned_to').select2("destroy");
                $("#assigned_to").hide();
                $('#collaborators').select2("destroy");
                $("#collaborators").hide();
                $('#project_labels').select2("destroy");
                $("#project_labels").hide();
                appLoader.show({container: "#dropdown-apploader-section"});
                $.ajax({
                    url: "<?php echo get_uri("projects/get_all_related_data_of_selected_project") ?>" + "/" + projectId,
                    dataType: "json",
                    success: function (result) {
                        $("#milestone_id").show().val("");
                        $('#milestone_id').select2({data: result.milestones_dropdown});
                        $("#assigned_to").show().val("");
                        $('#assigned_to').select2({data: result.assign_to_dropdown});
                        $("#collaborators").show().val("");
                        $('#collaborators').select2({multiple: true, data: result.collaborators_dropdown});
                        $("#project_labels").show().val("");
                        $('#project_labels').select2({tags: result.label_suggestions});
                        appLoader.hide();
                    }
                });
            }
        });

        //intialized select2 dropdown for first time
        $("#project_labels").select2({tags: <?php echo json_encode($label_suggestions); ?>});
        $("#collaborators").select2({multiple: true, data: <?php echo json_encode($collaborators_dropdown); ?>});
        $('#milestone_id').select2({data: <?php echo json_encode($milestones_dropdown); ?>});
        $('#assigned_to').select2({data: <?php echo json_encode($assign_to_dropdown); ?>});

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>    