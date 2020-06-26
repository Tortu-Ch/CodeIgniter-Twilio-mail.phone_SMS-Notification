<div class="panel panel-default <?php echo $custom_class; ?>">
    <div class="panel-heading">
        <i class="fa fa-tasks"></i>&nbsp;<?php echo lang("task_status"); ?>
    </div>
    <div class="panel-body ">
        <div id="my-task-status-pai" style="width: 100%; height: 250px;"></div>
    </div>
</div>
<?php
$task_data = array();
foreach ($task_statuses as $status) {
    $task_data[] = array("label" => $status->key_name ? lang($status->key_name) : $status->title, "data" => $status->total, "color" => $status->color);
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        var taskData = <?php echo json_encode($task_data) ?>;

        if (!taskData.length) {
            taskData = [{data: 0}];
        }

        $.plot('#my-task-status-pai', taskData, {
            series: {
                pie: {
                    show: true,
                    innerRadius: 0.5
                }
            },
            legend: {
                show: true
            },
            grid: {
                hoverable: true
            },
            tooltip: {
                show: true,
                content: "%s: %p.0%, %n", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });
    });
</script>    