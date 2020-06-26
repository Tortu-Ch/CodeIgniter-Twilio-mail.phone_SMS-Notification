<style type="text/css">.post-file-previews {border:none !important; }</style>

<div id="estimate-form-preview" class="panel panel-default  p15 no-border clearfix post-dropzone" style="max-width: 1000px; margin: auto;">

    <h3 id="estimate-form-title" class=" pl10 pr10"> <?php echo $model_info->title; ?></h3>

    <div class="pl10 pr10"><?php echo nl2br($model_info->description); ?></div>
    <div class=" pt10 mt15">
        <div class="table-responsive general-form ">
            <table id="estimate-form-table" class="display b-t no-thead b-b-only no-hover" cellspacing="0" width="100%">            
            </table>
        </div>

    </div>
    <?php if ($model_info->enable_attachment) { ?>
        <div class="clearfix pl10 pr10 b-b">
            <?php $this->load->view("includes/dropzone_preview"); ?>    
        </div>
    <?php } ?>
    <div class="p15"> 
        <?php if ($model_info->enable_attachment) { ?>
            <button class="btn btn-default upload-file-button mr15 round" type="button" style="color:#7988a2"><i class='fa fa-camera'></i> <?php echo lang("upload_file"); ?></button>
        <?php } ?>
        <button type="submit" class="btn btn-primary"><span class="fa fa-send"></span> <?php echo lang('request_an_estimate'); ?></button>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-form-table").appTable({
            source: '<?php echo_uri("estimate_requests/estimate_form_filed_list_data/" . $model_info->id) ?>',
            order: [[1, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {title: "<?php echo lang("title") ?>"},
                {visible: false},
                {visible: false}
            ],
            onInitComplete: function () {
                $(".dataTables_empty").hide();
            }
        });
        var enable_attachment="<?php echo $model_info->enable_attachment; ?>";
        var login_user_type="<?php echo $this->login_user->user_type; ?>";

        if (enable_attachment === "1" && login_user_type==="client") {

            var uploadUrl = "<?php echo get_uri("estimate_requests/upload_file"); ?>";
            var validationUrl = "<?php echo get_uri("estimate_requests/validate_file"); ?>";
            var dropzone = attachDropzoneWithForm("#estimate-form-preview", uploadUrl, validationUrl);
        }
    });
</script>
