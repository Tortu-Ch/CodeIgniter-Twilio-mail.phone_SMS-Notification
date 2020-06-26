<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-file-text-o"></i>&nbsp; <?php echo lang("timesheet_statistics"); ?>
    </div>
    <div class="panel-body ">
        <div id="timesheet-statistics-flotchart" style="width: 100%; height: 300px;"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var timesheetStatisticsFlotchart = function () {
            var timesheets = <?php echo $timesheets; ?>,
                    ticks = <?php echo $ticks; ?>,
                    dataset = [
                        {
                            data: timesheets,
                            color: "rgba(0, 179, 147, 1)",
                            lines: {
                                show: true,
                                fill: 0.2
                            },
                            points: {
                                show: false
                            },
                            shadowSize: 0
                        },
                        {
                            label: "<?php echo lang('timesheets'); ?>",
                            data: timesheets,
                            color: "rgba(0, 179, 147, 1)",
                            lines: {
                                show: false
                            },
                            points: {
                                show: true,
                                fill: true,
                                radius: 4,
                                fillColor: "#fff",
                                lineWidth: 1
                            },
                            shadowSize: 0,
                            curvedLines: {
                                apply: false
                            }
                        }
                    ];

            $.plot("#timesheet-statistics-flotchart", dataset, {
                series: {
                    curvedLines: {
                        apply: true,
                        active: true,
                        monotonicFit: true
                    }
                },
                legend: {
                    show: true
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    ticks: ticks
                },
                grid: {
                    color: "#bbb",
                    hoverable: true,
                    borderWidth: 0,
                    backgroundColor: '#FFF'
                },
                tooltip: true,
                tooltipOpts: {
                    content: function (x, y, z) {
                        if (x) {
                            return secondsToTimeFormat(z * 60);
                        } else {
                            return false;
                        }
                    },
                    defaultTheme: false
                }
            });

        };

        timesheetStatisticsFlotchart();
    });
</script>    

