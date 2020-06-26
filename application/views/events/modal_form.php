<?php echo form_open(get_uri("events/save"), array("id" => "event-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "value" => $model_info->title,
                "class" => "form-control",
                "placeholder" => lang('title'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class=" col-md-3"><?php echo lang('description'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => $model_info->description,
                "class" => "form-control",
                "placeholder" => lang('description'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>

    <div class="clearfix">
        <label for="start_date" class=" col-md-3 col-sm-3"><?php echo lang('start_date'); ?></label>
        <div class="col-md-4 col-sm-4 form-group">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => $model_info->start_date,
                "class" => "form-control",
                "placeholder" => lang('start_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
        <label for="start_time" class=" col-md-2 col-sm-2"><?php echo lang('start_time'); ?></label>
        <div class=" col-md-3 col-sm-3">
            <?php
            $start_time = is_date_exists($model_info->start_time) ? $model_info->start_time : "";

            if ($time_format_24_hours) {
                $start_time = $start_time ? date("H:i", strtotime($start_time)) : "";
            } else {
                $start_time = $start_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($start_time))) : "";
            }

            echo form_input(array(
                "id" => "start_time",
                "name" => "start_time",
                "value" => $start_time,
                "class" => "form-control",
                "placeholder" => lang('start_time')
            ));
            ?>
        </div>
    </div>


    <div class="clearfix">
        <label for="end_date" class=" col-md-3 col-sm-3"><?php echo lang('end_date'); ?></label>
        <div class=" col-md-4 col-sm-4 form-group">
            <?php
            echo form_input(array(
                "id" => "end_date",
                "name" => "end_date",
                "value" => $model_info->end_date,
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
        <div class=" col-md-3 col-sm-3">
            <?php
            $end_time = is_date_exists($model_info->end_time) ? $model_info->end_time : "";

            if ($time_format_24_hours) {
                $end_time = $end_time ? date("H:i", strtotime($end_time)) : "";
            } else {
                $end_time = $end_time ? convert_time_to_12hours_format(date("H:i:s", strtotime($end_time))) : "";
            }

            echo form_input(array(
                "id" => "end_time",
                "name" => "end_time",
                "value" => $end_time,
                "class" => "form-control",
                "placeholder" => lang('end_time')
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="location" class=" col-md-3"><?php echo lang('location'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "location",
                "name" => "location",
                "value" => $model_info->location,
                "class" => "form-control",
                "placeholder" => lang('location'),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="event_labels" class=" col-md-3"><?php echo lang('labels'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "event_labels",
                "name" => "labels",
                "value" => $model_info->labels,
                "class" => "form-control",
                "placeholder" => lang('labels')
            ));
            ?>
        </div>
    </div>

    <?php if ($client_id) { ?>
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
    <?php } else if (count($clients_dropdown)) { ?>
        <div class="form-group">
            <label for="client_id" class=" col-md-3"><?php echo lang('client'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "clients_dropdown",
                    "name" => "client_id",
                    "value" => $model_info->client_id,
                    "class" => "form-control"
                ));
                ?>
            </div>
        </div>
    <?php } ?>

    <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 


    <?php if ($can_share_events) { ?>
        <?php if ($this->login_user->user_type == "client") { ?>
            <input type="hidden" name="share_with" value="">
        <?php } else { ?>
            <div class="form-group">
                <label for="share_with" class=" col-md-3"><?php echo lang('share_with'); ?></label>
                <div class=" col-md-9">
                    <div>
                        <?php
                        echo form_radio(array(
                            "id" => "only_me",
                            "name" => "share_with",
                            "value" => "",
                            "class" => "toggle_specific",
                                ), $model_info->share_with, ($model_info->share_with === "") ? true : false);
                        ?>
                        <label for="only_me"><?php echo lang("only_me"); ?></label>

                    </div>
                    <div>
                        <?php
                        echo form_radio(array(
                            "id" => "share_with_all",
                            "name" => "share_with",
                            "value" => "all",
                            "class" => "toggle_specific",
                                ), $model_info->share_with, ($model_info->share_with === "all") ? true : false);
                        ?>
                        <label for="share_with_all"><?php echo lang("all_team_members"); ?></label>
                    </div>

                    <div class="form-group mb0">
                        <?php
                        echo form_radio(array(
                            "id" => "share_with_specific_radio_button",
                            "name" => "share_with",
                            "value" => "specific",
                            "class" => "toggle_specific",
                                ), $model_info->share_with, ($model_info->share_with && $model_info->share_with != "all" && $model_info->share_with_specific != "contact") ? true : false);
                        ?>
                        <label for="share_with_specific_radio_button"><?php echo lang("specific_members_and_teams"); ?>:</label>
                        <div class="specific_dropdown" style="display: none;">
                            <input type="text" value="<?php echo ($model_info->share_with && $model_info->share_with != "all" && $model_info->share_with_specific != "contact") ? $model_info->share_with : ""; ?>" name="share_with_specific" id="share_with_specific" class="w100p validate-hidden"  data-rule-required="true" data-msg-required="<?php echo lang('field_required'); ?>" placeholder="<?php echo lang('choose_members_and_or_teams'); ?>"  />
                        </div>
                    </div>

                    <div id="share-with-client-contact" class="form-group mb0 hide">
                        <?php
                        echo form_radio(array(
                            "id" => "share_with_client_contact_radio_button",
                            "name" => "share_with",
                            "value" => "specific_client_contacts",
                            "class" => "toggle_specific",
                                ), $model_info->share_with, ($model_info->share_with && $model_info->share_with != "all" && $model_info->share_with_specific != "member" && $model_info->share_with_specific != "team") ? true : false);
                        ?>
                        <label for="share_with_client_contact_radio_button"><?php echo lang("specific_client_contacts"); ?>:</label>
                        <div class="specific_dropdown" style="display: none;">
                            <input type="text" value="<?php echo ($model_info->share_with && $model_info->share_with != "all" && $model_info->share_with_specific != "member") ? $model_info->share_with : ""; ?>" name="share_with_specific_client_contact" id="share_with_specific_client_contact" class="w100p validate-hidden"  data-rule-required="true" data-msg-required="<?php echo lang('field_required'); ?>" placeholder="<?php echo lang('choose_client_contacts'); ?>"  />
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="form-group">
        <label for="event_recurring" class=" col-md-3"><?php echo lang('repeat'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_checkbox("recurring", "1", $model_info->recurring ? true : false, "id='event_recurring'");
            ?>                       
        </div>
    </div>        

    <div id="recurring_fields" class="<?php if (!$model_info->recurring) echo "hide"; ?>"> 
        <div class="form-group">
            <label for="repeat_every" class=" col-md-3"><?php echo lang('repeat_every'); ?></label>
            <div class="col-md-4">
                <?php
                echo form_input(array(
                    "id" => "repeat_every",
                    "name" => "repeat_every",
                    "type" => "number",
                    "value" => $model_info->repeat_every ? $model_info->repeat_every : 1,
                    "min" => 1,
                    "class" => "form-control recurring_element",
                    "placeholder" => lang('repeat_every'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required")
                ));
                ?>
            </div>
            <div class="col-md-5">
                <?php
                echo form_dropdown(
                        "repeat_type", array(
                    "days" => lang("interval_days"),
                    "weeks" => lang("interval_weeks"),
                    "months" => lang("interval_months"),
                    "years" => lang("interval_years"),
                        ), $model_info->repeat_type ? $model_info->repeat_type : "months", "class='select2 recurring_element' id='repeat_type'"
                );
                ?>
            </div>
        </div>    

        <div class="form-group">
            <label for="no_of_cycles" class=" col-md-3"><?php echo lang('cycles'); ?></label>
            <div class="col-md-4">
                <?php
                echo form_input(array(
                    "id" => "no_of_cycles",
                    "name" => "no_of_cycles",
                    "type" => "number",
                    "min" => 1,
                    "value" => $model_info->no_of_cycles ? $model_info->no_of_cycles : "",
                    "class" => "form-control",
                    "placeholder" => lang('cycles')
                ));
                ?>
            </div>
            <div class="col-md-5 mt5">
                <span class="help" data-toggle="tooltip" title="<?php echo lang('recurring_cycle_instructions'); ?>"><i class="fa fa-question-circle"></i></span>
            </div>
        </div>  

    </div>     

    <div class="form-group">
        <label class=" col-md-3"></label>
        <div class="col-md-9">
            <?php $this->load->view("includes/color_plate"); ?>
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
        $("#event-form").appForm({
            onSuccess: function (result) {
                $("#event-calendar").fullCalendar('refetchEvents');
            }
        });
        setDatePicker("#start_date, #end_date");

        setTimePicker("#start_time, #end_time");


        $("#title").focus();

        get_specific_dropdown($("#share_with_specific"), <?php echo ($members_and_teams_dropdown); ?>);


        var clientId = "<?php echo $model_info->client_id; ?>";

        if (clientId && clientId != "0") {
            prepareShareWithClientContactsDropdown(clientId);
        }

        //show the specific client contacts readio button after select any client
        $('#clients_dropdown').select2({data: <?php echo json_encode($clients_dropdown); ?>}).on("change", function () {
            prepareShareWithClientContactsDropdown($(this).val());
        });

        function prepareShareWithClientContactsDropdown(clientId) {
            if (clientId) {
                $("#share-with-client-contact").removeClass("hide");
                $.ajax({
                    url: "<?php echo get_uri("events/get_all_contacts_of_client") ?>" + "/" + clientId,
                    dataType: "json",
                    success: function (result) {

                        if (result.length) {
                            get_specific_dropdown($("#share_with_specific_client_contact"), result);
                        } else {
                            //if no client contact exists, then don't show the share with client contacts option
                            $("#share-with-client-contact").addClass("hide");
                            prepareShareWithClientContactsDropdown();
                        }

                    }
                });
            } else {
                $("#share-with-client-contact").addClass("hide");
                var $element = $(".toggle_specific:checked");
                if ($element.val() === "specific_client_contacts") {
                    //unselect the specific_client_contacts
                    $("#only_me").trigger("click");
                    toggle_specific_dropdown();
                }
            }
        }

        function get_specific_dropdown(container, data) {
            setTimeout(function () {
                container.select2({
                    multiple: true,
                    formatResult: teamAndMemberSelect2Format,
                    formatSelection: teamAndMemberSelect2Format,
                    data: data
                });
            }, 100);
        }

        $(".toggle_specific").click(function () {
            toggle_specific_dropdown();
        });

        toggle_specific_dropdown();

        function toggle_specific_dropdown() {
            $(".specific_dropdown").hide().find("input").removeClass("validate-hidden");

            var $element = $(".toggle_specific:checked");
            if ($element.val() === "specific" || $element.val() === "specific_client_contacts") {
                var $dropdown = $element.closest("div").find("div.specific_dropdown");
                $dropdown.show().find("input").addClass("validate-hidden");
            }
        }

        $("#event_labels").select2({
            tags: <?php echo json_encode($label_suggestions); ?>
        });

        $("#event-form .select2").select2();

        //show/hide recurring fields
        $("#event_recurring").click(function () {
            if ($(this).is(":checked")) {
                $("#recurring_fields").removeClass("hide");
            } else {
                $("#recurring_fields").addClass("hide");
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>