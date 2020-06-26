<div class="panel">
    <div class="panel-body">
        <div id="task-status-pai" class="p15" style="width: 100%; height: 220px;"></div>
    </div>
</div>

<?php

$task_data = array();
foreach ($task_statuses as $status) {
    $task_data[] = array("label" => $status->key_name ? lang($status->key_name) : $status->title, "data" => $status->total, "color" => $status->color);
}
?>
<script>
    $(function () {
        var taskData = <?php echo json_encode($task_data) ?>;

        if (taskData && taskData.length) {
            $.plot('#task-status-pai', taskData, {
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
        }
    });
</script>