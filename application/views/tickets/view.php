<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo get_ticket_id($ticket_info->id) . " - " . $ticket_info->title ?></h1>
            <div class="title-button-group p10">

                <span class="dropdown inline-block">
                    <button class="btn btn-default dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php if ($this->login_user->user_type == "staff") { ?>
                            <li role="presentation">
                                <?php echo modal_anchor(get_uri("tickets/modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit'), array("title" => lang('ticket'), "data-post-view" => "details", "data-post-id" => $ticket_info->id)); ?>
                            </li>
                        <?php } ?>
                        <?php if ($ticket_info->status === "closed") { ?>
                            <li role="presentation"><?php echo ajax_anchor(get_uri("tickets/save_ticket_status/view/$ticket_info->id/open"), "<i class='fa fa-check-circle'></i> " . lang('mark_as_open'), array("class" => "", "title" => lang('mark_as_open'), "data-reload-on-success" => "1")); ?> </li>
                        <?php } else { ?>
                            <li role="presentation"><?php echo ajax_anchor(get_uri("tickets/save_ticket_status/view/$ticket_info->id/closed"), "<i class='fa fa-check-circle'></i> " . lang('mark_as_closed'), array("class" => "", "title" => lang('mark_project_as_open'), "data-reload-on-success" => "1")); ?> </li>
                        <?php } ?>
                    </ul>
                </span>
            </div>
        </div>
        <div class="panel-body">
            <div id="ticket-title-section">
                <?php $this->load->view("tickets/ticket_sub_title"); ?>
            </div>

            <?php
            //for assending mode, show the comment box at the top
            if (!$sort_as_decending) {
                foreach ($comments as $comment) {
                    $this->load->view("tickets/comment_row", array("comment" => $comment));
                }
            }
            ?>

            <div id="comment-form-container" >
                <?php echo form_open(get_uri("tickets/save_comment"), array("id" => "comment-form", "class" => "general-form", "role" => "form")); ?>
                <div class="p15 box">
                    <div class="box-content avatar avatar-md pr15">
                        <img src="<?php echo get_avatar($this->login_user->image); ?>" alt="..." />
                    </div>

                    <div id="ticket-comment-dropzone" class="post-dropzone box-content form-group">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_info->id; ?>">
                        <?php
                        echo form_textarea(array(
                            "id" => "description",
                            "name" => "description",
                            "class" => "form-control",
                            "placeholder" => lang('write_a_comment'),
                            "data-rule-required" => true,
                            "data-msg-required" => lang("field_required"),
                        ));
                        ?>
                        <?php $this->load->view("includes/dropzone_preview"); ?>
                        <footer class="panel-footer b-a clearfix ">
                            <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
                            <button class="btn btn-primary pull-right btn-sm " type="submit"><i class='fa fa-paper-plane'></i> <?php echo lang("post_comment"); ?></button>
                        </footer>
                    </div>

                </div>
                <?php echo form_close(); ?>
            </div>

            <?php
            //for decending mode, show the comment box at the bottom
            if ($sort_as_decending) {
                foreach ($comments as $comment) {
                    $this->load->view("tickets/comment_row", array("comment" => $comment));
                }
            }
            ?>


        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var uploadUrl = "<?php echo get_uri("tickets/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("tickets/validate_ticket_file"); ?>";

        var decending = "<?php echo $sort_as_decending; ?>";

        var dropzone = attachDropzoneWithForm("#ticket-comment-dropzone", uploadUrl, validationUrl);

        $("#comment-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                $("#description").val("");

                if (decending) {
                    $(result.data).insertAfter("#comment-form-container");
                } else {
                    $(result.data).insertBefore("#comment-form-container");
                }

                appAlert.success(result.message, {duration: 10000});

                dropzone.removeAllFiles();
            }
        });

    });
</script>
