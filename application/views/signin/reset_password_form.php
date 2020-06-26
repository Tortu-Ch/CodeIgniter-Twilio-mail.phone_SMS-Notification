<div class="panel panel-default mb15">
    <div class="panel-heading text-center">
        <?php if (get_setting("show_logo_in_signin_page") === "yes") { ?>
            <img class="p20" src="<?php echo get_file_uri(get_setting("system_file_path") . get_setting("site_logo")); ?>" />
        <?php } else { ?>
            <h2><?php echo lang('forgot_password'); ?></h2>
        <?php } ?>
    </div>
    <div class="panel-body p30">
        <?php echo form_open("signin/send_reset_password_mail", array("id" => "request-password-form", "class" => "general-form", "role" => "form")); ?>

        <div class="form-group">
            <label for="email" class=""><?php echo lang("input_email_to_reset_password"); ?></label>
            <?php
            echo form_input(array(
                "id" => "email",
                "name" => "email",
                "class" => "form-control p10",
                "placeholder" => lang('email'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-email" => true,
                "data-msg-email" => lang("enter_valid_email")
            ));
            ?>
        </div>


        <?php $this->load->view("signin/re_captcha"); ?>



        <div class="form-group mb0">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo lang('send'); ?></button>
        </div>
        <?php echo form_close(); ?>
        <div class="mt5"><?php echo anchor("signin", lang("signin")); ?></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#request-password-form").appForm({
            isModal: false,
            onSubmit: function () {
                appLoader.show();
                $("#request-password-form").find('[type="submit"]').attr('disabled', 'disabled');
            },
            onSuccess: function (result) {
                appLoader.hide();
                appAlert.success(result.message, {container: '.panel-body', animate: false});
                $("#request-password-form").remove();
            },
            onError: function (result) {
                $("#request-password-form").find('[type="submit"]').removeAttr('disabled');
                appLoader.hide();
                appAlert.error(result.message, {container: '.panel-body', animate: false});
                return false;
            }
        });
    });
</script>
