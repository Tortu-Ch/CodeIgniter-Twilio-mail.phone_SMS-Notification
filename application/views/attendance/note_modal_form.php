<?php
$url = "attendance/save_note";

if ($clock_out == "1") {
    $url = "attendance/log_time";
}

echo form_open(get_uri($url), array("id" => "attendance-note-form", "class" => "general-form", "role" => "form"));
?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="form-group">
        <label for="note" class=" col-md-12"><?php echo lang('note'); ?></label>
        <div class=" col-md-12">
            <?php
            echo form_textarea(array(
                "id" => "note",
                "name" => "note",
                "class" => "form-control",
                "placeholder" => lang('note'),
                "value" => $model_info->note,
            ));
            ?>
        </div>
        <input name="clock_out" type="hidden" value="<?php echo $clock_out; ?>" />
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#attendance-note-form").appForm({
            onSuccess: function (result) {
                if (result.clock_widget) {
                   $("#timecard-clock-out").closest("#js-clock-in-out").html(result.clock_widget);
                } else {
                    if (result.isUpdate) {
                        $(".dataTable:visible").appTable({newData: result.data, dataId: result.id});
                    } else {
                        $(".dataTable:visible").appTable({reload: true});
                    }
                }
            }
        });

        $("#note").focus();
    });
</script>