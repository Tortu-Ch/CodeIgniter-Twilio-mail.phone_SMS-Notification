<div class="panel panel-default">
    <div class="panel-heading">
        <?php
        if ($icon) {
            echo "<i class='fa " . $icon . "'></i>&nbsp; ";
        }
        echo lang($widget);
        ?>
    </div>

    <?php
    $js_id = "";
    if ($widget == "project_timeline") {
        $js_id = "project-timeline-container";
    }
    ?>

    <div id="<?php echo $js_id; ?>">
        <div class="panel-body"> 
            <?php
            if ($widget == "project_timeline") {
                echo activity_logs_widget(array("log_for" => "project", "limit" => 10), true);
            }
            ?>
        </div>
    </div>    
</div>