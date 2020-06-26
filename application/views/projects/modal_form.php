<?php echo form_open(get_uri("projects/save"), array("id" => "project-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="estimate_id" value="<?php echo $model_info->estimate_id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
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
    <?php if ($client_id) { ?>
        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
    <?php } else { ?>
        <div class="form-group">
            <label for="client_id" class=" col-md-3"><?php echo lang('client'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_dropdown("client_id", $clients_dropdown, array($model_info->client_id), "class='select2 validate-hidden' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                ?>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="description" class=" col-md-3"><?php echo lang('description'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => $model_info->description,
                "class" => "form-control",
                "placeholder" => lang('description'),
                "style" => "height:150px;",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="start_date" class=" col-md-3"><?php echo lang('start_date'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                "class" => "form-control",
                "placeholder" => lang('start_date')
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="deadline" class=" col-md-3"><?php echo lang('deadline'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "deadline",
                "name" => "deadline",
                "value" => is_date_exists($model_info->deadline) ? $model_info->deadline : "",
                "class" => "form-control",
                "placeholder" => lang('deadline')
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="price" class=" col-md-3"><?php echo lang('price'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "price",
                "name" => "price",
                "value" => $model_info->price ? to_decimal_format($model_info->price) : "",
                "class" => "form-control",
                "placeholder" => lang('price')
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="project_labels" class=" col-md-3"><?php echo lang('labels'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "project_labels",
                "name" => "labels",
                "value" => $model_info->labels,
                "class" => "form-control",
                "placeholder" => lang('labels')
            ));
            ?>
        </div>
    </div>

    <?php if ($model_info->id) { ?>
        <div class="form-group">
            <label for="status" class=" col-md-3"><?php echo lang('status'); ?></label>
            <div class=" col-md-9">
                <?php
                echo form_dropdown("status", array("open" => lang("open"), "completed" => lang("completed"), "hold" => lang("hold"), "canceled" => lang("canceled")), array($model_info->status), "class='select2'");
                ?>
            </div>
        </div>
    <?php } ?>

    <?php $this->load->view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?>


</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#project-form").appForm({
            onSuccess: function (result) {
                if (typeof RELOAD_PROJECT_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_PROJECT_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    RELOAD_VIEW_AFTER_UPDATE = false;
                    window.location = "<?php echo site_url('projects/view'); ?>/" + result.id;
                } else {
                    $("#project-table").appTable({newData: result.data, dataId: result.id});
                }
            }
        });
        $("#title").focus();
        $("#project-form .select2").select2();

        setDatePicker("#start_date, #deadline");

        $("#project_labels").select2({
            tags: <?php echo json_encode($label_suggestions); ?>
        });
    });
</script>