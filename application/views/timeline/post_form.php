<div id="post-form-container">
    <?php echo form_open(get_uri("timeline/save"), array("id" => "post-form", "class" => "general-form", "role" => "form")); ?>
    <div class="box">
        <div class="box-content avatar avatar-md pr15">
            <img src="<?php echo get_avatar($this->login_user->image); ?>" alt="..." />
        </div>
        <div id="post-dropzone" class="post-dropzone box-content form-group">
            <input type="hidden" name="post_id" value="<?php echo isset($post_id) ? $post_id : 0; ?>">
            <input type="hidden" name="reload_list" value="1">
            <?php
            echo form_textarea(array(
                "id" => "post_description",
                "name" => "description",
                "class" => "form-control white",
                "placeholder" => lang('post_placeholder_text'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>

            <?php $this->load->view("includes/dropzone_preview"); ?>

            <footer class="panel-footer b-a clearfix">
                <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
                <button class="submit-button btn btn-primary pull-right btn-sm" type="submit"><i class='fa fa-paper-plane'></i> <?php echo lang("post"); ?></button>
            </footer>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var uploadUrl = "<?php echo get_uri("timeline/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("timeline/validate_post_file"); ?>";
        var dropzone = attachDropzoneWithForm("#post-dropzone", uploadUrl, validationUrl);

        $("#post-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                if ($("body").hasClass("dropzone-disabled")) {
                    location.reload();
                } else {
                    $("#post_description").val("");
                    $("#timeline").prepend(result.data);
                    dropzone.removeAllFiles();
                }
            }
        });

    });
</script>