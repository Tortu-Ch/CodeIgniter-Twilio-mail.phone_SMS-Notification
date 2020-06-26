<div class="modal-body clearfix">
    <div>
        <?php echo form_open(get_uri("estimate_requests/update_estimate_request"), array("id" => "estimate-request-update-form", "class" => "general-form", "role" => "form")); ?>
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

        <div class="form-group">
            <label for="assigned_to" class=" col-md-3"><?php echo lang('assign_to'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_dropdown("assigned_to", $assigned_to_dropdown, $model_info->assigned_to, "class='select2'");
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
</div>



<script type="text/javascript">
    $(document).ready(function () {

        $("#estimate-request-update-form").appForm({
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
                location.reload();
            }
        });
      
        $("#estimate-request-update-form .select2").select2();
        
    });

</script>