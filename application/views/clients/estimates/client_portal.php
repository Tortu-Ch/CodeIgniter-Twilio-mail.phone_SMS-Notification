<div id="page-content" class="clearfix p20">
    <div class="panel clearfix">

        <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li class="title-tab"><h4 class="pl15 pt10"></h4></li>
            <li><a role="presentation" class="active" href="javascript:;" data-target="#esimates-tab"><?php echo lang("estimates"); ?></a></li>
            <?php if (isset($can_request_estimate) && $can_request_estimate) { ?>
                <li><a role="presentation" href="<?php echo_uri("estimate_requests/estimate_requests_for_client/".$client_id); ?>" data-target="#esimate-requests-tab"><?php echo lang('estimate_requests'); ?></a></li>
                <div class="tab-title clearfix no-border">

                        <div class="title-button-group">
                            <?php echo modal_anchor(get_uri("estimate_requests/request_an_estimate_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('request_an_estimate'), array("class" => "btn btn-default", "title" => lang('request_an_estimate'))); ?>           
                        </div>

                </div>
             <?php } ?>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade" id="esimates-tab">
                <div class="table-responsive">
                    <table id="estimate-table" class="display" width="100%">
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="esimate-requests-tab"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var currencySymbol = "<?php echo $client_info->currency_symbol; ?>";
        $("#estimate-table").appTable({
            source: '<?php echo_uri("estimates/estimate_list_data_of_client/" . $client_id) ?>',
            order: [[0, "desc"]],
            columns: [
                {title: "<?php echo lang("estimate") ?>", "class": "w25p"},
                {visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: "<?php echo lang("estimate_date") ?>", "iDataSort": 2},
                {title: "<?php echo lang("amount") ?>", "class": "text-right"},
                {title: "<?php echo lang("status") ?>", "class": "text-center"}
                <?php echo $custom_field_headers; ?>,
                {visible: false}
            ],
            summation: [{column: 4, dataType: 'currency', currencySymbol: currencySymbol}]
        });
    });
</script>