<style type="text/css">
    .flot-y1-axis {
        left: -35px !important;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <i class="fa fa-bar-chart pt10"></i>&nbsp; <?php echo lang("chart"); ?>
        <div class="pull-right">

            <div id="expense-chart-date-range-selector">

            </div>
        </div>
    </div>
    <div class="panel-body ">
        <div style="padding-left:35px;">
            <div id="yearly-expense-chart" style="width:100%; height: 350px;"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var prepareExpensesFlotChart = function (data) {
        appLoader.show();
        $.ajax({
            url: "<?php echo_uri("expenses/yearly_chart_data") ?>",
            data: data,
            cache: false,
            type: 'POST',
            dataType: "json",
            success: function (response) {
                appLoader.hide();
                initExpenseFlotChart(response.data);
            }
        });

    };

    var initExpenseFlotChart = function (data) {
        // var data = [["January", 1500], ["February", 100], ["March", 16000], ["April", 0], ["May", 17000], ["June", 10009]];

        $.plot("#yearly-expense-chart", [data], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    align: "center"
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
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
                        return "%s: " + toCurrency(z);
                    } else {
                        return  toCurrency(z);
                    }
                },
                defaultTheme: false
            }
        });
    };

    $(document).ready(function () {
        $("#expense-chart-date-range-selector").appDateRange({
            dateRangeType: "yearly",
            onChange: function (dateRange) {
                prepareExpensesFlotChart(dateRange);
            },
            onInit: function (dateRange) {
                prepareExpensesFlotChart(dateRange);
            }
        });

    });
</script>