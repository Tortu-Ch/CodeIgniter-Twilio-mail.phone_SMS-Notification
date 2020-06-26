<?php echo form_open(get_uri("invoices/save_discount"), array("id" => "discount-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="invoice_id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="discount_type" class="col-md-3"><?php echo lang('discount_type'); ?></label>
        <div class="col-md-9">
            <?php
            $discount_type_dropdown = array("before_tax" => lang("before_tax"), "after_tax" => lang("after_tax"));
            echo form_dropdown("discount_type", $discount_type_dropdown, $model_info->discount_type, "class='select2'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="discount" class="col-md-3"><?php echo lang('discount'); ?></label>
        <div class="col-md-4">
            <?php
            echo form_input(array(
                "id" => "discount",
                "name" => "discount_amount",
                "value" => $model_info->discount_amount ? $model_info->discount_amount : "",
                "class" => "form-control",
                "autofocus" => "true",
                "placeholder" => lang('discount'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
        <div class="col-md-5">
            <?php
            $discount_percentage_dropdown = array("percentage" => lang("percentage"), "fixed_amount" => lang("fixed_amount"));
            echo form_dropdown("discount_amount_type", $discount_percentage_dropdown, $model_info->discount_amount_type, "class='select2'");
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
    $(document).ready(function () {
        $("#discount-form").appForm({
            onSuccess: function (result) {
                if (result.success && result.invoice_total_view) {
                    $("#invoice-total-section").html(result.invoice_total_view);
                } else {
                    appAlert.error(result.message);
                }
            }
        });

        $("#discount-form .select2").select2();
    });

</script>