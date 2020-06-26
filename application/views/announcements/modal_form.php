<?php
$this->load->view("includes/summernote");
?>

<div id="page-content" class="clearfix p20">
    <div class="panel view-container">
        <div id="announcement-dropzone" class="post-dropzone">
            <?php echo form_open(get_uri("announcements/save"), array("id" => "announcement-form", "class" => "general-form", "role" => "form")); ?>

            <div class="panel-default">

                <div class="page-title clearfix">
                    <?php if ($model_info->id) { ?>
                        <h1><?php echo lang('edit_announcement'); ?></h1>
                        <div class="title-button-group">
                            <?php echo anchor(get_uri("announcements/view/" . $model_info->id), "<i class='fa fa-external-link-square'></i> " . lang('view'), array("class" => "btn btn-default", "title" => lang('view'))); ?>
                        </div>
                    <?php } else { ?>
                        <h1><?php echo lang('add_announcement'); ?></h1>
                    <?php } ?>
                </div>

                <div class="panel-body">
                    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
                    <div class="form-group">
                        <label for="title" class="col-md-12"><?php echo lang('title'); ?></label>
                        <div class=" col-md-12">
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

                        <div class=" col-md-12">
                            <?php
                            echo form_textarea(array(
                                "id" => "description",
                                "name" => "description",
                                "value" => $model_info->description,
                                "placeholder" => lang('description'),
                                "class" => "form-control"
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix">
                        <label for="start_date" class="col-md-2"><?php echo lang('start_date'); ?></label>
                        <div class="form-group col-md-4">
                            <?php
                            echo form_input(array(
                                "id" => "start_date",
                                "name" => "start_date",
                                "value" => $model_info->start_date,
                                "class" => "form-control",
                                "placeholder" => "YYYY-MM-DD",
                                "data-rule-required" => true,
                                "data-msg-required" => lang("field_required")
                            ));
                            ?>
                        </div>

                        <label for="end_date" class="col-md-2"><?php echo lang('end_date'); ?></label>
                        <div class="form-group col-md-4">
                            <?php
                            echo form_input(array(
                                "id" => "end_date",
                                "name" => "end_date",
                                "value" => $model_info->end_date,
                                "class" => "form-control",
                                "placeholder" => "YYYY-MM-DD",
                                "data-rule-required" => true,
                                "data-msg-required" => lang("field_required"),
                                "data-rule-greaterThanOrEqual" => "#start_date",
                                "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date")
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="share_with" class=" col-md-2"><?php echo lang('share_with'); ?></label>
                        <div class="col-md-10">
                            <div>
                                <?php
                                echo form_checkbox(array(
                                    "id" => "share_with_members",
                                    "name" => "share_with[]",
                                    "value" => "all_members",
                                        ), $model_info->share_with, (in_array("all_members", $share_with)) ? true : false);
                                ?>
                                <label for="share_with_members"><?php echo lang("all_team_members"); ?> </label>
                            </div>
                            <div>
                                <?php
                                echo form_checkbox(array(
                                    "id" => "share_with_clients",
                                    "name" => "share_with[]",
                                    "value" => "all_clients",
                                        ), $model_info->share_with, (in_array("all_clients", $share_with)) ? true : false);
                                ?>
                                <label for="share_with_clients"><?php echo lang("all_team_clients"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class=" col-md-2"></label>
                        <div class="col-md-10">
                            <?php
                            $this->load->view("includes/file_list", array("files" => $model_info->files));
                            ?>
                        </div>
                    </div>
                </div>

                <?php $this->load->view("includes/dropzone_preview"); ?>    

                <div class="panel-footer clearfix">
                    <button class="btn btn-default upload-file-button pull-left btn-sm round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
                    <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
                </div>
            </div>

            <?php echo form_close(); ?>
        </div> 
    </div> 
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#announcement-form").appForm({
            ajaxSubmit: false
        });
        $("#title").focus();

        initWYSIWYGEditor("#description", {
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['hr', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ],
            onImageUpload: function (files, editor, welEditable) {
                //insert image url
            },
            lang: "<?php echo lang('language_locale_long'); ?>"
        });

        setDatePicker("#start_date, #end_date");


        var uploadUrl = "<?php echo get_uri("announcements/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("announcements/validate_announcement_file"); ?>";

        var dropzone = attachDropzoneWithForm("#announcement-dropzone", uploadUrl, validationUrl);

    });
</script>    