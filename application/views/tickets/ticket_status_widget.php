<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-life-ring"></i>&nbsp;<?php echo lang("ticket_status"); ?>
    </div>
    <div class="panel-body ">
        <div id="ticket-status-flotchart" style="width: 100%; height: 300px;"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var data = [
            {label: " <?php echo lang("new"); ?>", data: "<?php echo $new ?>" * 1, color: "#F0AD4E"},
            {label: " <?php echo lang("open"); ?>", data: "<?php echo $open ?>" * 1, color: "#F06C71"},
            {label: " <?php echo lang("closed"); ?>", data: "<?php echo $closed ?>" * 1, color: "#00B393"}
        ];

        $.plot('#ticket-status-flotchart', data, {
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