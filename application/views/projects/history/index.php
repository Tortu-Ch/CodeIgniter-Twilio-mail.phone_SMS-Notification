<!-- don't load the panel for 2nd time -->
<?php
if ($offset) {
    activity_logs_widget($activity_logs_params);
} else {
    ?>
    <div class="panel">
        <div class="panel-body">
            <?php activity_logs_widget($activity_logs_params); ?>
        </div>   
    </div> 
    <?php
}?>