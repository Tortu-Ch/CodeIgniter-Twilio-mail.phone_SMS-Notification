<?php
$panel = "";
if ($status == "new") {
    $panel = "orange";
} else if ($status == "open") {
    $panel = "coral";
} else if ($status == "closed") {
    $panel = "success";
}
?>

<div class="panel panel-<?php echo $panel; ?>">
    <div class="panel-body text-white">
        <div class="widget-icon">
            <i class="fa fa-support"></i>
        </div>
        <div class="widget-details">
            <h1><?php echo $total_tickets; ?></h1>
            <?php echo lang($status . "_tickets"); ?>
        </div>
    </div>
</div>