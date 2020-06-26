<?php echo form_open(get_uri("invoice_payments/save_payment"), array("id" => "invoice-payment-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
    <div class="form-group">
        <label for="invoice_payment_method_id" class=" col-md-3"><?php echo lang('payment_method'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_dropdown("invoice_payment_method_id", $payment_methods_dropdown, array($model_info->payment_method_id), "class='select2'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_payment_date" class=" col-md-3"><?php echo lang('payment_date'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_payment_date",
                "name" => "invoice_payment_date",
                "value" => $model_info->payment_date,
                "class" => "form-control",
                "placeholder" => lang('payment_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="invoice_payment_amount" class=" col-md-3"><?php echo lang('amount'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_payment_amount",
                "name" => "invoice_payment_amount",
                "value" => $model_info->amount ? to_decimal_format($model_info->amount) : "",
                "class" => "form-control",
                "placeholder" => lang('amount'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_payment_note" class="col-md-3"><?php echo lang('note'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "invoice_payment_note",
                "name" => "invoice_payment_note",
                "value" => $model_info->note ? $model_info->note : "",
                "class" => "form-control",
                "placeholder" => lang('description')
            ));
            ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#invoice-payment-form").appForm({
            onSuccess: function(result) {
                $("#invoice-payment-table").appTable({newData: result.data, dataId: result.id});
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                     updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });
        $("#invoice-payment-form .select2").select2();
        
        setDatePicker("#invoice_payment_date");
     
    });
</script>