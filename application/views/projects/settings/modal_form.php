<?php echo form_open(get_uri("projects/save_settings"), array("id" => "project-settings-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />

    <div class="form-group mb20 mt20">
        <label for="client_can_view_timesheet" class="col-md-12">
            <?php
            echo form_checkbox("client_can_view_timesheet", "1", get_setting("client_can_view_timesheet") ? true : false, "id='client_can_view_timesheet' class='mr15'");
            ?>          
            <?php echo lang('client_can_view_timesheet'); ?>
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
        $("#project-settings-form").appForm({
        });
    });
</script>    