<?php echo form_open(get_uri("todo/save"), array("id" => "todo-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <div class="col-md-12">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "value" => $model_info->title,
                "class" => "form-control notepad-title",
                "placeholder" => lang('title'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="notepad">
                <?php
                echo form_textarea(array(
                    "id" => "description",
                    "name" => "description",
                    "value" => $model_info->description,
                    "class" => "form-control",
                    "placeholder" => lang('description') . "...",
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="notepad">
                <?php
                echo form_input(array(
                    "id" => "todo_labels",
                    "name" => "labels",
                    "value" => $model_info->labels,
                    "class" => "form-control",
                    "placeholder" => lang('labels')
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <?php
            echo form_input(array(
                "id" => "start_date",
                "name" => "start_date",
                "value" => is_date_exists($model_info->start_date) ? $model_info->start_date : "",
                "class" => "form-control",
                "placeholder" => lang('date')
            ));
            ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#todo-form").appForm({
            onSuccess: function (result) {
                $("#todo-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $("#title").focus();
        $("#todo_labels").select2({
            tags: <?php echo json_encode($label_suggestions); ?>,
            'minimumInputLength': 0
        });

        setDatePicker("#start_date");
    });
</script>    