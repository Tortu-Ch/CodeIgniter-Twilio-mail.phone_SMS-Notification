<table id="invoice-item-table" class="table display dataTable text-right strong table-responsive">
    <tr>
        <td><?php echo lang("sub_total"); ?></td>
        <td style="width: 120px;"><?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?></td>
        <td style="width: 100px;"> </td>
    </tr>

    <?php
    $discount_row = "<tr>
                        <td style='padding-top:13px;'>" . lang("discount") . "</td>
                        <td style='padding-top:13px;'>" . to_currency($invoice_total_summary->discount_total, $invoice_total_summary->currency_symbol) . "</td>
                        <td class='text-center option w100'>" . modal_anchor(get_uri("invoices/discount_modal_form"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "data-post-invoice_id" => $invoice_id, "title" => lang('edit_discount'))) . "<span class='p20'>&nbsp;&nbsp;&nbsp;</span></td>
                    </tr>";

    if ($invoice_total_summary->invoice_subtotal && (!$invoice_total_summary->discount_total || ($invoice_total_summary->discount_total !== 0 && $invoice_total_summary->discount_type == "before_tax"))) {
        //when there is discount and type is before tax or no discount
        echo $discount_row;
    }
    ?>

    <?php if ($invoice_total_summary->tax) { ?>
        <tr>
            <td><?php echo $invoice_total_summary->tax_name; ?></td>
            <td><?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?></td>
            <td></td>
        </tr>
    <?php } ?>
    <?php if ($invoice_total_summary->tax2) { ?>
        <tr>
            <td><?php echo $invoice_total_summary->tax_name2; ?></td>
            <td><?php echo to_currency($invoice_total_summary->tax2, $invoice_total_summary->currency_symbol); ?></td>
            <td></td>
        </tr>
    <?php } ?>
    <?php
    if ($invoice_total_summary->discount_total && $invoice_total_summary->discount_type == "after_tax") {
        //when there is discount and type is after tax
        echo $discount_row;
    }
    ?>
    <?php if ($invoice_total_summary->total_paid) { ?>
        <tr>
            <td><?php echo lang("paid"); ?></td>
            <td><?php echo to_currency($invoice_total_summary->total_paid, $invoice_total_summary->currency_symbol); ?></td>
            <td></td>
        </tr>
    <?php } ?>
    <tr>
        <td><?php echo lang("balance_due"); ?></td>
        <td><?php echo to_currency($invoice_total_summary->balance_due, $invoice_total_summary->currency_symbol); ?></td>
        <td></td>
    </tr>
</table>