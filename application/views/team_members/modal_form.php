<?php echo form_open(get_uri("team_members/add_team_member"), array("id" => "team_member-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    <div class="form-widget">
        <div class="widget-title clearfix">
            <div id="general-info-label" class="col-sm-4"><i class="fa fa-circle-o"></i><strong> <?php echo lang('general_info'); ?></strong></div>
            <div id="job-info-label" class="col-sm-4"><i class="fa fa-circle-o"></i><strong>  <?php echo lang('job_info'); ?></strong></div>
            <div id="account-info-label" class="col-sm-4"><i class="fa fa-circle-o"></i><strong>  <?php echo lang('account_settings'); ?></strong></div> 
        </div>

        <div class="progress ml15 mr15">
            <div id="form-progress-bar" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
            </div>
        </div>
    </div>

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
            <div class="form-group">
                <label for="name" class=" col-md-3"><?php echo lang('first_name'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "first_name",
                        "name" => "first_name",
                        "class" => "form-control",
                        "placeholder" => lang('first_name'),
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class=" col-md-3"><?php echo lang('last_name'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "last_name",
                        "name" => "last_name",
                        "class" => "form-control",
                        "placeholder" => lang('last_name'),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class=" col-md-3"><?php echo lang('mailing_address'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "address",
                        "name" => "address",
                        "class" => "form-control",
                        "placeholder" => lang('mailing_address')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class=" col-md-3"><?php echo lang('phone'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "phone",
                        "name" => "phone",
                        "class" => "form-control",
                        "placeholder" => lang('phone')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class=" col-md-3"><?php echo lang('gender'); ?></label>
                <div class=" col-md-9">
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
            
            
        <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" =>"col-md-3", "field_column" => " col-md-9")); ?> 
            
        </div>
        <div role="tabpanel" class="tab-pane" id="job-info-tab">
            <div class="form-group">
                <label for="job_title" class=" col-md-3"><?php echo lang('job_title'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "job_title",
                        "name" => "job_title",
                        "class" => "form-control",
                        "placeholder" => lang('job_title'),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="salary" class=" col-md-3"><?php echo lang('salary'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "salary",
                        "name" => "salary",
                        "class" => "form-control",
                        "placeholder" => lang('salary')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="salary_term" class=" col-md-3"><?php echo lang('salary_term'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "salary_term",
                        "name" => "salary_term",
                        "class" => "form-control",
                        "placeholder" => lang('salary_term')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="date_of_hire" class=" col-md-3"><?php echo lang('date_of_hire'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "date_of_hire",
                        "name" => "date_of_hire",
                        "class" => "form-control",
                        "placeholder" => lang('date_of_hire')
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="account-info-tab">
            <div class="form-group">
                <label for="email" class=" col-md-3"><?php echo lang('email'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "email",
                        "name" => "email",
                        "class" => "form-control",
                        "placeholder" => lang('email'),
                        "autofocus" => true,
                        "autocomplete" => "off",
                        "data-rule-email" => true,
                        "data-msg-email" => lang("enter_valid_email"),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-md-3"><?php echo lang('password'); ?></label>
                <div class=" col-md-8">
                    <div class="input-group">
                        <?php
                        echo form_password(array(
                            "id" => "password",
                            "name" => "password",
                            "class" => "form-control",
                            "placeholder" => lang('password'),
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => lang("field_required"),
                            "data-rule-minlength" => 6,
                            "data-msg-minlength" => lang("enter_minimum_6_characters"),
                            "autocomplete" => "off",
                            "style" => "z-index:auto;"
                        ));
                        ?>
                        <label for="password" class="input-group-addon clickable" id="generate_password"><span class="fa fa-key"></span> <?php echo lang('generate'); ?></label>
                    </div>
                </div>
                <div class="col-md-1 p0">
                    <a href="#" id="show_hide_password" class="btn btn-default" title="<?php echo lang('show_text'); ?>"><span class="fa fa-eye"></span></a>
                </div>
            </div>
            <div class="form-group">
                <label for="role" class="col-md-3"><?php echo lang('role'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_dropdown("role", $role_dropdown, array(), "class='select2' id='user-role'");
                    ?>
                    <div id="user-role-help-block" class="help-block ml10 hide"><i class="fa fa-warning text-warning"></i> <?php echo lang("admin_user_has_all_power"); ?></div>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-md-12">  
                    <?php
                    echo form_checkbox("email_login_details", "1", true, "id='email_login_details'");
                    ?> <label for="email_login_details"><?php echo lang('email_login_details'); ?></label>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button id="form-previous" type="button" class="btn btn-default hide"><span class="fa fa-arrow-circle-left"></span> <?php echo lang('previous'); ?></button>
    <button id="form-next" type="button" class="btn btn-info"><span class="fa  fa-arrow-circle-right"></span> <?php echo lang('next'); ?></button>
    <button id="form-submit" type="button" class="btn btn-primary hide"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#team_member-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    $("#team_member-table").appTable({newData: result.data, dataId: result.id});
                }
            },
            onSubmit: function() {
                $("#form-previous").attr('disabled', 'disabled');
            },
            onAjaxSuccess: function() {
                $("#form-previous").removeAttr('disabled');
            }
        });

        $("#team_member-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                if ($('#form-submit').hasClass('hide')) {
                    $("#form-next").trigger('click');
                } else {
                    $("#team_member-form").trigger('submit');
                }
            }
        });
        $("#first_name").focus();
        $("#team_member-form .select2").select2();

        setDatePicker("#date_of_hire");

        $("#form-previous").click(function() {
            var $generalTab = $("#general-info-tab"),
                    $jobTab = $("#job-info-tab"),
                    $accountTab = $("#account-info-tab"),
                    $previousButton = $("#form-previous"),
                    $nextButton = $("#form-next"),
                    $submitButton = $("#form-submit");

            if ($accountTab.hasClass("active")) {
                $accountTab.removeClass("active");
                $jobTab.addClass("active");
                $nextButton.removeClass("hide");
                $submitButton.addClass("hide");
            } else if ($jobTab.hasClass("active")) {
                $jobTab.removeClass("active");
                $generalTab.addClass("active");
                $previousButton.addClass("hide");
                $nextButton.removeClass("hide");
                $submitButton.addClass("hide");
            }
        });

        $("#form-next").click(function() {
            var $generalTab = $("#general-info-tab"),
                    $jobTab = $("#job-info-tab"),
                    $accountTab = $("#account-info-tab"),
                    $previousButton = $("#form-previous"),
                    $nextButton = $("#form-next"),
                    $submitButton = $("#form-submit");
            if (!$("#team_member-form").valid()) {
                return false;
            }
            if ($generalTab.hasClass("active")) {
                $generalTab.removeClass("active");
                $jobTab.addClass("active");
                $previousButton.removeClass("hide");
                $("#form-progress-bar").width("35%");
                $("#general-info-label").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#team_member_id").focus();
            } else if ($jobTab.hasClass("active")) {
                $jobTab.removeClass("active");
                $accountTab.addClass("active");
                $previousButton.removeClass("hide");
                $nextButton.addClass("hide");
                $submitButton.removeClass("hide");
                $("#form-progress-bar").width("72%");
                $("#job-info-label").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#username").focus();
            }
        });

        $("#form-submit").click(function() {
            $("#team_member-form").trigger('submit');
        });

        $("#generate_password").click(function() {
            $("#password").val(getRndomString(8));
        });

        $("#show_hide_password").click(function() {
            var $target = $("#password"),
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

        $("#user-role").change(function() {
            if ($(this).val() === "admin") {
                $("#user-role-help-block").removeClass("hide");
            } else {
                $("#user-role-help-block").addClass("hide");
            }
        });
    });
</script>