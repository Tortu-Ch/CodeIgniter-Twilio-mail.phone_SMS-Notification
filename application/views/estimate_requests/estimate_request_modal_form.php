<div class="modal-body clearfix">

    <?php echo form_open(get_uri("estimate_requests/save_estimate_request_form"), array("id" => "estimate-form", "class" => "general-form", "role" => "form")); ?>
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
                "style" => "height:150px;",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class=" col-md-3"><?php echo lang('status'); ?></label>
        <div class="col-md-9">
            <?php
            $status_dropdown = array("active" => lang("active"), "inactive" => lang("inactive"));
            echo form_dropdown("status", $status_dropdown, $model_info->status, "class='select2'");
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="public" class="col-md-3"><?php echo lang('public'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("public", "1", $model_info->public ? true : false, "id='public'");
            ?>                       
        </div>
    </div>

    <div class="form-group">
        <label for="enable_attachment" class="col-md-3"><?php echo lang('enable_attachment'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("enable_attachment", "1", $model_info->enable_attachment ? true : false, "id='enable_attachment'");
            ?>                       
        </div>
    </div>

    <div class="row">
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
            <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>

    <?php echo form_close(); ?>

</div>



<script type="text/javascript">
    $(document).ready(function () {

        $("#estimate-form").appForm({
            onSuccess: function (result) {
                if (result.newData) {
                    window.location = "<?php echo site_url('estimate_requests/edit_estimate_form'); ?>/" + result.id;
                } else {
                    $("#estimate-form-main-table").appTable({newData: result.data, dataId: result.id});
                }
            }
        });

        $("#estimate-form .select2").select2();

    });

</script>