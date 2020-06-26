<?php
$site_key = get_setting("re_captcha_site_key");
$secret_key = get_setting("re_captcha_secret_key");

if ($site_key && $secret_key) {
    ?>

    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
    </div>


    <script type="text/javascript"src="https://www.google.com/recaptcha/api.js?hl=<?php echo lang('language_locale'); ?>"></script>

<?php } ?>