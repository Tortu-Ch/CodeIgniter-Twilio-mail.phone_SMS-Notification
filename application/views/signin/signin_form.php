<div class="panel panel-default mb15">
    <div class="panel-heading text-center">
        <?php if (get_setting("show_logo_in_signin_page") === "yes") { ?>
            <img class="p20" src="<?php echo get_file_uri(get_setting("system_file_path") . get_setting("site_logo")); ?>" />
        <?php } else { ?>
            <h2><?php echo lang('signin'); ?></h2>
        <?php } ?>
    </div>
    <div class="panel-body p30">
        <?php echo form_open("signin", array("id" => "signin-form", "class" => "general-form", "role" => "form")); ?>

        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <div class="form-group">
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
        <div class="form-group">
            <?php
            echo form_password(array(
                "id" => "password",
                "name" => "password",
                "class" => "form-control p10",
                "placeholder" => lang('password'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
        <input type="hidden" name="redirect" value="<?php
        if (isset($redirect)) {
            echo $redirect;
        }
        ?>" />


        <?php $this->load->view("signin/re_captcha"); ?>


        <div class="form-group mb0">
            <button class="btn btn-lg btn-primary btn-block mt15" type="submit"><?php echo lang('signin'); ?></button>
        </div>
        <?php echo form_close(); ?>
        <div class="mt5"><?php echo anchor("signin/request_reset_password", lang("forgot_password")); ?></div>

        <?php if (!get_setting("disable_client_signup")) { ?>
            <div class="mt20"><?php echo lang("you_dont_have_an_account") ?> &nbsp; <?php echo anchor("signup", lang("signup")); ?></div>
        <?php } ?>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#signin-form").appForm({ajaxSubmit: false, isModal: false});
    });
</script>