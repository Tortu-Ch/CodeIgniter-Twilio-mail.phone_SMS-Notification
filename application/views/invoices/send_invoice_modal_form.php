<?php echo form_open(get_uri("invoices/send_invoice"), array("id" => "send-invoice-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $invoice_info->id; ?>" />

    <div class="form-group">
        <label for="contact_id" class=" col-md-3"><?php echo lang('to'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_dropdown("contact_id", $contacts_dropdown, array(), "class='select2 validate-hidden' id='contact_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_cc" class=" col-md-3">CC</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_cc",
                "name" => "invoice_cc",
                "value" => "",
                "class" => "form-control",
                "placeholder" => "CC"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="invoice_bcc" class=" col-md-3">BCC</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_bcc",
                "name" => "invoice_bcc",
                "value" => "",
                "class" => "form-control",
                "placeholder" => "BCC"
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="subject" class=" col-md-3"><?php echo lang("subject"); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "subject",
                "name" => "subject",
                "value" => $subject,
                "class" => "form-control",
                "placeholder" => lang("subject")
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class=" col-md-12">
            <?php
            echo form_textarea(array(
                "id" => "message",
                "name" => "message",
                "value" => $message,
                "class" => "form-control"
            ));
            ?>
        </div>
    </div>
    <div class="form-group ml15">
        <i class='fa fa-check-circle' style="color: #5CB85C;"></i> <?php echo lang('attached') . ' ' . anchor(get_uri("invoices/download_pdf/" . $invoice_info->id), lang("invoice") . "-$invoice_info->id.pdf", array("target" => "_blank")); ?> 
    </div>

</div>


<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-send"></span> <?php echo lang('send'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#send-invoice-form .select2').select2();
        $("#send-invoice-form").appForm({
            beforeAjaxSubmit: function (data) {
                var custom_message = encodeAjaxPostData(getWYSIWYGEditorHTML("#message"));
                $.each(data, function (index, obj) {
                    if (obj.name === "message") {
                        data[index]["value"] = custom_message;
                    }
                });
            },
            onSuccess: function (result) {
                if (result.success) {
                    appAlert.success(result.message, {duration: 10000});
                    if (typeof updateInvoiceStatusBar == 'function') {
                        updateInvoiceStatusBar(result.invoice_id);
                    }

                } else {
                    appAlert.error(result.message);
                }
            }
        });

        initWYSIWYGEditor("#message", {height: 400, toolbar: []});

    });
</script>