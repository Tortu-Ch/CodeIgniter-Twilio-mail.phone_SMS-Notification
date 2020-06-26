<div class="panel panel-default no-border clearfix mb0">

    <?php echo form_open(get_uri("settings/save_re_captcha_settings"), array("id" => "re-captcha-form", "class" => "general-form dashed-row", "role" => "form")); ?>

    <div class="panel-body">

        <div class="form-group">
            <label for="company_name" class=" col-md-12">
                <?php echo lang("get_your_key_from_here") . " " . anchor("https://www.google.com/recaptcha/admin", "Google reCAPTCHA", array("target" => "_blank")); ?>
            </label>
        </div>

        <div class="form-group">
            <label for="re_captcha_site_key" class=" col-md-2"><?php echo lang('re_captcha_site_key'); ?></label>
            <div class=" col-md-10">
                <?php
                echo form_input(array(
                    "id" => "re_captcha_site_key",
                    "name" => "re_captcha_site_key",
                    "value" => get_setting("re_captcha_site_key"),
                    "class" => "form-control",
                    "placeholder" => lang('re_captcha_site_key')
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="re_captcha_secret_key" class=" col-md-2"><?php echo lang('re_captcha_secret_key'); ?></label>
            <div class=" col-md-10">
                <?php
                echo form_input(array(
                    "id" => "re_captcha_secret_key",
                    "name" => "re_captcha_secret_key",
                    "value" => get_setting("re_captcha_secret_key"),
                    "class" => "form-control",
                    "placeholder" => lang('re_captcha_secret_key')
                ));
                ?>
            </div>
        </div>

    </div>

    <div class="panel-footer">
        <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#re-captcha-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });

    });
</script>