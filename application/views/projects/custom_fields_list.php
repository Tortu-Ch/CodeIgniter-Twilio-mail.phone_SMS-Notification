<?php
if (count($custom_fields_list)) {
    $fields = "";
    foreach ($custom_fields_list as $data) {
        if ($data->value) {
            $fields.= "<div class='p10'><i class='fa fa-cube'></i> $data->title </div>";
            $fields.="<div class='p10 pt0 b-b ml15'>" . $this->load->view("custom_fields/output_" . $data->field_type, array("value" => $data->value), true) . "</div>";
        }
    }
    if ($fields) {
        ?>

        <div class="panel">
            <div class="pnel-body no-padding">
                <?php
                echo $fields;
                ?>
            </div>
        </div>

        <?php
    }
}
?>