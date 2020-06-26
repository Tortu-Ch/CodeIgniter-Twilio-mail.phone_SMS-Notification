<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head'); ?>
    </head>
    <body>
        <?php
        if (get_setting("show_background_image_in_signin_page") === "yes") {
            $background_url = get_file_uri('files/system/sigin-background-image.jpg');
            ?>
            <style type="text/css">
                body {background-image: url('<?php echo $background_url; ?>'); background-size:cover}
            </style>
        <?php } ?>
        <div id="page-content" class="clearfix">
            <div class="scrollable-page">
                <div class="signin-box">
                    <div class="panel panel-default clearfix">
                        <div class="panel-heading text-center">
                            <h2 class="form-signin-heading"><?php echo lang('signup'); ?></h2>
                            <p><?php echo $signup_message; ?></p>
                        </div>
                        <div class="panel-body">
<?php echo form_open("signup/create_account", array("id" => "signup-form", "class" => "general-form", "role" => "form")); ?>

                            <div class="form-group">
                                <label for="name" class=" col-md-12"><?php echo lang('first_name'); ?></label>
                                <div class="col-md-12">
                                    <?php
                                    echo form_input(array(
                                        "id" => "first_name",
                                        "name" => "first_name",
                                        "class" => "form-control",
                                        "autofocus" => true,
                                        "data-rule-required" => true,
                                        "data-msg-required" => lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

                            <input type="hidden" name="signup_key"  value="<?php echo isset($signup_key) ? $signup_key : ''; ?>" />
                            <div class="form-group">
                                <label for="last_name" class=" col-md-12"><?php echo lang('last_name'); ?></label>
                                <div class=" col-md-12">
                                    <?php
                                    echo form_input(array(
                                        "id" => "last_name",
                                        "name" => "last_name",
                                        "class" => "form-control",
                                        "data-rule-required" => true,
                                        "data-msg-required" => lang("field_required"),
                                    ));
                                    ?>
                                </div>
                            </div>

<?php if ($signup_type === "new_client") { ?>
                                <div class="form-group">
                                    <label for="company_name" class=" col-md-12"><?php echo lang('company_name'); ?></label>
                                    <div class=" col-md-12">
                                        <?php
                                        echo form_input(array(
                                            "id" => "company_name",
                                            "name" => "company_name",
                                            "class" => "form-control",
                                            "data-rule-required" => true,
                                            "data-msg-required" => lang("field_required"),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

<?php if ($type === "staff") { ?>
                                <div class="form-group">
                                    <label for="job_title" class=" col-md-12"><?php echo lang('job_title'); ?></label>
                                    <div class=" col-md-12">
                                        <?php
                                        echo form_input(array(
                                            "id" => "job_title",
                                            "name" => "job_title",
                                            "class" => "form-control"
                                        ));
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
<?php if ($signup_type === "new_client") { ?>
                                <div class="form-group">
                                    <label for="email" class=" col-md-12"><?php echo lang('email'); ?></label>
                                    <div class=" col-md-12">
                                        <?php
                                        echo form_input(array(
                                            "id" => "email",
                                            "name" => "email",
                                            "class" => "form-control",
                                            "autofocus" => true,
                                            "data-rule-email" => true,
                                            "data-msg-email" => lang("enter_valid_email"),
                                            "data-rule-required" => true,
                                            "data-msg-required" => lang("field_required"),
                                        ));
                                        ?>
                                    </div>
                                </div>
<?php } ?>

                            <div class="form-group">
                                <label for="password" class="col-md-12"><?php echo lang('password'); ?></label>
                                <div class=" col-md-12">
                                    <?php
                                    echo form_password(array(
                                        "id" => "password",
                                        "name" => "password",
                                        "class" => "form-control",
                                        "data-rule-required" => true,
                                        "data-msg-required" => lang("field_required"),
                                        "data-rule-minlength" => 6,
                                        "data-msg-minlength" => lang("enter_minimum_6_characters"),
                                        "autocomplete" => "off",
                                        "style" => "z-index:auto;"
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="retype_password" class="col-md-12"><?php echo lang('retype_password'); ?></label>
                                <div class=" col-md-12">
                                    <?php
                                    echo form_password(array(
                                        "id" => "retype_password",
                                        "name" => "retype_password",
                                        "class" => "form-control",
                                        "autocomplete" => "off",
                                        "style" => "z-index:auto;",
                                        "data-rule-equalTo" => "#password",
                                        "data-msg-equalTo" => lang("enter_same_value")
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class=" col-md-12"><?php echo lang('gender'); ?></label>
                                <div class=" col-md-12">
                                    <?php
                                    echo form_radio(array(
                                        "id" => "gender_male",
                                        "name" => "gender",
                                            ), "male", true);
                                    ?>
                                    <label for="gender_male" class="mr15"><?php echo lang('male'); ?></label> <?php
                                    echo form_radio(array(
                                        "id" => "gender_female",
                                        "name" => "gender",
                                            ), "female", false);
                                    ?>
                                    <label for="gender_female" class=""><?php echo lang('female'); ?></label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                  <?php $this->load->view("signin/re_captcha"); ?>
                            </div>

                            <div class="form-group">
                                <div class=" col-md-12">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo lang('signup'); ?></button>
                                </div>
                            </div>
                        </div>
<?php echo form_close(); ?>
                    </div>
                    <div id="signin_link"><?php echo lang("already_have_an_account") . " " . anchor("signin", lang("signin")); ?></div>
                </div>
            </div>
        </div> <!-- /container -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#signup-form").appForm({
                    isModal: false,
                    onSubmit: function () {
                        appLoader.show();
                    },
                    onSuccess: function (result) {
                        appLoader.hide();
                        appAlert.success(result.message, {container: '.panel-body', animate: false});
                        $("#signup-form").remove();
                        $("#signin_link").remove();
                    },
                    onError: function (result) {
                        appLoader.hide();
                        appAlert.error(result.message, {container: '.panel-body', animate: false});
                        return false;
                    }
                });
            });
        </script>
    </body>
</html>