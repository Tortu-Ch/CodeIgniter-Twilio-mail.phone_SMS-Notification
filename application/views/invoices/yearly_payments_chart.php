<style type="text/css">
    .flot-y1-axis {
        left: -35px !important;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <i class="fa fa-bar-chart pt10"></i>&nbsp; <?php echo lang("chart"); ?>
        <div class="pull-right">

            <div id="payment-chart-date-range-selector">

            </div>
        </div>
    </div>
    <div class="panel-body ">
        <div style="padding-left:35px;">
            <div id="yearly-payment-chart" style="width:100%; height: 350px;"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var preparePaymentsFlotChart = function (data) {
        appLoader.show();
        $.ajax({
            url: "<?php echo_uri("invoice_payments/yearly_chart_data") ?>",
            data: data,
            cache: false,
            type: 'POST',
            dataType: "json",
            success: function (response) {
                appLoader.hide();
                initPaymentsFlotChart(response.data);
            }
        });

    };

    var initPaymentsFlotChart = function (data) {
        // var data = [["January", 1500], ["February", 100], ["March", 16000], ["April", 0], ["May", 17000], ["June", 10009]];

        $.plot("#yearly-payment-chart", [data], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    align: "center"
                }
            },
             colors: ['#009688', 'rgba(0, 150, 136, 0.72)'],
            xaxis: {
                mode: "categories",
                tickLength: 0,
                fillColor: "#ccc",
                background: "#ccc"
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
        $("#payment-chart-date-range-selector").appDateRange({
            dateRangeType: "yearly",
            onChange: function (dateRange) {
                preparePaymentsFlotChart(dateRange);
            },
            onInit: function (dateRange) {
                preparePaymentsFlotChart(dateRange);
            }
        });

    });
</script>