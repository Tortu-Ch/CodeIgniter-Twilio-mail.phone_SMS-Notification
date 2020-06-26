<div class="panel">
    <div class="tab-title clearfix">
        <h4><?php echo lang('files'); ?></h4>
        <div class="title-button-group">
            <?php
            echo modal_anchor(get_uri("team_members/file_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_files'), array("class" => "btn btn-default", "title" => lang('add_files'), "data-post-user_id" => $user_id));
            ?>
        </div>
    </div>

    <div class="table-responsive">
        <table id="team-member-file-table" class="display" width="100%">            
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {


        $("#team-member-file-table").appTable({
            source: '<?php echo_uri("team_members/files_list_data/" . $user_id) ?>',
            order: [[0, "desc"]],
            columns: [
                {title: '<?php echo lang("id") ?>'},
                {title: '<?php echo lang("file") ?>'},
                {title: '<?php echo lang("size") ?>'},
                {title: '<?php echo lang("uploaded_by") ?>'},
                {title: '<?php echo lang("created_date") ?>'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4]
        });
    });
</script>