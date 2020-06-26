<div class="tab-content">
    <?php
    $user_id = $this->login_user->id;
    echo form_open(get_uri("team_members/save_my_preferences/"), array("id" => "my-preferences-form", "class" => "general-form dashed-row white", "role" => "form"));
    ?>
    <div class="panel">
        <div class="panel-default panel-heading">
            <h4> <?php echo lang('my_preferences'); ?></h4>
        </div>
        <div class="panel-body">
            <!--            <div class="form-group">
                            <label for="show_push_notification" class=" col-md-2"><?php echo lang('show_push_notification'); ?></label>
                            <div class=" col-md-10">
            <?php
            /*
              $push_notification = get_setting('user_' . $user_id . '_show_push_notification');

              if(!$push_notification){
              $push_notification='no';
              }

              echo form_dropdown(
              "show_push_notification", array(
              "yes" => lang("yes"),
              "no" => lang("no")
              ), $push_notification, "class='select2 mini'"
              ); */
            ?>
                            </div>
                        </div>-->
            <div class="form-group">
                <label for="notification_sound_volume" class=" col-md-2"><?php echo lang('notification_sound_volume'); ?></label>
                <div class=" col-md-10">
                    <?php
                    echo form_dropdown(
                            "notification_sound_volume", array(
                        "0" => "-",
                        "1" => "|",
                        "2" => "||",
                        "3" => "|||",
                        "4" => "||||",
                        "5" => "|||||",
                        "6" => "||||||",
                        "7" => "|||||||",
                        "8" => "||||||||",
                        "9" => "|||||||||",
                            ), get_setting('user_' . $user_id . '_notification_sound_volume'), "class='select2 mini'"
                    );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="enable_web_notification" class=" col-md-2"><?php echo lang('enable_web_notification'); ?></label>
                <div class=" col-md-10">
                    <?php
                    echo form_dropdown(
                            "enable_web_notification", array(
                        "1" => lang("yes"),
                        "0" => lang("no")
                            ), $user_info->enable_web_notification, "class='select2 mini'"
                    );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="enable_email_notification" class=" col-md-2"><?php echo lang('enable_email_notification'); ?></label>
                <div class=" col-md-10">
                    <?php
                    echo form_dropdown(
                            "enable_email_notification", array(
                        "1" => lang("yes"),
                        "0" => lang("no")
                            ), $user_info->enable_email_notification, "class='select2 mini'"
                    );
                    ?>
                </div>
            </div>

            <?php if (count($language_dropdown) && !get_setting("disable_language_selector_for_team_members")) { ?>
                <div class="form-group">
                    <label for="personal_language" class=" col-md-2"><?php echo lang('language'); ?></label>
                    <div class="col-md-10">
                        <?php
                        echo form_dropdown(
                                "personal_language", $language_dropdown, get_setting('user_' . $user_info->id . '_personal_language') ? get_setting('user_' . $user_info->id . '_personal_language') : get_setting("language"), "class='select2 mini'"
                        );
                        ?>
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#my-preferences-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });
        $("#my-preferences-form .select2").select2();

    });
</script>    