<input type="hidden" name="contact_id" value="<?php echo $model_info->id; ?>" />
<input type="hidden" name="client_id" value="<?php echo $model_info->client_id; ?>" />
<div class="form-group">
    <?php
    $label_column = isset($label_column) ? $label_column : "col-md-3";
    $field_column = isset($field_column) ? $field_column : "col-md-9";
    ?>
    <label for="first_name" class="<?php echo $label_column; ?>"><?php echo lang('first_name'); ?></label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "first_name",
            "name" => "first_name",
            "value" => $model_info->first_name,
            "class" => "form-control",
            "placeholder" => lang('first_name'),
            "data-rule-required" => true,
            "data-msg-required" => lang("field_required"),
        ));
        ?>
    </div>
</div>
<div class="form-group">
    <label for="last_name" class="<?php echo $label_column; ?>"><?php echo lang('last_name'); ?></label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "last_name",
            "name" => "last_name",
            "value" => $model_info->last_name,
            "class" => "form-control",
            "placeholder" => lang('last_name'),
            "data-rule-required" => true,
            "data-msg-required" => lang("field_required"),
        ));
        ?>
    </div>
</div>
<?php
//show these filds during new contact creation
if (!$model_info->id) {
    ?>
    <div class="form-group">
        <label for="email" class="<?php echo $label_column; ?>"><?php echo lang('email'); ?></label>
        <div class="<?php echo $field_column; ?>">
            <?php
            echo form_input(array(
                "id" => "email",
                "name" => "email",
                "value" => $model_info->email,
                "class" => "form-control",
                "placeholder" => lang('email'),
                "data-rule-email" => true,
                "data-msg-email" => lang("enter_valid_email"),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "autocomplete" => "off"
            ));
            ?>
        </div>
    </div>
<?php } ?>
<div class="form-group">
    <label for="phone" class="<?php echo $label_column; ?>"><?php echo lang('phone'); ?></label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "phone",
            "name" => "phone",
            "value" => $model_info->phone ? $model_info->phone : "",
            "class" => "form-control",
            "placeholder" => lang('phone')
        ));
        ?>
    </div>
</div>
<div class="form-group">
    <label for="skype" class="<?php echo $label_column; ?>">Skype</label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "skype",
            "name" => "skype",
            "value" => $model_info->skype ? $model_info->skype : "",
            "class" => "form-control",
            "placeholder" => "Skype"
        ));
        ?>
    </div>
</div>
<div class="form-group">
    <label for="job_title" class="<?php echo $label_column; ?>"><?php echo lang('job_title'); ?></label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_input(array(
            "id" => "job_title",
            "name" => "job_title",
            "value" => $model_info->job_title,
            "class" => "form-control",
            "placeholder" => lang('job_title')
        ));
        ?>
    </div>
</div>
<div class="form-group">
    <label for="gender" class="<?php echo $label_column; ?>"><?php echo lang('gender'); ?></label>
    <div class="<?php echo $field_column; ?>">
        <?php
        echo form_radio(array(
            "id" => "gender_male",
            "name" => "gender",
            "data-msg-required" => lang("field_required"),
                ), "male", ($model_info->gender == "female") ? false : true);
        ?>
        <label for="gender_male" class="mr15"><?php echo lang('male'); ?></label> <?php
        echo form_radio(array(
            "id" => "gender_female",
            "name" => "gender",
            "data-msg-required" => lang("field_required"),
                ), "female", ($model_info->gender == "female") ? true : false);
        ?>
        <label for="gender_female" class=""><?php echo lang('female'); ?></label>
    </div>
</div>

<?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => $label_column, "field_column" => $field_column)); ?> 

<?php
//show these filds during new contact creation
//also check the client login setting

if (!$model_info->id && !get_setting("disable_client_login")) {
    ?>
    <div class="form-group">
        <label for="login_password" class="col-md-3"><?php echo lang('password'); ?></label>
        <div class=" col-md-8">
            <div class="input-group">
                <?php
                $password_field = array(
                    "id" => "login_password",
                    "name" => "login_password",
                    "class" => "form-control",
                    "placeholder" => lang('password'),
                    "readonly" => "readonly",
                    "onfocus"=>"this.removeAttribute('readonly');",
                    "style" => "z-index:auto;"
                );
                if (!$model_info->id) {
                    //this filed is required for new record
                    $password_field["data-rule-required"] = true;
                    $password_field["data-msg-required"] = lang("field_required");
                    $password_field["data-rule-minlength"] = 6;
                    $password_field["data-msg-minlength"] = lang("enter_minimum_6_characters");
                }
                echo form_password($password_field);
                ?>
                <label for="password" class="input-group-addon clickable" id="generate_password"><span class="fa fa-key"></span> <?php echo lang('generate'); ?></label>
            </div>
        </div>
        <div class="col-md-1 p0">
            <a href="#" id="show_hide_password" class="btn btn-default" title="<?php echo lang('show_text'); ?>"><span class="fa fa-eye"></span></a>
        </div>
    </div>

    <div class="form-group ">
        <div class="col-md-12">  
            <?php
            echo form_checkbox("email_login_details", "1", true, "id='email_login_details'");
            ?> <label for="email_login_details"><?php echo lang('email_login_details'); ?></label>
        </div>
    </div>
<?php } else if ($this->login_user->is_admin) { ?>
    <div class="form-group ">
        <label for="is_primary_contact"  class="<?php echo $label_column; ?>"><?php echo lang('primary_contact'); ?></label>

        <div class="<?php echo $field_column; ?>">
            <?php
            //is set primary contact, disable the checkbox
            $disable = "";
            if ($model_info->is_primary_contact) {
                $disable = "disabled='disabled'";
            }
            echo form_checkbox("is_primary_contact", "1", $model_info->is_primary_contact, "id='is_primary_contact' $disable");
            ?> 
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#generate_password").click(function() {
            $("#login_password").val(getRndomString(8));
        });
        $("#show_hide_password").click(function() {
            var $target = $("#login_password"),
                    type = $target.attr("type");
            if (type === "password") {
                $(this).attr("title", "<?php echo lang("hide_text"); ?>");
                $(this).html("<span class='fa fa-eye-slash'></span>");
                $target.attr("type", "text");
            } else if (type === "text") {
                $(this).attr("title", "<?php echo lang("show_text"); ?>");
                $(this).html("<span class='fa fa-eye'></span>");
                $target.attr("type", "password");
            }
        });
    });
</script>    