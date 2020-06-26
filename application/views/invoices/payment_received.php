<div id="page-content" class="clearfix p20">
    <div class="panel clearfix">
        <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white inner" role="tablist">
            <li class="title-tab"><h4 class="pl15 pt5 pr15"><?php echo lang("payment_received"); ?></h4></li>
            <li><a id="monthly-payment-button"  role="presentation" class="active" href="javascript:;" data-target="#monthly-payments"><?php echo lang("monthly"); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoice_payments/yearly/"); ?>" data-target="#yearly-payments"><?php echo lang('yearly'); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoice_payments/custom/"); ?>" data-target="#custom-payments"><?php echo lang('custom'); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoice_payments/yearly_chart/"); ?>" data-target="#yearly-chart"><?php echo lang('chart'); ?></a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade" id="monthly-payments">
                <div class="table-responsive">
                    <table id="monthly-invoice-payment-table" class="display" width="100%">
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="yearly-payments"></div>
            <div role="tabpanel" class="tab-pane fade" id="custom-payments"></div>
            <div role="tabpanel" class="tab-pane fade" id="yearly-chart"></div>
        </div>
    </div>
</div>


<div class="panel clearfix">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="team_member-monthly-leaves">
            <table id="monthly-leaves-table" class="display" cellspacing="0" width="100%">            
            </table>
            <script type="text/javascript">
                loadPaymentsTable = function (selector, dateRange) {
                    var customDatePicker = "";
                    if (dateRange === "custom") {
                        customDatePicker = [{startDate: {name: "start_date", value: moment().format("YYYY-MM-DD")}, endDate: {name: "end_date", value: moment().format("YYYY-MM-DD")}, showClearButton: true}];
                        dateRange = "";
                    }

                    $(selector).appTable({
                        source: '<?php echo_uri("invoice_payments/payment_list_data/") ?>',
                        order: [[0, "asc"]],
                        dateRangeType: dateRange,
                        filterDropdown: [{name: "payment_method_id", class: "w200", options: <?php echo $payment_method_dropdown; ?>}],
                        rangeDatepicker: customDatePicker,
                        columns: [
                            {title: '<?php echo lang("invoice_id") ?> ', "class": "w10p"},
                            {visible: false, searchable: false},
                            {title: '<?php echo lang("payment_date") ?> ', "class": "w15p", "iDataSort": 1},
                            {title: '<?php echo lang("payment_method") ?>', "class": "w15p"},
                            {title: '<?php echo lang("note") ?>'},
                            {title: '<?php echo lang("amount") ?>', "class": "text-right w15p"}
                        ],
                        summation: [{column: 5, dataType: 'currency', currencySymbol: AppHelper.settings.currencySymbol}],
                        printColumns: [0, 1, 2, 3, 4],
                        xlsColumns: [0, 1, 2, 3, 4]
                    });
                };

                $(document).ready(function () {
                    $("#monthly-payment-button").trigger("click");
                    loadPaymentsTable("#monthly-invoice-payment-table", "monthly");
                });
            </script>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="team_member-yearly-leaves"></div>
    </div>
</div>