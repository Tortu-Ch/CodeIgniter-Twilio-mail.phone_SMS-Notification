<?php echo form_open(get_uri("settings/save_notification_settings"), array("id" => "notification-settings-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><strong><?php echo lang('event'); ?></strong></label>
        <div class=" col-md-9">
            <strong>
                <?php
                echo lang($model_info->event);
                ?>
            </strong>
        </div>
    </div>
    <div class="form-group">
        <label for="enable_email" class="col-md-3"><?php echo lang('enable_email'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("enable_email", "1", $model_info->enable_email ? true : false, "id='enable_email'");
            ?>                       
        </div>
    </div>
    <div class="form-group">
        <label for="enable_web" class="col-md-3"><?php echo lang('enable_web'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("enable_web", "1", $model_info->enable_web ? true : false, "id='enable_web'");
            ?>                       
        </div>
    </div>

    <div class="form-group">
        <label for="enable_web" class="col-md-3"><?php echo lang('enable_sms'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("enable_sms", "1", $model_info->enable_sms ? true : false, "id='enable_sms'");
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="notify_to" class="col-md-3"><?php echo lang('notify_to'); ?></label>
        <div class="col-md-9">

            <?php
            foreach ($notify_to as $notify_optoin) {
                if ($notify_optoin === "team") {
                    ?>
                    <div class="pb10">
                        <label for="notify_to_team"><?php echo lang('team'); ?></label>
                        <div>
                            <input type="text" value="<?php echo $model_info->notify_to_team; ?>" name="team" id="team_dropdown" class="w100p"  placeholder="<?php echo lang('team'); ?>"  />    
                        </div>
                    </div>
                <?php } else if ($notify_optoin === "team_members") { ?>
                    <div class="pb10">
                        <label for="notify_to_team_members"><?php echo lang('team_members'); ?></label>
                        <div>
                            <input type="text" value="<?php echo $model_info->notify_to_team_members; ?>" name="team_members" id="team_members_dropdown" class="w100p"  placeholder="<?php echo lang('team_members'); ?>"  />    
                        </div>
                    </div>
                <?php } else {
                    ?>
                    <div class="pb10">
                        <?php
                        $selected = false;
                        if (in_array($notify_optoin, $model_info->notify_to_terms)) {
                            $selected = true;
                        }

                        echo form_checkbox($notify_optoin, "1", $selected ? true : false, "id='$notify_optoin'");
                        echo "<label for='$notify_optoin'>" . lang($notify_optoin) . "</label>";
                        ?>
                    </div>

                    <?php
                }
            }
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
        $("#notification-settings-form").appForm({
            onSuccess: function (result) {
                $("#notification-settings-table").appTable({newData: result.data, dataId: result.id});
                console.log(result.data);
            }
        });


        $("#team_members_dropdown").select2({
            multiple: true,
            data: <?php echo ($members_dropdown); ?>
        });

        $("#team_dropdown").select2({
            multiple: true,
            data: <?php echo ($team_dropdown); ?>
        });

    });
</script>    