<div class="list-group">
    <?php
    if (count($projects)) {
        foreach ($projects as $project) {

            $icon = "fa-th-large";
            if ($project->status == "completed") {
                $icon = "fa-check-circle";
            } else if ($project->status == "canceled") {
                $icon = "fa-times";
            }
            
            $title = "<i class='fa $icon mr10'></i> " . $project->title;
            echo anchor(get_uri("projects/view/" . $project->id), $title, array("class" => "list-group-item"));
        }
    } else {
        ?>
        <div class='list-group-item'>
            <?php echo lang("empty_starred_projects"); ?>              
        </div>
    <?php } ?>
</div>