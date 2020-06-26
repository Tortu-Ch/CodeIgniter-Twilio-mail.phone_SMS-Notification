<?php $this->load->view("includes/cropbox"); ?>
<div id="page-content" class="clearfix">
    <div class="bg-success clearfix">
        <div class="col-md-6">
            <div class="row p20">
                <?php $this->load->view("users/profile_image_section"); ?>
            </div>
        </div>

        <div class="col-md-6 text-center cover-widget">
            <div class="row p20">
                <?php
                count_project_status_widget($user_info->id);
                count_total_time_widget($user_info->id);
                ?> 
            </div>
        </div>
    </div>


    <ul data-toggle="ajax-tab" class="nav nav-tabs" role="tablist">

        <?php if ($show_timeline) { ?>
            <li><a  role="presentation" class="active" href="javascript:;" data-target="#tab-timeline"> <?php echo lang('timeline'); ?></a></li>
        <?php } ?>

        <?php if ($show_general_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("team_members/general_info/" . $user_info->id); ?>" data-target="#tab-general-info"> <?php echo lang('general_info'); ?></a></li>
        <?php } ?>

        <?php if ($show_general_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("team_members/social_links/" . $user_info->id); ?>" data-target="#tab-social-links"> <?php echo lang('social_links'); ?></a></li>
        <?php } ?>

        <?php if ($show_job_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("team_members/job_info/" . $user_info->id); ?>" data-target="#tab-job-info"> <?php echo lang('job_info'); ?></a></li>
        <?php } ?>

        <?php if ($show_account_settings) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/account_settings/" . $user_info->id); ?>" data-target="#tab-account-settings"> <?php echo lang('account_settings'); ?></a></li>
        <?php } ?>

        <?php if ($this->login_user->id == $user_info->id) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/my_preferences/" . $user_info->id); ?>" data-target="#tab-my-preferences"> <?php echo lang('my_preferences'); ?></a></li>
        <?php } ?>

        <?php if ($show_general_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("team_members/files/" . $user_info->id); ?>" data-target="#tab-files"> <?php echo lang('files'); ?></a></li>
        <?php } ?>

        <?php if ($show_projects) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/projects_info/" . $user_info->id); ?>" data-target="#tab-projects-info"><?php echo lang('projects'); ?></a></li>
        <?php } ?> 

        <?php if ($show_attendance) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/attendance_info/" . $user_info->id); ?>" data-target="#tab-attendance-info"> <?php echo lang('attendance'); ?></a></li>
        <?php } ?>

        <?php if ($show_leave) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/leave_info/" . $user_info->id); ?>" data-target="#tab-leave-info"><?php echo lang('leaves'); ?></a></li>
        <?php } ?>
        <?php if ($show_expense_info) { ?>
            <li><a role="presentation" href="<?php echo_uri("team_members/expense_info/" . $user_info->id); ?>" data-target="#tab-expense-info"><?php echo lang('expenses'); ?></a></li>
        <?php } ?> 

    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active pl15 pr15 mb15" id="tab-timeline">
            <?php timeline_widget(array("limit" => 20, "offset" => 0, "is_first_load" => true, "user_id" => $user_info->id)); ?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab-general-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-files"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-social-links"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-job-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-account-settings"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-my-preferences"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-projects-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-attendance-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-leave-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-expense-info"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".upload").change(function () {
            if (typeof FileReader == 'function') {
                showCropBox(this);
            } else {
                $("#profile-image-form").submit();
            }
        });
        $("#profile_image").change(function () {
            $("#profile-image-form").submit();
        });


        $("#profile-image-form").appForm({
            isModal: false,
            beforeAjaxSubmit: function (data) {
                $.each(data, function (index, obj) {
                    if (obj.name === "profile_image") {
                        var profile_image = replaceAll(":", "~", data[index]["value"]);
                        data[index]["value"] = profile_image;
                    }
                });
            },
            onSuccess: function (result) {
                if (typeof FileReader == 'function') {
                    appAlert.success(result.message, {duration: 10000});
                } else {
                    location.reload();
                }
            }
        });

        var tab = "<?php echo $tab; ?>";
        if (tab === "general") {
            $("[data-target=#tab-general-info]").trigger("click");
        } else if (tab === "account") {
            $("[data-target=#tab-account-settings]").trigger("click");
        } else if (tab === "social") {
            $("[data-target=#tab-social-links]").trigger("click");
        } else if (tab === "job_info") {
            $("[data-target=#tab-job-info]").trigger("click");
        } else if (tab === "my_preferences") {
            $("[data-target=#tab-my-preferences]").trigger("click");
        }


    });
</script>