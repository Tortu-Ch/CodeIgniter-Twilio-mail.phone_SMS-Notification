<div class="modal-body clearfix">

    <?php echo form_open(get_uri("estimate_requests/save_estimate_form_field"), array("id" => "estimate-form", "class" => "general-form", "role" => "form")); ?>
    
    <input type="hidden" name="estimate_form_id" value="<?php echo $estimate_form_id; ?>" />

    <?php $this->load->view("custom_fields/form/input_fields"); ?>

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
                location.reload();
            }
        });

    });
</script>