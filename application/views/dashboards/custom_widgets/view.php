<?php load_js(array("assets/js/bootstrap-confirmation/bootstrap-confirmation.js")); ?>

<div class="modal-body clearfix general-form">
    <div class="form-group">
        <div  class="col-md-12">
            <strong><?php echo $model_info->title; ?></strong>
        </div>
    </div>
    <div class="col-md-12 mb15">
        <?php echo $model_info->content; ?>
    </div>

</div>

<div class="modal-footer">
    <?php
    echo js_anchor("<i class='fa fa-times-circle-o'></i> " . lang('delete_widget'), array("class" => "btn btn-default pull-left", "id" => "delete_widget"));

    echo modal_anchor(get_uri("dashboard/custom_widget_modal_form/" . $model_info->id), "<i class='fa fa-pencil'></i> " . lang('edit_widget'), array("class" => "btn btn-default", "title" => lang('edit_widget')));
    ?>
    <button type="button" class="btn btn-default close-modal" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>

<?php $this->load->view("dashboards/helper_js"); ?>

<script>
    $(document).ready(function () {

        $('#delete_widget').confirmation({
            title: "<?php echo lang('are_you_sure'); ?>",
            btnOkLabel: "<?php echo lang('yes'); ?>",
            btnCancelLabel: "<?php echo lang('no'); ?>",
            onConfirm: function () {
                $('.close-modal').trigger("click");
                $.ajax({
                    url: "<?php echo get_uri('dashboard/delete_custom_widgets') ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {id: <?php echo $model_info->id; ?>},
                    success: function (result) {
                        if (result.success) {
                            var $widgetRow = $(".js-widget-container, #widget-column-container").find('[data-value="' + result.id + '"]');
                            $widgetRow.fadeOut(300, function () {
                                $widgetRow.remove();
                            });

                            setTimeout(function () {
                                addEmptyAreaText($widgetRow.closest("div.add-column-panel"));
                                saveWidgetPosition();
                            }, 300);

                            appAlert.warning(result.message, {duration: 10000});
                        } else {
                            appAlert.error(result.message);
                        }
                    }
                });

            }
        });

    });
</script>