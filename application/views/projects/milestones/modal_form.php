<?php echo form_open(get_uri("projects/save_milestone"), array("id" => "milestone-form", "class" => "general-form", "role" => "form")); ?>
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
                "placeholder" => lang('description')
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="due_date" class=" col-md-3"><?php echo lang('due_date'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "due_date",
                "name" => "due_date",
                "value" => $model_info->due_date,
                "class" => "form-control",
                "placeholder" => lang('due_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#milestone-form").appForm({
            onSuccess: function (result) {
                $("#milestone-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $("#title").focus();

        setDatePicker("#due_date");

    });
</script>    