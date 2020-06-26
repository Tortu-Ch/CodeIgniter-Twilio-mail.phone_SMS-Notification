<?php if (isset($page_type) && $page_type === "full") { ?>
    <div id="page-content" class="m20 clearfix">
    <?php } ?>

    <div class="panel">
        <?php if (isset($page_type) && $page_type === "full") { ?>
            <div class="page-title clearfix">
                <h1><?php echo lang('invoices'); ?></h1>
            </div>
        <?php } else { ?>
            <div class="tab-title clearfix">
                <h4><?php echo lang('invoices'); ?></h4>
                <div class="title-button-group">
                    
                    <?php echo modal_anchor(get_uri("invoices/send_invoices_modal_form"), "<i class='fa fa-envelope-o'></i> " . lang('email_invoice_to_client'), array("class" => "btn btn-default mb0 multiple-invoices-btn", "data-post-invoices_id" => '', "title" => lang('email_invoice_to_client'), "disabled" => "disabled")); ?>
                    <?php echo modal_anchor(get_uri("invoices/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_invoice'), array("class" => "btn btn-default mb0", "data-post-client_id" => $client_id, "title" => lang('add_invoice'))); ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table id="invoice-table" class="display" width="100%">
            </table>
        </div>
    </div>
    <?php if (isset($page_type) && $page_type === "full") { ?>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        var currencySymbol = "<?php echo $client_info->currency_symbol; ?>";
        $("#invoice-table").appTable({
            source: '<?php echo_uri("invoices/invoice_list_data_of_client/" . $client_id) ?>',
            order: [[0, "desc"]],
            filterDropdown: [{name: "status", class: "w150", options: <?php $this->load->view("invoices/invoice_statuses_dropdown"); ?>}],
            columns: [
                {title: '<?php echo lang("id") ?>', "class": "w10p"},
                {targets: [1], visible: false, searchable: false},
                {title: "<?php echo lang("project") ?>"},
                {visible: false, searchable: false},
                {title: "<?php echo lang("bill_date") ?>", "class": "w10p", "iDataSort": 3},
                {visible: false, searchable: false},
                {title: "<?php echo lang("due_date") ?>", "class": "w10p", "iDataSort": 5},
                {title: "<?php echo lang("invoice_value") ?>", "class": "w10p text-right"},
                {title: "<?php echo lang("payment_received") ?>", "class": "w10p text-right"},
                {title: '<?php echo lang("status") ?>', "class": "w10p text-center"}
                <?php echo $custom_field_headers; ?>
            ],
            printColumns: combineCustomFieldsColumns([0, 2, 4, 6, 7, 8, 9], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 2, 4, 6, 7, 8, 9], '<?php echo $custom_field_headers; ?>'),
            summation: [{column: 7, dataType: 'currency', currencySymbol: currencySymbol}, {column: 8, dataType: 'currency', currencySymbol: currencySymbol}]
        });

        var arr = [];
        i = 0;
        $(document).on("change",".invoices_selected", function () {
            if($(this).prop("checked") == true){
                arr[i++] = $(this).val();
            }
            else if($(this).prop("checked") == false){
                    var index = arr.indexOf($(this).val()); // get index if value found otherwise -1

                 if (index > -1) { //if found
                   arr.splice(index, 1);
                 }
            }
            var filtered = arr.filter(function (el) {
              return el != null;
            });
            $('.multiple-invoices-btn').attr('data-post-invoices_id', filtered.toString());
            var ck_box = $('.invoices_selected:checked').length;
            if(ck_box == 0){
               
              $('.multiple-invoices-btn').attr('disabled', 'disabled');
            }
            else{
            $('.multiple-invoices-btn').removeAttr('disabled');   
            }
        });
    });
</script>
<link rel='stylesheet' type='text/css' href='https://garapp.azurewebsites.net/assets/js/summernote/summernote.css?v=2.1.1' /><script type='text/javascript'  src='https://garapp.azurewebsites.net/assets/js/summernote/summernote.min.js?v=2.1.1'></script>
