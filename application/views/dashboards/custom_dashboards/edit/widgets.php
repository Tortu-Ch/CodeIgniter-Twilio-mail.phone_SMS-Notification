<div class="text-center bg-white">

    <div class="box p15">
        <?php echo modal_anchor(get_uri("dashboard/custom_widget_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_widget'), array("class" => "btn btn-default col-md-12 block", "title" => lang('add_widget'))); ?>
    </div>                    

    <div class="add-column-panel js-widget-container p15 pt0" id="add-column-panel-1000000">
        <?php
        if ($widgets) {
            echo $widgets;
        }
        ?>

    </div>

</div>
