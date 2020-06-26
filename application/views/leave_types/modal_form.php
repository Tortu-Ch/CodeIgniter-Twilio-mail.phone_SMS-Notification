<?php echo form_open(get_uri("leave_types/save"), array("id" => "leave-type-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
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
            <div class="mt15">
              <?php $this->load->view("includes/color_plate"); ?>
            </div>
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
        <label for="status" class=" col-md-3"><?php echo lang('status'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_radio(array(
                "id" => "status_active",
                "name" => "status",
                "data-msg-required" => lang("field_required"),
                    ), "active", ($model_info->status === "active") ? true : ($model_info->status !== "inactive") ? true : false);
            ?>
            <label for="status_active" class="mr15"><?php echo lang('active'); ?></label>
            <?php
            echo form_radio(array(
                "id" => "status_inactive",
                "name" => "status",
                "data-msg-required" => lang("field_required"),
                    ), "inactive", ($model_info->status === "inactive") ? true : false);
            ?>
            <label for="status_inactive" class=""><?php echo lang('inactive'); ?></label>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#leave-type-form").appForm({
            onSuccess: function(result) {
                $("#leave-type-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $("#name").focus();

    });
</script>    