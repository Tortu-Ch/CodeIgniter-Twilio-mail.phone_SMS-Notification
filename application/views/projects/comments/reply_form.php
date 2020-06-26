<?php echo form_open(get_uri("projects/save_comment"), array("class" => "reply-form general-form", "role" => "form")); ?>
<?php
$parent_id = 0;
if (isset($comment_id)) {
    $parent_id = $comment_id;
}
?>
<div class="mb15 pr15 box">
    <div class="box-content avatar avatar-sm pr15">
        <img src="<?php echo get_avatar($this->login_user->image); ?>" alt="..." />
    </div>

    <div id="<?php echo "reply-dropzone-" . $parent_id; ?>"  class="post-dropzone box-content form-group">
        <input type="hidden" name="comment_id" value="<?php echo $parent_id; ?>">

        <?php
        echo form_textarea(array(
            "name" => "description",
            "class" => "form-control comment_reply_description",
            "placeholder" => lang('write_a_reply'),
            "data-rule-required" => true,
            "data-msg-required" => lang("field_required"),
        ));
        ?>
        <?php $this->load->view("includes/dropzone_preview"); ?>
        <footer class="panel-footer b-a clearfix">
            <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
            <button class="btn btn-primary pull-right btn-sm" type="submit"><i class='fa fa-reply'></i> <?php echo lang("post_reply"); ?></button>
        </footer>
    </div>
</div>
<?php echo form_close(); ?>


<script type="text/javascript">
    $(document).ready(function () {

        $('.comment_reply_description').appMention({
            source: "<?php echo_uri("projects/get_member_suggestion_to_mention"); ?>",
            data: {project_id: <?php echo $project_id; ?>}
        });

        var replyDropzone = [];


        var uploadUrl = "<?php echo get_uri("projects/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("projects/validate_project_file"); ?>";
        replyDropzone["<?php echo $parent_id; ?>"] = attachDropzoneWithForm("#<?php echo "reply-dropzone-" . $parent_id; ?>", uploadUrl, validationUrl);



        $(".reply-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                $(".reply-form").parent().html("");
                var $triggerTarget = $("#reload-reply-list-button-" + "<?php echo $parent_id; ?>");
                $triggerTarget.trigger("click");
                $triggerTarget.siblings(".view-replies").hide();
                if (replyDropzone["<?php echo $parent_id; ?>"]) {
                    replyDropzone["<?php echo $parent_id; ?>"].removeAllFiles();
                }
            }
        });
    });
</script>