<?php if (isset($page_type) && $page_type === "full") { ?>
    <div id="page-content" class="m20 clearfix">
    <?php } ?>

    <div class="panel">
        <?php if (isset($page_type) && $page_type === "full") { ?>
            <div class="page-title clearfix">
                <h1><?php echo lang('payments'); ?></h1>
            </div>
        <?php } else { ?>
            <div class="tab-title clearfix">
                <h4><?php echo lang('payments'); ?></h4>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table id="invoice-payment-table" class="display" width="100%">
            </table>
        </div>
    </div>
    <?php if (isset($page_type) && $page_type === "full") { ?>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        var currencySymbol = "<?php echo $client_info->currency_symbol; ?>";
        $("#invoice-payment-table").appTable({
            source: '<?php echo_uri("invoice_payments/payment_list_data_of_client/" . $client_id) ?>',
            order: [[1, "desc"]],
            columns: [
                {title: '<?php echo lang("invoice_id") ?> ', "class": "w10p"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("payment_date") ?> ', "class": "w15p",  "iDataSort": 1},
                {title: '<?php echo lang("payment_method") ?>', "class": "w15p"},
                {title: '<?php echo lang("note") ?>'},
                {title: '<?php echo lang("amount") ?>', "class": "text-right w15p"}
            ],
            printColumns: [0, 1, 2, 3, 4],
            xlsColumns: [0, 1, 2, 3, 4],
            summation: [{column: 5, dataType: 'currency', currencySymbol: currencySymbol}]
        });

    });
</script>