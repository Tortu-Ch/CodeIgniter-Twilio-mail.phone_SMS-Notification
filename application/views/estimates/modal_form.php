<?php echo form_open(get_uri("estimates/save"), array("id" => "estimate-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="estimate_date" class=" col-md-3"><?php echo lang('estimate_date'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "estimate_date",
                "name" => "estimate_date",
                "value" => $model_info->estimate_date,
                "class" => "form-control",
                "placeholder" => lang('estimate_date'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="valid_until" class=" col-md-3"><?php echo lang('valid_until'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "valid_until",
                "name" => "valid_until",
                "value" => $model_info->valid_until,
                "class" => "form-control",
                "placeholder" => lang('valid_until'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-greaterThanOrEqual" => "#estimate_date",
                "data-msg-greaterThanOrEqual" => lang("end_date_must_be_equal_or_greater_than_start_date")
            ));
            ?>
        </div>
    </div>
    <?php if ($client_id) { ?>
        <input type="hidden" name="estimate_client_id" value="<?php echo $client_id; ?>" />
    <?php } else { ?>
        <div class="form-group">
            <label for="estimate_client_id" class=" col-md-3"><?php echo lang('client'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_dropdown("estimate_client_id", $clients_dropdown, array($model_info->client_id), "class='select2 validate-hidden' id='estimate_client_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                ?>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="tax_id" class=" col-md-3"><?php echo lang('tax'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_dropdown("tax_id", $taxes_dropdown, array($model_info->tax_id), "class='select2 tax-select2'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="tax_id" class=" col-md-3"><?php echo lang('second_tax'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_dropdown("tax_id2", $taxes_dropdown, array($model_info->tax_id2), "class='select2 tax-select2'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="estimate_note" class=" col-md-3"><?php echo lang('note'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "estimate_note",
                "name" => "estimate_note",
                "value" => $model_info->note ? $model_info->note : "",
                "class" => "form-control",
                "placeholder" => lang('note')
            ));
            ?>
        </div>
    </div>

    <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?> 

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-form").appForm({
            onSuccess: function (result) {
                if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else {
                    window.location = "<?php echo site_url('estimates/view'); ?>/" + result.id;
                }
            }
        });
        $("#estimate-form .tax-select2").select2();
        $("#estimate_client_id").select2();

        setDatePicker("#estimate_date, #valid_until");


    });
</script>