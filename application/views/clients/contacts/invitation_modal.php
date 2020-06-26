<?php echo form_open(get_uri("clients/send_invitation"), array("id" => "invitation-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <br />
    <div class="form-group mb15">
        <input type="hidden" name="client_id" value="<?php echo $client_info->id; ?>" />

        <label for="email" class=" col-md-12"><?php echo sprintf(lang('invite_an_user'), $client_info->company_name); ?></label>
        <div class="col-md-12">
            <?php
            echo form_input(array(
                "id" => "email",
                "name" => "email",
                "class" => "form-control",
                "placeholder" => lang('email'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-email" => true,
                "data-msg-required" => lang("enter_valid_email")
            ));
            ?>
        </div>
    </div>
    <br />
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-send"></span> <?php echo lang('send'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#invitation-form").appForm({
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });
        $("#email").focus();
    });
</script>    