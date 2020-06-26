<div class="panel">
    <div class="tab-title clearfix">
        <h4><?php echo lang('files'); ?></h4>
        <div class="title-button-group">

            <?php echo anchor("", "<i class='fa fa fa-cloud-download'></i> " . lang("download"), array("title" => lang("download"), "id" => "download-multiple-file-btn", "class" => "btn btn-default hide")); ?>

            <?php
            if ($can_add_files) {
                echo modal_anchor(get_uri("projects/file_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_files'), array("class" => "btn btn-default", "title" => lang('add_files'), "data-post-project_id" => $project_id));
            }
            ?>
        </div>
    </div>

    <div class="table-responsive">
        <table id="project-file-table" class="display" width="100%">            
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        //we have to add values of selected files for multiple download
        var fields = [];

        $('body').on('click', '[data-act=download-multiple-file-checkbox]', function () {

            var checkbox = $(this).find("span"),
                    file_id = $(this).attr("data-id");

            checkbox.addClass("inline-loader");

            //there are two operation
            if ($.inArray(file_id, fields) !== -1) {
                //if there is already added the file to download list
                var index = fields.indexOf(file_id);
                fields.splice(index, 1);
                checkbox.removeClass("checkbox-checked");
            } else {
                //if it's new item to add to download list
                fields.push(file_id);
                checkbox.addClass("checkbox-checked");
            }
            
            checkbox.removeClass("inline-loader");

            var serializeOfArray = fields.join("-");

            $("#download-multiple-file-btn").attr("href", "<?php echo_uri("projects/download_multiple_files/"); ?>" + serializeOfArray);

            if (fields.length) {
                $("#download-multiple-file-btn").removeClass("hide");
            } else {
                $("#download-multiple-file-btn").addClass("hide");
            }

        });

        //trigger download operation for multiple download
        $("#download-multiple-file-btn").click(function () {
            $(this).addClass("hide");
            $("[data-act=download-multiple-file-checkbox]").find("span").removeClass("checkbox-checked");
            fields = [];
        });


        var userType = "<?php echo $this->login_user->user_type; ?>",
                showUploadeBy = true;
        if (userType == "client") {
            showUploadeBy = false;
        }


        $("#project-file-table").appTable({
            source: '<?php echo_uri("projects/files_list_data/" . $project_id) ?>',
            order: [[0, "desc"]],
            columns: [
                {title: '<?php echo lang("id") ?>'},
                {title: '<?php echo lang("file") ?>'},
                {title: '<?php echo lang("size") ?>'},
                {visible: showUploadeBy, title: '<?php echo lang("uploaded_by") ?>'},
                {title: '<?php echo lang("created_date") ?>'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4]
        });
    });
</script>