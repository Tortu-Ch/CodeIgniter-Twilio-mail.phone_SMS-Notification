<div class="panel panel-default mb15">
    <div class="panel-heading text-center">
        <?php if (get_setting("show_logo_in_signin_page") === "yes") { ?>
            <img class="p20" src="<?php echo get_file_uri(get_setting("system_file_path") . get_setting("site_logo")); ?>" />
        <?php } else { ?>
            <h2><?php echo lang('reset_password'); ?></h2>
        <?php } ?>
    </div>
    <div class="panel-body p30">
        <?php echo form_open("signin/do_reset_password", array("id" => "reset-password-form", "class" => "general-form", "role" => "form")); ?>
        <div class="form-group">
            <input type="hidden" name="key"  value="<?php echo isset($key) ? $key : ''; ?>" />
            <label for="password" class=""><?php echo lang('password'); ?></label>
            <div class="">
                <?php
                echo form_password(array(
                    "id" => "password",
                    "name" => "password",
                    "class" => "form-control p10",
                    "data-rule-required" => true,
                    "data-rule-minlength" => 6,
                    "data-msg-minlength" => lang("enter_minimum_6_characters"),
                    "autocomplete" => "off",
                    "style" => "z-index:auto;"
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="retype_password" class=""><?php echo lang('retype_password'); ?></label>
            <div class="">
                <?php
                echo form_password(array(
                    "id" => "retype_password",
                    "name" => "retype_password",
                    "class" => "form-control p10",
                    "autocomplete" => "off",
                    "style" => "z-index:auto;",
                    "data-rule-equalTo" => "#password",
                    "data-msg-equalTo" => lang("enter_same_value")
                ));
                ?>
            </div>
        </div>
        <div class="form-group mb0">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo lang('reset_password'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#reset-password-form").appForm({
            isModal: false,
            onSubmit: function () {
                appLoader.show();
            },
            onSuccess: function (result) {
                appLoader.hide();
                appAlert.success(result.message, {container: '.panel-body', animate: false});
                $("#reset-password-form").remove();
            },
            onError: function (result) {
                appLoader.hide();
                appAlert.error(result.message, {container: '.panel-body', animate: false});
                return false;
            }
        });
    });
</script>