<?php
$this->load->view("includes/summernote");
?>

<div id="page-content" class="clearfix p20">
    <div class="panel view-container">
        <div id="help-dropzone" class="post-dropzone">
            <?php echo form_open(get_uri("help/save_article"), array("id" => "article-form", "class" => "general-form", "role" => "form")); ?>

            <div class="panel-default">

                <div class="page-title clearfix">
                    <?php if ($model_info->id) { ?>
                        <h1><?php echo lang('edit_article') . " (" . lang($type) . ")"; ?></h1>
                        <div class="title-button-group">
                            <?php echo anchor(get_uri("help/view/" . $model_info->id), "<i class='fa fa-external-link-square'></i> " . lang('view'), array("class" => "btn btn-default", "title" => lang('view'))); ?>
                            <?php echo anchor(get_uri("help/article_form/" . $type), "<i class='fa fa-plus-circle'></i> " . lang('add_article'), array("class" => "btn btn-default", "title" => lang('add_article'))); ?>
                        </div>
                    <?php } else { ?>
                        <h1><?php echo lang('add_article') . " (" . lang($type) . ")"; ?></h1>
                    <?php } ?>
                </div>

                <div class="panel-body">

                    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
                    <input type="hidden" name="type" value="<?php echo $type; ?>" />

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
                        <label for="category_id" class=" col-md-12"><?php echo lang('category'); ?></label>
                        <div class=" col-md-12">
                            <?php
                            echo form_dropdown("category_id", $categories_dropdown, $model_info->category_id, "class='select2 validate-hidden' id='category_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
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

                    <div class="form-group">
                        <div class=" col-md-12">
                            <?php
                            echo form_radio(array(
                                "id" => "status_active",
                                "name" => "status",
                                "data-msg-required" => lang("field_required"),
                                    ), "active", ($model_info->status === "active") ? true : ($model_info->status !== "inactive") ? true : false);
                            ?>
                            <label for="status_active" class="mr15"><?php echo lang('active'); ?></label>
                            <?php
                            echo form_radio(array(
                                "id" => "status_inactive",
                                "name" => "status",
                                "data-msg-required" => lang("field_required"),
                                    ), "inactive", ($model_info->status === "inactive") ? true : false);
                            ?>
                            <label for="status_inactive" class=""><?php echo lang('inactive'); ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
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
        $("#article-form").appForm({
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
                ['insert', ['link','hr', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ],
            onImageUpload: function (files, editor, welEditable) {
                //insert image url
            },
            lang: "<?php echo lang('language_locale_long'); ?>"
        });


        $("#category_id").select2();


        var uploadUrl = "<?php echo get_uri("help/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("help/validate_file"); ?>";

        var dropzone = attachDropzoneWithForm("#help-dropzone", uploadUrl, validationUrl);
    });
</script>