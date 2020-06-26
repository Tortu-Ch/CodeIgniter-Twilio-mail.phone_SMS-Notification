<div class="modal-body clearfix">

    <?php echo form_open(get_uri("custom_fields/save"), array("id" => "custom-field-form", "class" => "general-form", "role" => "form")); ?>

    <input type="hidden" name="related_to" value="<?php echo $related_to; ?>" />
    <?php $this->load->view("custom_fields/form/input_fields"); ?>

    <?php if ($related_to != "events") { ?>
        <div class="form-group">
            <label for="show_in_table" class=" col-md-3"><?php echo lang('show_in_table'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_checkbox(
                        "show_in_table", "1", $model_info->show_in_table, "id='show_in_table'"
                );
                ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($related_to === "clients" || $related_to === "invoices") { ?>
        <div class="form-group">
            <label for="show_in_invoice" class=" col-md-3"><?php echo lang('show_in_invoice'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_checkbox(
                        "show_in_invoice", "1", $model_info->show_in_invoice, "id='show_in_invoice'"
                );
                ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($related_to === "estimates") { ?>
        <div class="form-group">
            <label for="show_in_estimate" class="col-md-3"><?php echo lang('show_in_estimate'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_checkbox(
                        "show_in_estimate", "1", $model_info->show_in_estimate, "id='show_in_estimate'"
                );
                ?>
            </div>
        </div>
    <?php } ?>


    <?php if ($related_to != "events") { ?>
        <div class="form-group" id="visible_to_admins_only_container">
            <label for="visible_to_admins_only" class=" col-md-3"><?php echo lang('visible_to_admins_only'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_checkbox(
                        "visible_to_admins_only", "1", $model_info->visible_to_admins_only, "id='visible_to_admins_only'"
                );
                ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($related_to === "clients" || $related_to === "contacts" || $related_to === "projects" || $related_to === "tasks" || $related_to === "tickets" || $related_to === "invoices" || $related_to === "estimates") { ?>
        <div class="form-group" id="hide_from_clients_container">
            <label for="hide_from_clients" class=" col-md-3"><?php echo lang('hide_from_clients'); ?></label>
            <div class="col-md-9">
                <?php
                echo form_checkbox(
                        "hide_from_clients", "1", $model_info->hide_from_clients, "id='hide_from_clients'"
                );
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
            <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>

    <?php echo form_close(); ?>

</div>



<script type="text/javascript">
    $(document).ready(function () {

        $("#custom-field-form").appForm({
            onSuccess: function (result) {
                window.location = "<?php echo get_uri("custom_fields/view/" . $related_to); ?>";
            }
        });

        showHideFields();
        $("#show_in_invoice, #visible_to_admins_only, #show_in_estimate").click(function () {
            showHideFields();
        });


        function showHideFields() {

            $("#hide_from_clients_container").show();
            $("#visible_to_admins_only_container").show();

            //if any field is visible to invoice, then it'll be availab for non-admins and clients
            if ($("#show_in_invoice").is(":checked")) {
                $("#hide_from_clients_container").hide();
                $("#visible_to_admins_only_container").hide();
            }

            if ($("#visible_to_admins_only").is(":checked")) {
                $("#hide_from_clients_container").hide();
            }

            if ($("#show_in_estimate").is(":checked")) {
                $("#hide_from_clients_container").hide();
                $("#visible_to_admins_only_container").hide();
            }
        }


    });
</script>