<?php echo form_open($paypal_url, array("id" => "paypal-payments-standard-checkout-form", "class" => "pull-left", "role" => "form")); ?>
<input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
<input type="hidden" name="payment_amount" value="<?php echo to_decimal_format($balance_due); ?>"  class="payment-amount-field" />

<input name="rm" value="2" type="hidden"/>
<input name="cmd" value="_xclick" type="hidden"/>
<input id="paypal-payments-standard-amount-field" name="amount" value="<?php echo $balance_due; ?>" type="hidden"/>
<input name="currency_code" value="<?php echo $currency; ?>" type="hidden"/>
<input name="business" value="<?php echo get_array_value($payment_method, "email"); ?>" type="hidden" />

<input name="return" value="<?php echo get_uri("invoices/preview/$invoice_id"); ?>" type="hidden"/>
<input name="cancel_return" value="<?php echo get_uri("invoices/preview/$invoice_id"); ?>" type="hidden"/>
<input name="notify_url" value="<?php echo get_array_value($payment_method, "paypal_ipn_url"); ?>" type="hidden"/>

<input name="quantity" value="1" type="hidden">
<input name="custom" value="invoice_id:<?php echo $invoice_info->id; ?>;contact_user_id:<?php echo $this->login_user->id; ?>;client_id:<?php echo $invoice_info->client_id; ?>;payment_method_id:<?php echo get_array_value($payment_method, "id"); ?>" type="hidden"/>
<input name="item_name" value="<?php echo get_invoice_id($invoice_info->id); ?>" type="hidden"/>
<input name="item_number" value="<?php echo $invoice_info->id; ?>" type="hidden"/>

<button id="paypal-payments-stundard-button" class="btn btn-primary"><?php echo get_array_value($payment_method, "pay_button_text"); ?></button>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var minimumPaymentAmount = "<?php echo get_array_value($payment_method, 'minimum_payment_amount'); ?>" * 1;
        if (!minimumPaymentAmount || isNaN(minimumPaymentAmount)) {
            minimumPaymentAmount = 1;
        }

        $("#payment-amount").change(function () {
            //change paypal payment amount
            var value = unformatCurrency($(this).val());

            $("#paypal-payments-standard-amount-field").val(value);

            //check minimum payment amount and show/hide payment button
            if (value < minimumPaymentAmount) {
                $("#paypal-payments-stundard-button").hide();
            } else {
                $("#paypal-payments-stundard-button").show();
            }
        });

        $("#paypal-payments-stundard-button").click(function () {

            //show an error message if user attempt to pay more than the invoice due and exit
            if (unformatCurrency($("#payment-amount").val()) > "<?php echo $balance_due; ?>") {
                appAlert.error("<?php echo lang("invoice_over_payment_error_message"); ?>");
                return false;
            }

            $(this).addClass("inline-loader").addClass("btn-default").removeClass("btn-primary");
        });



    });
</script>