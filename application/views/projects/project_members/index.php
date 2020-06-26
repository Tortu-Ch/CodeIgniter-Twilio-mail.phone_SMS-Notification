<div class="panel no-border">
    <div class="tab-title clearfix">
        <h4><?php echo lang('project_members'); ?></h4>
        <div class="title-button-group">
            <?php
            if ($can_add_remove_project_members) {
                echo modal_anchor(get_uri("projects/project_member_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_member'), array("class" => "btn btn-default", "title" => lang('add_member'), "data-post-project_id" => $project_id));
            }
            ?>
        </div>
    </div>

    <div class="table-responsive">
        <table id="project-member-table" class="b-b-only no-thead" width="100%">            
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#project-member-table").appTable({
            source: '<?php echo_uri("projects/project_member_list_data/" . $project_id) ?>',
            hideTools: true,
            columns: [
                {title: ''},
                {title: '', "class": "text-center option w100"}
            ]
        });
    });
</script>