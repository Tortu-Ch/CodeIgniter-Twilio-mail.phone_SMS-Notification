<div class="panel panel-success">
    <div class="panel-body ">
        <div class="widget-icon">
            <i class="fa fa-life-ring"></i>
        </div>
        <div class="widget-details">
            <h1><?php echo $total; ?></h1>
            <?php echo anchor(get_uri("tickets"), lang("open_tickets"), array("class" => "white-link")); ?>
        </div>
    </div>
</div>