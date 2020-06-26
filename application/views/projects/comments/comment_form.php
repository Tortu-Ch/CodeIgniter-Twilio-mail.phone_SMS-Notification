<?php
$comment_type = "";
if (isset($task_id)) {
    $comment_type = "task";
} else if (isset($file_id)) {
    $comment_type = "file";
} else if (isset($customer_feedback_id)) {
    $comment_type = "customer_feedback";
} else {
    $comment_type = "project";
}
?>

<div id="<?php echo $comment_type . "-comment-form-container"; ?>">
    <?php echo form_open(get_uri("projects/save_comment"), array("id" => $comment_type . "-comment-form", "class" => "general-form", "role" => "form")); ?>
    <div class="p15 box b-b">
        <div class="box-content avatar  <?php echo isset($project_id) || isset($customer_feedback_id) ? " avatar-md" : " avatar-sm"; ?>  pr15">
            <img src="<?php echo get_avatar($this->login_user->image); ?>" alt="..." />
        </div>
        <div id="<?php echo $comment_type . "-dropzone"; ?>" class="post-dropzone box-content form-group">
            <input type="hidden" name="project_id" value="<?php echo isset($project_id) ? $project_id : 0; ?>">
            <input type="hidden" name="file_id" value="<?php echo isset($file_id) ? $file_id : 0; ?>">
            <input type="hidden" name="task_id" value="<?php echo isset($task_id) ? $task_id : 0; ?>">
            <input type="hidden" name="customer_feedback_id" value="<?php echo isset($customer_feedback_id) ? $customer_feedback_id : 0; ?>">
            <input type="hidden" name="reload_list" value="1">
            <?php
            echo form_textarea(array(
                "id" => "comment_description",
                "name" => "description",
                "class" => "form-control comment_description",
                "placeholder" => lang('write_a_comment'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
            <?php $this->load->view("includes/dropzone_preview"); ?>
            <footer class="panel-footer b-a clearfix">
                <?php if ($comment_type != "file") { ?>
                    <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
                <?php } ?>
                <button class="btn btn-primary pull-right btn-sm" type="submit"><i class='fa fa-paper-plane'></i> <?php echo lang("post_comment"); ?></button>
            </footer>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#comment_description').appMention({
            source: "<?php echo_uri("projects/get_member_suggestion_to_mention"); ?>",
            data: {project_id: <?php echo $project_id; ?>}
        });

        var dropzone;
<?php if ($comment_type != "file") { ?>
            var uploadUrl = "<?php echo get_uri("projects/upload_file"); ?>";
            var validationUrl = "<?php echo get_uri("projects/validate_project_file"); ?>";
            dropzone = attachDropzoneWithForm("#<?php echo $comment_type . "-dropzone"; ?>", uploadUrl, validationUrl);
<?php } ?>

        $("#<?php echo $comment_type; ?>-comment-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                $(".comment_description").val("");
                $(result.data).insertAfter("#<?php echo $comment_type; ?>-comment-form-container");
                appAlert.success(result.message, {duration: 10000});

                if (dropzone) {
                    dropzone.removeAllFiles();
                }
            }
        });
    });
</script>