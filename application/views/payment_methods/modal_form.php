<?php echo form_open(get_uri("payment_methods/save"), array("id" => "payment-method-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-4"><?php echo lang('title'); ?></label>
        <div class=" col-md-8">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "value" => $model_info->title,
                "class" => "form-control",
                "placeholder" => lang('title'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-md-4"><?php echo lang('description'); ?></label>
        <div class=" col-md-8">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => $model_info->description,
                "class" => "form-control",
                "placeholder" => lang('description'),
            ));
            ?>
        </div>
    </div>
    <?php if ($model_info->online_payable == 1) { ?>
        <div class="form-group">
            <label for="available_on_invoice" class="col-md-4"><?php echo lang('available_on_invoice'); ?>
                <span class="help" data-toggle="tooltip" title="<?php echo lang('available_on_invoice_help_text'); ?>"><i class="fa fa-question-circle"></i></span>
            </label>
            <div class="col-md-8">
                <?php
                echo form_checkbox("available_on_invoice", "1", $model_info->available_on_invoice, "id='available_on_invoice'");
                ?> 
            </div>
        </div>
        <div class="form-group">
            <label for="minimum_payment_amount" class="col-md-4"><?php echo lang('minimum_payment_amount'); ?>
                <span class="help" data-toggle="tooltip" title="<?php echo lang('minimum_payment_amount_help_text'); ?>"><i class="fa fa-question-circle"></i></span>
            </label>
            <div class="col-md-8">
                <?php
                echo form_input(array(
                    "id" => "minimum_payment_amount",
                    "name" => "minimum_payment_amount",
                    "value" => $model_info->minimum_payment_amount ? to_decimal_format($model_info->minimum_payment_amount) : 0,
                    "class" => "form-control",
                    "placeholder" => lang('minimum_payment_amount')
                ));
                ?>
            </div>
        </div>
        <?php
        if (count($settings)) {
            foreach ($settings as $setting) {
                ?>

                <div class="form-group">
                    <label for="<?php echo get_array_value($setting, "name"); ?>" class="col-md-4"><?php
                        echo get_array_value($setting, "text");
                        if (get_array_value($setting, "help_text")) {
                            ?>
                            <span class="help" data-toggle="tooltip" title="<?php echo get_array_value($setting, "help_text"); ?>"><i class="fa fa-question-circle"></i></span>
                        <?php }
                        ?>

                    </label>
                    <div class="col-md-8">
                        <?php
                        $field_type = get_array_value($setting, "type");
                        $setting_name = get_array_value($setting, "name");

                        if ($field_type == "text") {
                            echo form_input(array(
                                "id" => $setting_name,
                                "name" => $setting_name,
                                "value" => $model_info->$setting_name,
                                "class" => "form-control",
                                "placeholder" => get_array_value($setting, "text"),
                                "data-rule-required" => true,
                                "data-msg-required" => lang("field_required")
                            ));
                        } else if ($field_type == "boolean") {
                            echo form_checkbox($setting_name, "1", $model_info->$setting_name == "1" ? true : false, "id='$setting_name'");
                        } else if ($field_type == "readonly") {
                            echo $model_info->$setting_name;
                        }
                        ?> 
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#payment-method-form").appForm({
            onSuccess: function(result) {
                $("#payment-method-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $("#title").focus();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>    