<?php echo form_open(get_uri("leaves/" . $form_type), array("id" => "leave-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <?php if ($form_type == "assign_leave") { ?>
        <div class="form-group">
            <label for="applicant_id" class=" col-md-3"><?php echo lang('team_member'); ?></label>
            <div class=" col-md-9">
                <?php
                if (isset($team_members_info)) {
                    $image_url = get_avatar($team_members_info->image);
                    echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $team_members_info->first_name . " " . $team_members_info->last_name;
                    ?>
                    <input type="hidden" name="applicant_id" value="<?php echo $team_members_info->id; ?>" />
                    <?php
                } else {
                    echo form_dropdown("applicant_id", $team_members_dropdown, "", "class='select2 validate-hidden' id='applicant_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                }
                ?>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="leave_type" class=" col-md-3"><?php echo lang('leave_type'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_dropdown("leave_type_id", $leave_types_dropdown, "", "class='select2 validate-hidden' id='leave_type_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
            ?>
        </div>
    </div>
    <div class=" form-group">
        <label for="duration" class=" col-md-3"><?php echo lang('duration'); ?></label>
        <div class="col-md-9">

            <?php
            echo form_radio(array(
                "id" => "duration_single_day",
                "class" => "duration",
                "name" => "duration",
                    ), "single_day", true);
            ?>
            <label for="duration_single_day" class="mr15" ><?php echo lang('single_day'); ?></label>

            <?php
            echo form_radio(array(
                "id" => "duration_mulitple_days",
                "class" => "duration",
                "name" => "duration",
                    ), "multiple_days", false);
            ?>
            <label for="duration_mulitple_days" class="mr15" ><?php echo lang('mulitple_days'); ?></label>

            <?php
            echo form_radio(array(
                "id" => "duration_hours",
                "class" => "duration",
                "name" => "duration",
                    ), "hours", false);
            ?>
            <label for="duration_hours" ><?php echo lang('hours'); ?></label>
        </div>
    </div>

    <div id="single_day_section"  class="form-group date_section">
        <label id="date_label" for="single_date" class=" col-md-3"><?php echo lang('date'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "single_date",
                "name" => "single_date",
                "class" => "form-control",
                "placeholder" => lang('date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div id="multiple_days_section" class="hide date_section">
        <div class="form-group">
            <label for="start_date" class=" col-md-3"><?php echo lang('start_date'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "start_date",
                    "name" => "start_date",
                    "class" => "form-control",
                    "placeholder" => lang('start_date'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required")
                ));
                ?>
            </div>
        </div>

        <div class="form-group">
            <label for="end_date" class=" col-md-3"><?php echo lang('end_date'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "end_date",
                    "name" => "end_date",
                    "class" => "form-control",
                    "placeholder" => lang('end_date'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                    "data-rule-greaterThanOrEqual" => "#start_date",
                    "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date"),
                    "data-rule-mustBeSameYear" => "#start_date"
                ));
                ?>
            </div>
        </div>
    </div>

    <div id="hours_section" class="hide date_section">
        <div class="clearfix">
            <label for="hour_date" class=" col-md-3"><?php echo lang('date'); ?></label>
            <div class="col-md-4 form-group">
                <?php
                echo form_input(array(
                    "id" => "hour_date",
                    "name" => "hour_date",
                    "class" => "form-control",
                    "placeholder" => lang('date'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>

            <label for="hours" class=" col-md-2"><?php echo lang('hours'); ?></label>
            <div class=" col-md-3">
                <?php
                echo form_dropdown("hours", array(
                    "01" => "01",
                    "02" => "02",
                    "03" => "03",
                    "04" => "04",
                    "05" => "05",
                    "06" => "06",
                    "07" => "07",
                    "08" => "08",
                        ), "", "class='select2 validate-hidden' id='hours' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="reason" class=" col-md-3"><?php echo lang('reason'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "reason",
                "name" => "reason",
                "class" => "form-control",
                "placeholder" => lang('reason'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang($form_type); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#leave-form").appForm({
            onSuccess: function(result) {
                location.reload();
            }
        });

        setDatePicker("#start_date, #end_date");
        
        setDatePicker("#single_date, #hour_date");


        $("#leave-form .select2").select2();

        $(".duration").click(function() {
            var value = $(this).val();
            $(".date_section").addClass("hide");
            if (value === "multiple_days") {
                $("#multiple_days_section").removeClass("hide");
            } else if (value === "hours") {
                $("#hours_section").removeClass("hide");
            } else {
                $("#single_day_section").removeClass("hide");
            }
        });
    });
</script>