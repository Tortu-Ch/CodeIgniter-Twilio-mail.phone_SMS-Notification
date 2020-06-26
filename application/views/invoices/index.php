<div id="page-content" class="clearfix p20">
    <div class="panel clearfix">
        <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo lang("invoices"); ?></h4></li>
            <li><a id="monthly-expenses-button"  role="presentation" class="active" href="javascript:;" data-target="#monthly-invoices"><?php echo lang("monthly"); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoices/yearly/"); ?>" data-target="#yearly-invoices"><?php echo lang('yearly'); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoices/custom/"); ?>" data-target="#custom-invoices"><?php echo lang('custom'); ?></a></li>
            <li><a role="presentation" href="<?php echo_uri("invoices/recurring/"); ?>" data-target="#recurring-invoices"><?php echo lang('recurring'); ?></a></li>
            <div class="tab-title clearfix no-border">
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("invoices/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_invoice'), array("class" => "btn btn-default mb0", "title" => lang('add_invoice'))); ?>
                </div>
            </div>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade" id="monthly-invoices">
                <div class="table-responsive">
                    <table id="monthly-invoice-table" class="display" cellspacing="0" width="100%">   
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="yearly-invoices"></div>
            <div role="tabpanel" class="tab-pane fade" id="custom-invoices"></div>
            <div role="tabpanel" class="tab-pane fade" id="recurring-invoices"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadInvoicesTable = function (selector, dateRange) {
        var customDatePicker = "";
        if (dateRange === "custom") {
            customDatePicker = [{startDate: {name: "start_date", value: moment().format("YYYY-MM-DD")}, endDate: {name: "end_date", value: moment().format("YYYY-MM-DD")}, showClearButton: true}];
            dateRange = "";
        }

        $(selector).appTable({
            source: '<?php echo_uri("invoices/list_data") ?>',
            dateRangeType: dateRange,
            order: [[0, "desc"]],
            filterDropdown: [{name: "status", class: "w150", options: <?php $this->load->view("invoices/invoice_statuses_dropdown"); ?>}],
            rangeDatepicker: customDatePicker,
            columns: [
                {title: "<?php echo lang("invoice_id") ?>", "class": "w10p"},
                {title: "<?php echo lang("client") ?>", "class": ""},
                {title: "<?php echo lang("project") ?>", "class": "w15p"},
                {visible: false, searchable: false},
                {title: "<?php echo lang("bill_date") ?>", "class": "w10p", "iDataSort": 3},
                {visible: false, searchable: false},
                {title: "<?php echo lang("due_date") ?>", "class": "w10p", "iDataSort": 5},
                {title: "<?php echo lang("invoice_value") ?>", "class": "w10p text-right"},
                {title: "<?php echo lang("payment_received") ?>", "class": "w10p text-right"},
                {title: "<?php echo lang("status") ?>", "class": "w10p text-center"}
<?php echo $custom_field_headers; ?>,
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: combineCustomFieldsColumns([0, 1, 2, 3, 5, 7, 8, 9], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 1, 2, 3, 5, 7, 8, 9], '<?php echo $custom_field_headers; ?>'),
            summation: [{column: 7, dataType: 'currency', currencySymbol: AppHelper.settings.currencySymbol}, {column: 8, dataType: 'currency', currencySymbol: AppHelper.settings.currencySymbol}]
        });

    };

    $(document).ready(function () {
        $("#monthly-invoice-table").trigger("click");
        loadInvoicesTable("#monthly-invoice-table", "monthly");
    });
</script>