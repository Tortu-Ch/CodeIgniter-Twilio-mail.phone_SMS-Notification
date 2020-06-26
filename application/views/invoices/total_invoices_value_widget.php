<?php
$panel = "";
$icon = "";
$value = "";
$lang = "";

if ($type == "invoices") {
    $lang = lang("invoice_value");
    $panel = "panel-primary";
    $icon = "fa-file-text";
    $value = to_currency($invoices_info->invoices_total);
} else if ($type == "payments") {
    $lang = lang("payments");
    $panel = "panel-success";
    $icon = "fa-check-square";
    $value = to_currency($invoices_info->payments_total);
} else if ($type == "due") {
    $lang = lang("due");
    $panel = "panel-coral";
    $icon = "fa-money";
    $value = to_currency(ignor_minor_value($invoices_info->due));
}
?>

<div class="panel <?php echo $panel ?>">
    <div class="panel-body ">
        <div class="widget-icon">
            <i class="fa <?php echo $icon; ?>"></i>
        </div>
        <div class="widget-details">
            <h1><?php echo $value; ?></h1>
            <?php echo $lang; ?>
        </div>
    </div>
</div>