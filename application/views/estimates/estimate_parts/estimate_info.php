<span style="font-size:20px; font-weight: bold;background-color: <?php echo $color; ?>; color: #fff;">&nbsp;<?php echo get_estimate_id($estimate_info->id); ?>&nbsp;</span>
<div style="line-height: 10px;"></div><?php
if (isset($estimate_info->custom_fields) && $estimate_info->custom_fields) {
    foreach ($estimate_info->custom_fields as $field) {
        if ($field->value) {
            echo "<span>" . $field->custom_field_title . ": " . $this->load->view("custom_fields/output_" . $field->custom_field_type, array("value" => $field->value), true) . "</span><br />";
        }
    }
}
?>
<span><?php echo lang("estimate_date") . ": " . format_to_date($estimate_info->estimate_date, false); ?></span><br />
<span><?php echo lang("valid_until") . ": " . format_to_date($estimate_info->valid_until, false); ?></span>