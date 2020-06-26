<?php echo form_open(get_uri("projects/save_timelog"), array("id" => "timelog-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
    <div class="clearfix">
        <?php if (isset($team_members_info)) { ?>
            <div class="form-group">
                <label for="applicant_id" class=" col-md-3"><?php echo lang('team_member'); ?></label>
                <div class=" col-md-9">
                    <?php
                    $image_url = get_avatar($team_members_info->image);
                    echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $team_members_info->first_name . " " . $team_members_info->last_name;
                    ?>
                </div>
            </div>
        <?php }; ?>

        <?php if ($show_porject_members_dropdown) { ?>
            <div class="form-group">
                <label for="user_id" class=" col-md-3"><?php echo lang('member'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_dropdown("user_id", $project_members_dropdown, array($model_info->user_id), "class='select2'");
                    ?>
                </div>
            </div>
            <?php
        }
        ?>


        <label for="start_date" class=" col-md-3 col-sm-3"><?php echo lang('start_date'); ?></label>
        <div class="col-md-4 col-sm-4 form-group">
            <?php
            $in_time = is_date_exists($model_info->start_time) ? convert_date_utc_to_local($model_info->start_time) : "";

            if ($time_format_24_hours) {
                $in_time_value = $in_time ? date("H:i", strtotime($in_time)) : "";
            } else {
                $in_time_value = $in_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($in_time))) : "";
            }

            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => $in_time ? date("Y-m-d", strtotime($in_time)) : "",
                "class" => "form-control",
                "placeholder" => lang('start_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
        <label for="in_time" class=" col-md-2 col-sm-2"><?php echo lang('start_time'); ?></label>
        <div class=" col-md-3 col-sm-3  form-group">
            <?php
            echo form_input(array(
                "id" => "start_time",
                "name" => "start_time",
                "value" => $in_time_value,
                "class" => "form-control",
                "placeholder" => lang('start_time'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>

    <div class="clearfix">
        <label for="end_date" class=" col-md-3 col-sm-3"><?php echo lang('end_date'); ?></label>
        <div class=" col-md-4 col-sm-4 form-group">
            <?php
            $out_time = is_date_exists($model_info->end_time) ? convert_date_utc_to_local($model_info->end_time) : "";

            if ($time_format_24_hours) {
                $out_time_value = $in_time ? date("H:i", strtotime($out_time)) : "";
            } else {
                $out_time_value = $in_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($out_time))) : "";
            }
            echo form_input(array(
                "id" => "end_date",
                "name" => "end_date",
                "value" => $out_time ? date("Y-m-d", strtotime($out_time)) : "",
                "class" => "form-control",
                "placeholder" => lang('end_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#start_date",
                "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
        <label for="end_time" class=" col-md-2 col-sm-2"><?php echo lang('end_time'); ?></label>
        <div class=" col-md-3 col-sm-3 form-group">
            <?php
            echo form_input(array(
                "id" => "end_time",
                "name" => "end_time",
                "value" => $out_time_value,
                "class" => "form-control",
                "placeholder" => lang('end_time'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>

        <div class="form-group">
            <label for="note" class=" col-md-3"><?php echo lang('note'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "note",
                    "name" => "note",
                    "class" => "form-control",
                    "placeholder" => lang('note'),
                    "value" => $model_info->note
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="task" class="col-md-3"><?php echo lang('task'); ?>        </label>
            <div class="col-md-9">
                <?php
                echo form_dropdown("task_id", $tasks_dropdown, $model_info->task_id, "class='select2'");
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#timelog-form").appForm({
            onSuccess: function (result) {
                $("#project-timesheet-table").appTable({newData: result.data, dataId: result.id});
            }
        });

        setDatePicker("#start_date, #end_date");

        setTimePicker("#start_time, #end_time");
        $("#timelog-form .select2").select2();
        $("#name").focus();
    });
</script>