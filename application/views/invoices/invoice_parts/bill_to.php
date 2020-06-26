<div class="form-group">
    <label for="invoice_client_id" class=" col-md-3">Change Address</label>
    <div class="col-md-9">
        <select id="address_choose" class="form-control">
            <option <?php if($client_info->bill_address_selected == '' || $client_info->bill_address_selected == 0) echo "selected"; ?> value="0">Defaullt Address</option>
            <option <?php if($client_info->bill_address_selected == 1) echo "selected"; ?> value="1">Bill Address</option>
        </select>
    </div>
</div>
<br>
<div><br><b><?php echo lang("bill_to"); ?></b></div>
<div style="line-height: 2px; border-bottom: 1px solid #f2f2f2;"> </div>
<div style="line-height: 3px;"> </div>
<strong><span id="company_name"><?php

if($client_info->bill_address_selected == '') {
    echo $client_info->company_name;
}
else{
    echo $client_info->bill_name;
}
?> </span></strong>


<div style="line-height: 3px;"> </div>

<span id="invoice-meta-client-address" class="invoice-meta" style="font-size: 90%; color: #666;">
    <?php if ($client_info->address || (isset($client_info->custom_fields) && $client_info->custom_fields)) {
        if($client_info->bill_address_selected == '' || $client_info->bill_address_selected == 0) {
            ?>
            <div><?php echo nl2br($client_info->address); ?>
            <?php if ($client_info->city) { ?>
                <br /><?php echo $client_info->city; ?>
            <?php } ?>
            <?php if ($client_info->state) { ?>
                <br /><?php echo $client_info->state; ?>
            <?php } ?>
            <?php if ($client_info->zip) { ?>
                <br /><?php echo $client_info->zip; ?>
            <?php } ?>
            <?php if ($client_info->country) { ?>
                <br /><?php echo $client_info->country; ?>
            <?php } ?>
            <?php if ($client_info->vat_number) { ?>
                <br /><?php echo lang("vat_number") . ": " . $client_info->vat_number; ?>
            <?php } ?>
            
            <?php
            if (isset($client_info->custom_fields) && $client_info->custom_fields) {
                foreach ($client_info->custom_fields as $field) {
                    if ($field->value) {
                        echo "<br />" . $field->custom_field_title . ": " . $this->load->view("custom_fields/output_" . $field->custom_field_type, array("value" => $field->value), true);
                    }
                }
            }
            ?>


        </div>
            <?php
        }
        else{
            if($client_info->bill_address_selected == 1) {
                    if ($client_info->bill_address) { ?>
                        <br /><?php echo $client_info->bill_address; ?>
                    <?php }
            }
        }
     ?>
        
<?php }
    
 ?>
</span>