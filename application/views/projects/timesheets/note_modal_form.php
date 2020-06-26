<?php echo form_open(get_uri("projects/save_timelog_note/"), array("id" => "timesheet-note-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <?php if ($this->login_user->user_type === "staff") { ?>
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
        <?php
        } else {
            //show preview
            echo nl2br($model_info->note);
        }
        ?>      
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <?php if ($this->login_user->user_type === "staff") { ?>
        <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
<?php } ?>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#timesheet-note-form").appForm({
            onSuccess: function (result) {
                $(".dataTable:visible").appTable({newData: result.data, dataId: result.id});
            }
        });

        $("#note").focus();
    });
</script>