<div style=" margin: auto;">
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

    $discount_row = "<tr>
                        <td colspan='3' style='text-align: right;'>" . lang("discount") . "</td>
                        <td style='text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;'> " . to_currency($invoice_total_summary->discount_total, $invoice_total_summary->currency_symbol) . "</td>
                    </tr>";
    ?>
</div>

<br />

<table style="width: 100%; color: #444;">            
    <tr style="font-weight: bold; background-color: <?php echo $color; ?>; color: #fff;  ">
        <th style="width: 45%; border-right: 1px solid #eee;"> <?php echo lang("item"); ?> </th>
        <th style="text-align: center;  width: 15%; border-right: 1px solid #eee;"> <?php echo lang("quantity"); ?></th>
        <th style="text-align: right;  width: 20%; border-right: 1px solid #eee;"> <?php echo lang("rate"); ?></th>
        <th style="text-align: right;  width: 20%; "> <?php echo lang("total"); ?></th>
    </tr>
    <?php
    foreach ($invoice_items as $item) {
        ?>
        <tr style="background-color: #f4f4f4; ">
            <td style="width: 45%; border: 1px solid #fff; padding: 10px;"><?php echo $item->title; ?>
                <br />
                <span style="color: #888; font-size: 90%;"><?php echo nl2br($item->description); ?></span>
            </td>
            <td style="text-align: center; width: 15%; border: 1px solid #fff;"> <?php echo $item->quantity . " " . $item->unit_type; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff;"> <?php echo to_currency($item->rate, $item->currency_symbol); ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff;"> <?php echo to_currency($item->total, $item->currency_symbol); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="text-align: right;"><?php echo lang("total"); ?></td>
        <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
            <?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?>
        </td>
    </tr>
    <?php
    if ($invoice_total_summary->discount_total && $invoice_total_summary->discount_type == "before_tax") {
        echo $discount_row;
    }
    ?>    
    <?php if ($invoice_total_summary->tax) { ?>
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo $invoice_total_summary->tax_name; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($invoice_total_summary->tax2) { ?>
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo $invoice_total_summary->tax_name2; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->tax2, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <?php
    if ($invoice_total_summary->discount_total && $invoice_total_summary->discount_type == "after_tax") {
        echo $discount_row;
    }
    ?> 
    <?php if ($invoice_total_summary->total_paid) { ?>     
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo lang("paid"); ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->total_paid, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="text-align: right;"><?php echo lang("balance_due"); ?></td>
        <td style="text-align: right; width: 20%; background-color: <?php echo $color; ?>; color: #fff;">
            <?php echo to_currency($invoice_total_summary->balance_due, $invoice_total_summary->currency_symbol); ?>
        </td>
    </tr>
</table>
<?php if ($invoice_info->note) { ?>
    <br />
    <br />
    <div style="border-top: 2px solid #f2f2f2; color:#444; padding:0 0 20px 0;"><br /><?php echo nl2br($invoice_info->note); ?></div>
<?php } else { ?> <!-- use table to avoid extra spaces -->
    <br /><br /><table style="border-top: 2px solid #f2f2f2; margin: 0; padding: 0; display: block; width: 100%; height: 10px;"></table>
<?php } ?>
<span style="color:#444; line-height: 14px;">
    <?php echo get_setting("invoice_footer"); ?>
</span>

