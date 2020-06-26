<?php if (isset($page_type) && $page_type === "full") { ?>
    <div id="page-content" class="m20 clearfix">
    <?php } ?>

    <div class="panel">
        <?php if (isset($page_type) && $page_type === "full") { ?>
            <div class="page-title clearfix">
                <h1><?php echo lang('projects'); ?></h1>
                <div class="title-button-group">
                    <?php
                    if (isset($can_create_projects) && $can_create_projects) {
                        echo modal_anchor(get_uri("projects/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_project'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_project')));
                    }
                    ?>
                </div>
            </div>
        <?php } else if (isset($page_type) && $page_type === "dashboard") { ?>
            <div class="page-title panel-sky clearfix">
                <h1><?php echo lang('projects'); ?></h1>
            </div>
        <?php } else { ?>
            <div class="tab-title clearfix">
                <h4><?php echo lang('projects'); ?></h4>
                <div class="title-button-group">
                    <?php
                    if (isset($can_create_projects) && $can_create_projects) {
                        echo modal_anchor(get_uri("projects/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_project'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_project')));
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive" id="client-projects-list">
            <table id="project-table" class="display" width="100%">            
            </table>
        </div>
    </div>
    <?php if (isset($page_type) && $page_type === "full") { ?>
    </div>
<?php } ?>

<?php
if (!isset($project_labels_dropdown)) {
    $project_labels_dropdown = "0";
}
?>


<script type="text/javascript">
    $(document).ready(function () {
        var hideTools = "<?php
if (isset($page_type) && $page_type === 'dashboard') {
    echo 1;
}
?>" || 0;


        var filters = [{name: "project_label", class: "w200", options: <?php echo $project_labels_dropdown; ?>}];

        //don't show filters if hideTools is true or $project_labels_dropdown is empty
        if (hideTools || !<?php echo $project_labels_dropdown; ?>) {
            filters = false;
        }


        $("#project-table").appTable({
            source: '<?php echo_uri("projects/projects_list_data_of_client/" . $client_id) ?>',
            order: [[0, "desc"]],
            hideTools: hideTools,
            multiSelect: [
                {
                    name: "status",
                    text: "<?php echo lang('status'); ?>",
                    options: [
                        {text: '<?php echo lang("open") ?>', value: "open", isChecked: true},
                        {text: '<?php echo lang("completed") ?>', value: "completed"},
                        {text: '<?php echo lang("hold") ?>', value: "hold"},
                        {text: '<?php echo lang("canceled") ?>', value: "canceled"}
                    ]
                }
            ],
            filterDropdown: filters,
            columns: [
                {title: '<?php echo lang("id") ?>', "class": "w50"},
                {title: '<?php echo lang("title") ?>'},
                {targets: [2], visible: false, searchable: false},
                {title: '<?php echo lang("price") ?>', "class": "w10p"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("start_date") ?>', "class": "w10p", "iDataSort": 4},
                {visible: false, searchable: false},
                {title: '<?php echo lang("deadline") ?>', "class": "w10p", "iDataSort": 6},
                {title: '<?php echo lang("progress") ?>', "class": "w15p"},
                {title: '<?php echo lang("status") ?>', "class": "w10p"}
<?php echo $custom_field_headers; ?>
            ],
            printColumns: combineCustomFieldsColumns([0, 1, 3, 5, 7, 9], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 1, 3, 5, 7, 9], '<?php echo $custom_field_headers; ?>')
        });
    });
</script>