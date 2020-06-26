<div class="modal-body clearfix general-form">
    <div class="form-group">
        <div  class="col-md-12 notepad-title">
            <strong><?php echo $model_info->title; ?></strong>
        </div>
    </div>

    <div class="col-md-12 mb15">
        <?php
        $note_labels = "";
        $date = "";
        $labels = explode(",", $model_info->labels);
        foreach ($labels as $label) {
            $note_labels.="<span class='label label-info mr10'>" . $label . "</span>";
        }

        if (is_date_exists($model_info->start_date)) {
            $date = format_to_date($model_info->start_date, false);
        }

        echo $note_labels . " " . $date;
        ?>
    </div>

    <?php if ($model_info->description) { ?>
        <div class="col-md-12 mb15 notepad">
            <?php
            echo nl2br(link_it($model_info->description));
            ?>
        </div>
    <?php } ?>


</div>

<div class="modal-footer">
    <?php
    echo modal_anchor(get_uri("todo/modal_form/"), "<i class='fa fa-pencil'></i> " . lang('edit'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => lang('edit')));
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>