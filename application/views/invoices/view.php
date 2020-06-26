<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1><?php echo get_invoice_id($invoice_info->id); ?>
                <?php
                if ($invoice_info->recurring) {
                    $recurring_status_class = "text-primary";
                    if ($invoice_info->no_of_cycles_completed > 0 && $invoice_info->no_of_cycles_completed == $invoice_info->no_of_cycles) {
                        $recurring_status_class = "text-danger";
                    }
                    ?>
                    <span class="label ml15 b-a "><span class="<?php echo $recurring_status_class; ?>"><?php echo lang('recurring'); ?></span></span>
                <?php } ?>
            </h1>
            <div class="title-button-group">
                <span class="dropdown inline-block">
                    <button class="btn btn-info dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><?php echo modal_anchor(get_uri("invoices/send_invoice_modal_form/" . $invoice_info->id), "<i class='fa fa-envelope-o'></i> " . lang('email_invoice_to_client'), array("title" => lang('email_invoice_to_client'), "data-post-id" => $invoice_info->id, "role" => "menuitem", "tabindex" => "-1")); ?> </li>
                        <li role="presentation"><?php echo anchor(get_uri("invoices/download_pdf/" . $invoice_info->id), "<i class='fa fa-download'></i> " . lang('download_pdf'), array("title" => lang('download_pdf'))); ?> </li>
                        <li role="presentation"><?php echo anchor(get_uri("invoices/preview/" . $invoice_info->id . "/1"), "<i class='fa fa-search'></i> " . lang('invoice_preview'), array("title" => lang('invoice_preview')), array("target" => "_blank")); ?> </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("invoices/modal_form"), "<i class='fa fa-edit'></i> " . lang('edit_invoice'), array("title" => lang('edit_invoice'), "data-post-id" => $invoice_info->id, "role" => "menuitem", "tabindex" => "-1")); ?> </li>

                        <?php if ($invoice_status == "draft") { ?>
                            <li role="presentation"><?php echo ajax_anchor(get_uri("invoices/set_invoice_status_to_not_paid/" . $invoice_info->id), "<i class='fa fa-check'></i> " . lang('mark_invoice_as_not_paid'), array("data-reload-on-success" => "1")); ?> </li>
                        <?php } ?>
                    </ul>
                </span>
                <?php echo modal_anchor(get_uri("invoices/item_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_item'), array("class" => "btn btn-default", "title" => lang('add_item'), "data-post-invoice_id" => $invoice_info->id)); ?>
                <?php echo modal_anchor(get_uri("invoice_payments/payment_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_payment'), array("class" => "btn btn-default", "title" => lang('add_payment'), "data-post-invoice_id" => $invoice_info->id)); ?>
            </div>
        </div>

        <div id="invoice-status-bar">
            <?php $this->load->view("invoices/invoice_status_bar"); ?>
        </div>

        <?php
        if ($invoice_info->recurring) {
            $this->load->view("invoices/invoice_recurring_info_bar");
        }
        ?>

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
                <div class="clearfix p20">
                    <!-- small font size is required to generate the pdf, overwrite that for screen -->
                    <style type="text/css"> .invoice-meta {font-size: 100% !important;}</style>

                    <?php
                    $color = get_setting("invoice_color");
                    if (!$color) {
                        $color = "#2AA384";
                    }
                    $invoice_style = get_setting("invoice_style");
                    $data = array(
                        "client_info" => $client_info,
                        "color" => $color,
                        "invoice_info" => $invoice_info
                    );

                    if ($invoice_style === "style_2") {
                        $this->load->view('invoices/invoice_parts/header_style_2.php', $data);
                    } else {
                        $this->load->view('invoices/invoice_parts/header_style_1.php', $data);
                    }
                    ?>
                </div>

                <div class="table-responsive mt15 pl15 pr15">
                    <table id="invoice-item-table" class="display" width="100%">            
                    </table>
                </div>

                <div class="clearfix">
                    <div class="pull-right pr15" id="invoice-total-section" style="width: 420px;">
                        <?php $this->load->view("invoices/invoice_total_section", array("invoice_id" => $invoice_info->id)); ?>
                    </div>
                </div>

                <p class="b-t b-info pt10 m15"><?php echo nl2br($invoice_info->note); ?></p>

            </div>
        </div>



        <?php if ($invoice_info->recurring) { ?>
            <ul data-toggle="ajax-tab" class="nav nav-tabs" role="tablist">
                <li><a  role="presentation" href="#" data-target="#invoice-payments"> <?php echo lang('payments'); ?></a></li>
                <li><a  role="presentation" href="<?php echo_uri("invoices/sub_invoices/" . $invoice_info->id); ?>" data-target="#sub-invoices"> <?php echo lang('sub_invoices'); ?></a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active" id="invoice-payments">
                    <div class="panel panel-default">
                        <div class="tab-title clearfix">
                            <h4> <?php echo lang('invoice_payment_list'); ?></h4>
                        </div>
                        <div class="table-responsive">
                            <table id="invoice-payment-table" class="display" cellspacing="0" width="100%">            
                            </table>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="sub-invoices"></div>
            </div>
        <?php } else { ?>

            <div class="panel panel-default">
                <div class="tab-title clearfix">
                    <h4> <?php echo lang('invoice_payment_list'); ?></h4>
                </div>
                <div class="table-responsive">
                    <table id="invoice-payment-table" class="display" cellspacing="0" width="100%">            
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>



<script type="text/javascript">
    RELOAD_VIEW_AFTER_UPDATE = true;
    $(document).ready(function () {
        $("#invoice-item-table").appTable({
            source: '<?php echo_uri("invoices/item_list_data/" . $invoice_info->id . "/") ?>',
            order: [[0, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {visible: false, searchable: false},
                {title: '<?php echo lang("item") ?> ', "bSortable": false},
                {title: '<?php echo lang("quantity") ?>', "class": "text-right w15p", "bSortable": false},
                {title: '<?php echo lang("rate") ?>', "class": "text-right w15p", "bSortable": false},
                {title: '<?php echo lang("total") ?>', "class": "text-right w15p", "bSortable": false},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100", "bSortable": false}
            ],
            onInitComplete: function () {
                //apply sortable
                $("#invoice-item-table").find("tbody").attr("id", "invoice-item-table-sortable");
                var $selector = $("#invoice-item-table-sortable");

                Sortable.create($selector[0], {
                    animation: 150,
                    chosenClass: "sortable-chosen",
                    ghostClass: "sortable-ghost",
                    onUpdate: function (e) {
                        appLoader.show();
                        //prepare sort indexes 
                        var data = "";
                        $.each($selector.find(".item-row"), function (index, ele) {
                            if (data) {
                                data += ",";
                            }

                            data += $(ele).attr("data-id") + "-" + index;
                        });

                        //update sort indexes
                        $.ajax({
                            url: '<?php echo_uri("Invoices/update_item_sort_values") ?>',
                            type: "POST",
                            data: {sort_values: data},
                            success: function () {
                                appLoader.hide();
                            }
                        });
                    }
                });

            },
            onDeleteSuccess: function (result) {
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            },
            onUndoSuccess: function (result) {
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });

        $("#invoice-payment-table").appTable({
            source: '<?php echo_uri("invoice_payments/payment_list_data/" . $invoice_info->id . "/") ?>',
            order: [[0, "asc"]],
            columns: [
                {targets: [0], visible: false, searchable: false},
                {visible: false, searchable: false},
                {title: '<?php echo lang("payment_date") ?> ', "class": "w15p", "iDataSort": 1},
                {title: '<?php echo lang("payment_method") ?>', "class": "w15p"},
                {title: '<?php echo lang("note") ?>'},
                {title: '<?php echo lang("amount") ?>', "class": "text-right w15p"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            onDeleteSuccess: function (result) {
                updateInvoiceStatusBar();
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            },
            onUndoSuccess: function (result) {
                updateInvoiceStatusBar();
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });
    });

    updateInvoiceStatusBar = function (invoiceId) {
        $.ajax({
            url: "<?php echo get_uri("invoices/get_invoice_status_bar"); ?>/" + invoiceId,
            success: function (result) {
                if (result) {
                    $("#invoice-status-bar").html(result);
                }
            }
        });
    };

    $(document).ready(function(){
        $('#address_choose').change(function(){
            
                $.ajax({
                    url: "<?php echo get_uri("invoices/change_default_address/"); ?>/",
                    type:"post",
                    dataType: "json",
                    data:{
                        client_id : '<?php echo $client_info->id ?>',
                        bill_address_selected : $(this).val()
                    },
                    success: function (result) {
                        if(result.success == true) {
                            if(result.bill_address == 1) {
                                
                                var html = '';
                                if(result.client_info.bill_name != '' && result.client_info.bill_name != null) {
                                     var bill_name = result.client_info.bill_name;
                                }

                                $('#company_name').html(bill_name);

                                if(result.client_info.bill_address != '' && result.client_info.bill_address != null) {
                                     html += result.client_info.bill_address;
                                }
                                $('#invoice-meta-client-address').html(html);

                            }else{
                                $('#company_name').html(result.client_info.company_name);
                                var html = '';
                                if(result.client_info.city != '') {
                                     html += result.client_info.city;
                                }
                                if(result.client_info.state != '') {
                                     html += '<br>'+result.client_info.state;
                                }
                                if(result.client_info.zip != '') {
                                     html += '<br>'+result.client_info.zip;
                                }
                                if(result.client_info.country != '') {
                                     html += '<br>'+result.client_info.country;
                                }
                                if(result.client_info.vat_number != '') {
                                     html += '<br>VAT Number : '+result.client_info.vat_number;
                                }
                                if(result.client_info.bill_name != '' && result.client_info.bill_name != null) {
                                     html += '<br>Bill Name : '+result.client_info.bill_name;
                                }
                                if(result.client_info.bill_address != '' && result.client_info.bill_address != null) {
                                     html += '<br>Bill Address : '+result.client_info.bill_address;
                                }
                                $('#invoice-meta-client-address').html(html);    
                            }
                                
                        }
                        
                    }
                });
            
        });
    })

</script>

<?php
//required to send email 

load_css(array(
    "assets/js/summernote/summernote.css",
));
load_js(array(
    "assets/js/summernote/summernote.min.js",
));
?>

