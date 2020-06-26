<?php
$border_class = "";
if ($widget_info->show_border) {
    $border_class = "bg-white p15";
}
?>

<div class="custom-widget mb20">

    <?php if ($widget_info->show_title) { ?>
        <div class="custom-widget-title">
            <?php echo $widget_info->title; ?>
        </div>
    <?php } ?>

    <div class="<?php echo $border_class ?>"> 
        <?php echo $widget_info->content; ?>
    </div>

</div>