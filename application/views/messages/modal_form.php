<div id="new-message-dropzone" class="post-dropzone">
    <?php echo form_open(get_uri("messages/send_message"), array("id" => "message-form", "class" => "general-form", "role" => "form")); ?>
    <div class="modal-body clearfix">
        <div class="form-group">
            <label for="to_user_id" class=" col-md-2"><?php echo lang('to'); ?></label>
            <div class="col-md-10">
                <?php
                if (isset($message_user_info)) {
                    $image_url = get_avatar($message_user_info->image);
                    echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span>" . $message_user_info->first_name . " " . $message_user_info->last_name;
                    ?>
                    <input type="hidden" name="to_user_id" value="<?php echo $message_user_info->id; ?>" />
                    <?php
                } else {
                    echo form_dropdown("to_user_id", $users_dropdown, array(), "class='select2 validate-hidden' id='to_user_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="subject" class=" col-md-2"><?php echo lang('subject'); ?></label>
            <div class=" col-md-10">
                <?php
                echo form_input(array(
                    "id" => "subject",
                    "name" => "subject",
                    "class" => "form-control",
                    "placeholder" => lang('subject'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?php
                echo form_textarea(array(
                    "id" => "message",
                    "name" => "message",
                    "class" => "form-control",
                    "placeholder" => lang('write_a_message'),
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                    "style" => "min-height:200px;"
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?php $this->load->view("includes/dropzone_preview"); ?> 
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span class="fa fa-send"></span> <?php echo lang('send'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var uploadUrl = "<?php echo get_uri("messages/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("messages/validate_message_file"); ?>";

        var dropzone = attachDropzoneWithForm("#new-message-dropzone", uploadUrl, validationUrl);

        $("#message-form").appForm({
            onSuccess: function (result) {

                appAlert.success(result.message, {duration: 10000});

                //we'll check if the single user chat list is open. 
                //if so, we'll assume that, this message created from the view.
                //and we'll open the chat automatically.
                if ($("#js-single-user-chat-list").is(":visible") && typeof window.triggerActiveChat !== "undefined") {
                    setTimeout(function () {
                        window.triggerActiveChat(result.id);
                    }, 1000);
                }

            }
        });

        $("#message-form .select2").select2();
    });
</script>    