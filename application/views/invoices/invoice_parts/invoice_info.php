<span style="font-size:20px; font-weight: bold;background-color: <?php echo $color; ?>; color: #fff;">&nbsp;<?php echo get_invoice_id($invoice_info->id); ?>&nbsp;</span>
<div style="line-height: 10px;"></div><?php
if (isset($invoice_info->custom_fields) && $invoice_info->custom_fields) {
    foreach ($invoice_info->custom_fields as $field) {
        if ($field->value) {
            echo "<span>" . $field->custom_field_title . ": " . $this->load->view("custom_fields/output_" . $field->custom_field_type, array("value" => $field->value), true) . "</span><br />";
        }
    }
}
?>
<span><?php echo lang("bill_date") . ": " . format_to_date($invoice_info->bill_date, false); ?></span><br />
<span><?php echo lang("due_date") . ": " . format_to_date($invoice_info->due_date, false); ?></span>