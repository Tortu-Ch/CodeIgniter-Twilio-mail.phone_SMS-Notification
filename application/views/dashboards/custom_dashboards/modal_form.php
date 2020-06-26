<?php echo form_open(get_uri("dashboard/save"), array("id" => "dashboard-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="data" value='<?php echo json_encode(unserialize($model_info->data)); ?>' />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "class" => "form-control",
                "placeholder" => lang("title"),
                "value" => $model_info->title,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class=" col-md-3"></label>
        <div class="col-md-9">
            <?php $this->load->view("includes/color_plate"); ?>
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>




<script>
    $(document).ready(function () {
        $("#title").focus();

        $("#dashboard-form").appForm({
            onSuccess: function (result) {
                if (window.dashboardTitleEditMode) {
                    window.dashboardTitleEditMode = false;
                    location.reload();
                } else {
                    window.location = "<?php echo get_uri("dashboard/edit_dashboard"); ?>/" + result.dashboard_id;
                }
            }
        });
    });
</script>    