<div class="panel panel-default">
    <div class="panel-heading no-border">
        <i class="fa fa-tasks"></i>&nbsp; <?php echo lang('my_tasks'); ?>
    </div>

    <div class="table-responsive" id="my-task-list-widget-table">
        <table id="task-table" class="display" cellspacing="0" width="100%">            
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        initScrollbar('#my-task-list-widget-table', {
            setHeight: 330
        });

        $("#task-table").appTable({
            source: '<?php echo_uri("projects/my_tasks_list_data/1") ?>',
            order: [[5, "desc"]],
            displayLength: 30,
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo lang("id") ?>', "class": "w70"},
                {title: '<?php echo lang("title") ?>'},
                {visible: false, searchable: false},
                {title: '<?php echo lang("start_date") ?>', "iDataSort": 3, "class": "w70"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("deadline") ?>', "iDataSort": 5, "class": "w70"},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: '<?php echo lang("status") ?>', "class": "w70"},
                {visible: false, searchable: false}
            ],
            onInitComplete: function () {
                $("#task-table_wrapper .datatable-tools").addClass("hide");
            },
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).attr("style", "border-left:5px solid " + aData[0] + " !important;");
            }
        });
    });
</script>
<?php $this->load->view("projects/tasks/update_task_script"); ?>