<?php
$company_address = nl2br(get_setting("company_address"));
$company_phone = get_setting("company_phone");
$company_website = get_setting("company_website");
?><div><b><?php echo get_setting("company_name"); ?></b></div>
<div style="line-height: 3px;"> </div>
<span class="invoice-meta" style="font-size: 90%; color: #666;"><?php
    if ($company_address) {
        echo $company_address;
    }
    ?>
    <?php if ($company_phone) { ?>
        <div style="line-height: 1px;"> </div>
        <br /><?php echo lang("phone") . ": " . $company_phone; ?>
    <?php } ?>
    <?php if ($company_website) { ?>
        <div style="line-height: 2px;"> </div>
        <br /><?php echo lang("website"); ?>: <a style="color:#666; text-decoration: none;" href="<?php echo $company_website; ?>"><?php echo $company_website; ?></a>
    <?php } ?>
</span>