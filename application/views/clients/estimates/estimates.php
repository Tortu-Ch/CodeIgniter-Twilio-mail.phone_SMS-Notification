<div class="panel">
    <div class="tab-title clearfix">
        <h4><?php echo lang('estimates'); ?></h4>
        <div class="title-button-group">
            <?php echo modal_anchor(get_uri("estimates/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_estimate'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_estimate'))); ?>
        </div>
    </div>
    <div class="table-responsive">
        <table id="estimate-table" class="display" width="100%">
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var currencySymbol = "<?php echo $client_info->currency_symbol; ?>";
        $("#estimate-table").appTable({
            source: '<?php echo_uri("estimates/estimate_list_data_of_client/" . $client_id) ?>',
            order: [[0, "desc"]],
            columns: [
                {title: "<?php echo lang("estimate") ?>", "class": "w20p"},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: "<?php echo lang("estimate_date") ?>", "iDataSort": 2, "class": "w20p"},
                {title: "<?php echo lang("amount") ?>", "class": "text-right w20p"},
                {title: "<?php echo lang("status") ?>", "class": "text-center w20p"}
                <?php echo $custom_field_headers; ?>,
                {visible: false}
            ],
            summation: [{column: 4, dataType: 'currency', currencySymbol: currencySymbol}]
        });
    });
</script>