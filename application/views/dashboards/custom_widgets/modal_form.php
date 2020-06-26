<?php echo form_open(get_uri("dashboard/save_custom_widget"), array("id" => "custom_widget-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "class" => "form-control",
                "placeholder" => lang("title"),
                "value" => $model_info->title,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class=" col-md-3"><?php echo lang('content'); ?></label>
        <div class=" col-md-9">
            <div class="notepad">
                <?php
                echo form_textarea(array(
                    "name" => "content",
                    "value" => $model_info->content,
                    "class" => "form-control",
                    "placeholder" => lang('content') . "...",
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required")
                ));
                ?>
            </div>
        </div>

    </div>

    <div class="form-group">
        <label for="show_title" class="col-md-3"><?php echo lang('show_title'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("show_title", "1", $model_info->show_title ? true : false, "id='show_title'");
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="show_border" class="col-md-3"><?php echo lang('show_border'); ?></label>
        <div class="col-md-9">
            <?php
            echo form_checkbox("show_border", "1", $model_info->show_border ? true : false, "id='show_border'");
            ?>
        </div>
    </div>

</div>

<div class="modal-footer">
    <div id="link-of-widget-view" class="hide">
        <?php
        echo modal_anchor(get_uri("dashboard/view_custom_widget"), "", array());
        ?>
    </div>
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button id="save-and-show-widget-button" type="button" class="btn btn-info"><span class="fa fa-check-circle"></span> <?php echo lang('save_and_show'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script>
    $(document).ready(function () {
        //send data to show the widget after save
        window.showAddNewModal = false;

        $("#save-and-show-widget-button").click(function () {
            window.showAddNewModal = true;
            $(this).trigger("submit");
        });

        var widgetInfoText = "<?php echo lang('custom_widget_details') ?>";

        window.widgetForm = $("#custom_widget-form").appForm({
            closeModalOnSuccess: false,
            onSuccess: function (result) {
                setTimeout(function () {
                    saveWidgetPosition();
                }, 300);

                var widgetRow = $(".js-widget-container, #widget-column-container").find('[data-value="' + result.id + '"]');

                if (widgetRow.has("span").length < 1) {
                    //insert operation
                    $(".js-widget-container").append(result.custom_widgets_row);
                } else {
                    //update operation
                    widgetRow.html(result.custom_widgets_data);
                }

                $(".js-widget-container").find("span.empty-area-text").remove();

                appAlert.success(result.message, {duration: 10000});

                if (window.showAddNewModal) {
                    var $widgetViewLink = $("#link-of-widget-view").find("a");
                    $widgetViewLink.attr("data-title", widgetInfoText);
                    $widgetViewLink.attr("data-post-id", result.id);

                    $widgetViewLink.trigger("click");
                } else {
                    window.widgetForm.closeModal();
                }
            }
        });
    });
</script>    