<div class="tab-content">
    <?php echo form_open(get_uri("team_members/save_job_info/"), array("id" => "job-info-form", "class" => "general-form dashed-row white", "role" => "form")); ?>

    <input name="user_id" type="hidden" value="<?php echo $user_id; ?>" />
    <div class="panel">
        <div class="panel-default panel-heading">
            <h4><?php echo lang('job_info'); ?></h4>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="job_title" class=" col-md-2"><?php echo lang('job_title'); ?></label>
                <div class="col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "job_title",
                        "name" => "job_title",
                        "value" => $job_info->job_title,
                        "class" => "form-control",
                        "placeholder" => lang('job_title')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="salary" class=" col-md-2"><?php echo lang('salary'); ?></label>
                <div class="col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "salary",
                        "name" => "salary",
                        "value" => $job_info->salary ? to_decimal_format($job_info->salary) : "",
                        "class" => "form-control",
                        "placeholder" => lang('salary')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="salary_term" class=" col-md-2"><?php echo lang('salary_term'); ?></label>
                <div class="col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "salary_term",
                        "name" => "salary_term",
                        "value" => $job_info->salary_term,
                        "class" => "form-control",
                        "placeholder" => lang('salary_term')
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="date_of_hire" class=" col-md-2"><?php echo lang('date_of_hire'); ?></label>
                <div class="col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "date_of_hire",
                        "name" => "date_of_hire",
                        "value" => $job_info->date_of_hire,
                        "class" => "form-control",
                        "placeholder" => lang('date_of_hire')
                    ));
                    ?>
                </div>
            </div>
        </div>

        <?php if ($this->login_user->is_admin) { ?>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
            </div>
        <?php } ?>

    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#job-info-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
                window.location.href = "<?php echo get_uri("team_members/view/" . $job_info->user_id); ?>" + "/job_info";
            }
        });
        $("#job-info-form .select2").select2();

        setDatePicker("#date_of_hire");

    });
</script>    