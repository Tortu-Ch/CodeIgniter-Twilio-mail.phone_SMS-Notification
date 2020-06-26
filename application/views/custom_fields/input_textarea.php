<?php

echo form_textarea(array(
    "id" => "custom_field_" . $field_info->id,
    "name" => "custom_field_" . $field_info->id,
    "value" => isset($field_info->value) ? $field_info->value : "",
    "class" => "form-control",
    "placeholder" => $field_info->placeholder,
    "data-rule-required" => $field_info->required ? true : false,
    "data-msg-required" => lang("field_required"),
));
