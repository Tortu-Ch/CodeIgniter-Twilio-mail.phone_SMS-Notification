<div class="form-group">
    <label for="note" class=" col-md-3"><?php echo lang('note'); ?></label>
    <div class=" col-md-9">
        <?php
        echo form_textarea(array(
            "id" => "note",
            "name" => "note",
            "value" => $model_info->note ? $model_info->note : "",
            "class" => "form-control",
            "placeholder" => lang('note')
        ));
        ?>
    </div>
</div>