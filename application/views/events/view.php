<div class="modal-body">
    <div class="table-responsive mb15">
        <div class="col-md-12">
            <h4 class="mt0">
                <?php
                $share_title = lang("share_with") . ": ";
                if (!$model_info->share_with) {
                    $share_title .= lang("only_me");
                } else if ($model_info->share_with == "all") {
                    $share_title .= lang("all_team_members");
                } else {
                    $share_title .= lang("specific_members_and_teams");
                }

                echo "<span title='$share_title' style='color:" . $model_info->color . "' class='pull-left mr10'><i class='fa $event_icon'></i></span> " . $model_info->title;
                ?>
            </h4>

        </div>

        <?php if ($status) { ?>
            <div class="col-md-12 pb10">
                <?php echo $status; ?>
            </div>
        <?php } ?>

        <div class="col-md-12 pb10 ">
            <i class="fa fa-clock-o"></i>
            <?php
            $this->load->view("events/event_time");
            ?>
        </div>

        <div class="col-md-12 pb10">
            <?php echo $labels; ?>
        </div>

        <div class="col-md-12">
            <blockquote class="font-14 text-justify" style="<?php echo "border-color:" . $model_info->color; ?>"><?php echo nl2br($model_info->description); ?></blockquote>
        </div>

        <?php if ($model_info->company_name && $this->login_user->user_type != "client") { ?>
            <div class="col-md-12 pb10 pt10 ">
                <i class="fa fa-briefcase"></i>
                <?php
                echo anchor("clients/view/" . $model_info->client_id, $model_info->company_name);
                ?>
            </div>
        <?php } ?>

        <?php if ($model_info->location) { ?>
            <div class="col-md-12 mt5">
                <div class="font-14"><i class="fa fa-map-marker"></i> <?php echo nl2br($model_info->location); ?></div>
            </div>
        <?php }
        ?>

        <div class="col-md-12 pt10 pb10">
            <?php
            $image_url = get_avatar($model_info->created_by_avatar);
            echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span><span>" . get_team_member_profile_link($model_info->created_by, $model_info->created_by_name, array("class" => "dark strong")) . "</span>";
            ?>
        </div>

       
        <?php if ($confirmed_by) { ?>
            <div class="col-md-12 clearfix">
                <div class="col-md-1 p0">
                    <span title="<?php echo lang("confirmed"); ?>" class='confirmed-by-logo'><i class='fa fa-check-circle'></i></span>
                </div>
                <div class="col-md-11 pt10 pl0">
                    <?php echo $confirmed_by; ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($rejected_by) { ?>
            <div class="col-md-12 clearfix">
                <div class="col-md-1 p0">
                    <span title="<?php echo lang("rejected"); ?>" class="rejected-by-logo"><i class="fa fa-times-circle"></i></span>
                </div>
                <div class="col-md-11 pt10 pl0">
                    <?php echo $rejected_by; ?>
                </div>
            </div>
        <?php } ?>
       

        <?php
        if (count($custom_fields_list)) {
            foreach ($custom_fields_list as $data) {
                if ($data->value) {
                    ?>
                    <div class="col-md-12 pt10">
                        <strong><?php echo $data->title . ": "; ?> </strong> <?php echo $this->load->view("custom_fields/output_" . $data->field_type, array("value" => $data->value), true); ?>
                    </div>
                    <?php
                }
            }
        }
        ?>


    </div>
</div>

<div class="modal-footer">
    <?php
    if (isset($editable) && $editable === "1") {

        if ($this->login_user->id == $model_info->created_by || $this->login_user->is_admin) {
            //recurring child event's can't be deleted
            $show_delete = true;

            if (isset($model_info->cycle) && $model_info->cycle) {
                $show_delete = false;
            }

            if ($show_delete) {
                echo js_anchor("<i class='fa fa-times-circle-o'></i> " . lang('delete_event'), array("class" => "btn btn-default pull-left", "id" => "delete_event", "data-encrypted_event_id" => $encrypted_event_id));
            }

            echo modal_anchor(get_uri("events/modal_form/"), "<i class='fa fa-pencil'></i> " . lang('edit_event'), array("class" => "btn btn-default", "data-post-encrypted_event_id" => $encrypted_event_id, "title" => lang('edit_event')));
        }
    }

    //show a button to confirm or reject the event
    if ($this->login_user->id != $model_info->created_by) {
        echo $status_button;
    }
    ?>
    <button type="button" class="btn btn-info close-modal" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $('#delete_event').confirmation({
            title: "<?php echo lang('are_you_sure'); ?>",
            btnOkLabel: "<?php echo lang('yes'); ?>",
            btnCancelLabel: "<?php echo lang('no'); ?>",
            onConfirm: function () {
                $('.close-modal').trigger("click");
                $.ajax({
                    url: "<?php echo get_uri('events/delete') ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {encrypted_event_id: this.encrypted_event_id},
                    success: function (result) {
                        if (result.success) {
                            $("#event-calendar").fullCalendar('refetchEvents');
                            appAlert.warning(result.message, {duration: 10000});
                        } else {
                            appAlert.error(result.message);
                        }
                    }
                });

            }
        });

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>    