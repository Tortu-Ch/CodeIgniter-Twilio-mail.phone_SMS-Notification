<table id="recurring-invoice-table" class="display" cellspacing="0" width="100%">   
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $("#recurring-invoice-table").appTable({
            source: '<?php echo_uri("invoices/recurring_list_data") ?>',
            order: [[0, "desc"]],
            rangeDatepicker: [{startDate: {name: "next_recurring_start_date"}, endDate: {name: "next_recurring_end_date"}, showClearButton: true}],
            columns: [
                {title: "<?php echo lang("invoice_id") ?>", "class": "w10p"},
                {title: "<?php echo lang("client") ?>", "class": ""},
                {title: "<?php echo lang("project") ?>", "class": "w15p"},
                {visible: false, searchable: false},
                {title: "<?php echo lang("next_recurring_date") ?>", "iDataSort": 4, "class": "w10p"},
                {title: "<?php echo lang("repeat_every") ?>", "class": "w10p text-center"},
                {title: "<?php echo lang("cycles") ?>", "class": "w10p text-center"},
                {title: "<?php echo lang("status") ?>", "class": "w10p text-center"},
                {title: "<?php echo lang("invoice_value") ?>", "class": "w10p text-right"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 4, 5, 6, 7, 8],
            xlsColumns: [0, 1, 2, 4, 5, 6, 7, 8],
            summation: [{column: 8, dataType: 'currency', currencySymbol: AppHelper.settings.currencySymbol}]
        });
    });
</script>