<div style=" margin: auto;">
    <?php
    $color = get_setting("invoice_color");
    if (!$color) {
        $color = "#2AA384";
    }
    $style = get_setting("invoice_style");
    ?>
    <?php
    $data = array(
        "client_info" => $client_info,
        "color" => $color,
        "estimate_info" => $estimate_info
    );
    if ($style === "style_2") {
        $this->load->view('estimates/estimate_parts/header_style_2.php', $data);
    } else {
        $this->load->view('estimates/estimate_parts/header_style_1.php', $data);
    }
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
    foreach ($estimate_items as $item) {
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
            <?php echo to_currency($estimate_total_summary->estimate_subtotal, $estimate_total_summary->currency_symbol); ?>
        </td>
    </tr>
    <?php if ($estimate_total_summary->tax) { ?>
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo $estimate_total_summary->tax_name; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($estimate_total_summary->tax, $estimate_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($estimate_total_summary->tax2) { ?>
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo $estimate_total_summary->tax_name2; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($estimate_total_summary->tax2, $estimate_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="text-align: right;"><?php echo lang("total"); ?></td>
        <td style="text-align: right; width: 20%; background-color: <?php echo $color; ?>; color: #fff;">
            <?php echo to_currency($estimate_total_summary->estimate_total, $estimate_total_summary->currency_symbol); ?>
        </td>
    </tr>
</table>

<br />
<br />
<div style="border-top: 2px solid #f2f2f2; color:#444;">
    <div><?php echo nl2br($estimate_info->note); ?></div>
</div>

<div style="margin-top: 15px;">
    <?php echo get_setting("estimate_footer"); ?>
</div>

