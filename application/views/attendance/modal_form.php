<?php echo form_open(get_uri("attendance/save"), array("id" => "attendance-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="clearfix">
        <div class="form-group">
            <label for="applicant_id" class=" col-md-3"><?php echo lang('team_member'); ?></label>
            <div class=" col-md-9">
                <?php
                if (isset($team_members_info)) {
                    $image_url = get_avatar($team_members_info->image);
                    echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $team_members_info->first_name . " " . $team_members_info->last_name;
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo $team_members_info->id; ?>" />
                    <?php
                } else {
                    echo form_dropdown("user_id", $team_members_dropdown, "", "class='select2 validate-hidden' id='attendance_user_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                }
                ?>
            </div>
        </div>

        <label for="in_date" class=" col-md-3 col-sm-3"><?php echo lang('in_date'); ?></label>
        <div class="col-md-4 col-sm-4 form-group">
            <?php
            $in_time = (is_date_exists($model_info->in_time)) ? convert_date_utc_to_local($model_info->in_time) : "";

            if ($time_format_24_hours) {
                $in_time_value = $in_time ? date("H:i", strtotime($in_time)) : "";
            } else {
                $in_time_value = $in_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($in_time))) : "";
            }

            echo form_input(array(
                "id" => "in_date",
                "name" => "in_date",
                "value" => $in_time ? date("Y-m-d", strtotime($in_time)) : "",
                "class" => "form-control",
                "placeholder" => lang('in_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
        <label for="in_time" class=" col-md-2 col-sm-2"><?php echo lang('in_time'); ?></label>
        <div class=" col-md-3 col-sm-3  form-group">
            <?php
            echo form_input(array(
                "id" => "in_time",
                "name" => "in_time",
                "value" => $in_time_value,
                "class" => "form-control",
                "placeholder" => lang('in_time'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>

    <div class="clearfix">
        <label for="out_date" class=" col-md-3 col-sm-3"><?php echo lang('out_date'); ?></label>
        <div class=" col-md-4 col-sm-4 form-group">
            <?php
            $out_time = is_date_exists($model_info->out_time) ? convert_date_utc_to_local($model_info->out_time) : "";

            if ($time_format_24_hours) {
                $out_time_value = $in_time ? date("H:i", strtotime($out_time)) : "";
            } else {
                $out_time_value = $in_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($out_time))) : "";
            }

            echo form_input(array(
                "id" => "out_date",
                "name" => "out_date",
                "value" => $out_time ? date("Y-m-d", strtotime($out_time)) : "",
                "class" => "form-control",
                "placeholder" => lang('out_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#in_date",
                "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
        <label for="out_time" class=" col-md-2 col-sm-2"><?php echo lang('out_time'); ?></label>
        <div class=" col-md-3 col-sm-3 form-group">
            <?php
            echo form_input(array(
                "id" => "out_time",
                "name" => "out_time",
                "value" => $out_time_value,
                "class" => "form-control",
                "placeholder" => lang('out_time'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
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
                "value" => $model_info->note,
            ));
            ?>
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
        $("#attendance-form").appForm({
            onSuccess: function (result) {
                $(".dataTable:visible").appTable({newData: result.data, dataId: result.id});
            }
        });
        if ($("#attendance_user_id").length) {
            $("#attendance_user_id").select2();
        }
        setDatePicker("#in_date, #out_date");

        setTimePicker("#in_time, #out_time");

        $("#name").focus();
    });
</script>