<?php
$label_column = isset($label_column) ? $label_column : "col-md-3";
$field_column = isset($field_column) ? $field_column : "col-md-9";

foreach ($custom_fields as $field) {
    ?>
    <div class="form-group ">
        <label  class="<?php echo $label_column; ?>"><?php echo $field->title; ?></label>

        <div class="<?php echo $field_column; ?>">
            <?php
            $this->load->view("custom_fields/input_" . $field->field_type, array("field_info" => $field))
            ?> 
        </div>
    </div>
<?php } ?>