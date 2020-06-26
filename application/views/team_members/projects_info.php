<div class="panel">
    <div class="tab-title clearfix">
        <h4><?php echo lang('projects'); ?></h4>
    </div>
    <div class="table-responsive">
        <table id="project-table" class="display" cellspacing="0" width="100%">
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#project-table").appTable({
            source: '<?php echo_uri("projects/projects_list_data_of_team_member/" . $user_id) ?>',
            radioButtons: [{text: '<?php echo lang("open") ?>', name: "status", value: "open", isChecked: true}, {text: '<?php echo lang("completed") ?>', name: "status", value: "completed", isChecked: false}, {text: '<?php echo lang("hold") ?>', name: "status", value: "hold", isChecked: false}, {text: '<?php echo lang("canceled") ?>', name: "status", value: "canceled", isChecked: false}],
            columns: [
                {title: '<?php echo lang("id") ?>', "class": "w50"},
                {title: '<?php echo lang("title") ?>'},
                {title: '<?php echo lang("client") ?>', "class": "w10p"},
                {visible: true, title: '<?php echo lang("price") ?>', "class": "w10p"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("start_date") ?>', "class": "w10p", "iDataSort": 4},
                {visible: false, searchable: false},
                {title: '<?php echo lang("deadline") ?>', "class": "w10p", "iDataSort": 6},
                {title: '<?php echo lang("progress") ?>', "class": "w10p"},
                {title: '<?php echo lang("status") ?>', "class": "w10p"}
                <?php echo $custom_field_headers; ?>
            ],
            order: [[1, "desc"]],
            printColumns: combineCustomFieldsColumns( [0, 1, 2, 3, 5, 7, 8, 9], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns( [0, 1, 2, 3, 5, 7, 8, 9], '<?php echo $custom_field_headers; ?>')
        });
    });
</script>