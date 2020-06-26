<?php echo form_open(get_uri("projects/save_cloned_project"), array("id" => "project-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="project_id" value="<?php echo $model_info->id; ?>" />

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
        <label for="client_id" class=" col-md-3"><?php echo lang('client'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_dropdown("client_id", $clients_dropdown, array($model_info->client_id), "class='select2 validate-hidden' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
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
    <div class="form-group">
        <label for="start_date" class=" col-md-3"><?php echo lang('start_date'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                "class" => "form-control",
                "placeholder" => lang('start_date')
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
                "placeholder" => lang('deadline')
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="price" class=" col-md-3"><?php echo lang('price'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "price",
                "name" => "price",
                "value" => $model_info->price ? to_decimal_format($model_info->price) : "",
                "class" => "form-control",
                "placeholder" => lang('price')
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="project_labels" class=" col-md-3"><?php echo lang('labels'); ?></label>
        <div class=" col-md-9">
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

    <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 

    <div class="form-group">
        <label for="copy_project_members"class=" col-md-12">
            <?php
            echo form_checkbox("copy_project_members", "1", true, "id='copy_project_members' disabled='disabled' class='pull-left mr15'");
            ?>    
            <?php echo lang('copy_project_members'); ?>
        </label>
    </div>

    <div class="form-group">
        <label for="copy_tasks"class=" col-md-12">
            <?php
            echo form_checkbox("copy_tasks", "1", true, "id='copy_tasks' disabled='disabled' class='pull-left '");
            ?>    
            <span class="pull-left ml15"> <?php echo lang('copy_tasks'); ?> (<?php echo lang("task_comments_will_not_be_included"); ?>) </span>
        </label>
    </div>

    <div class="form-group">
        <label for="copy_same_assignee_and_collaborators"class=" col-md-12">
            <?php
            echo form_checkbox("copy_same_assignee_and_collaborators", "1", true, "id='copy_same_assignee_and_collaborators'  class='pull-left '");
            ?>    
            <span class="pull-left ml15"> <?php echo lang('copy_same_assignee_and_collaborators'); ?> </span>
        </label>
    </div>
    <div class="form-group">
        <label for="copy_tasks_start_date_and_deadline"class=" col-md-12">
            <?php
            echo form_checkbox("copy_tasks_start_date_and_deadline", "1", false, "id='copy_tasks_start_date_and_deadline'  class='pull-left '");
            ?>    
            <span class="pull-left ml15"> <?php echo lang('copy_tasks_start_date_and_deadline'); ?> </span>
        </label>
    </div>

    <div class="form-group">
        <label for="copy_milestones"class=" col-md-12">
            <?php
            echo form_checkbox("copy_milestones", "1", false, "id='copy_milestones'  class='pull-left '");
            ?>    
            <span class="pull-left ml15"> <?php echo lang('copy_milestones'); ?> </span>
        </label>
    </div>



</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#project-form").appForm({
            onSuccess: function (result) {
                appAlert.success(result.message);
                setTimeout(function () {
                    window.location = "<?php echo site_url('projects/view'); ?>/" + result.id;
                }, 2000);
            }
        });
        $("#title").focus();
        $("#project-form .select2").select2();

        setDatePicker("#start_date, #deadline");

        $("#project_labels").select2({
            tags: <?php echo json_encode($label_suggestions); ?>
        });
    });
</script>    