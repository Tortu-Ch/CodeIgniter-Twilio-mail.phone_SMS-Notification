<div class="list-group">
    <?php
    if (count($clients)) {
        foreach ($clients as $client) {

            $icon = "fa fa-briefcase";

            $title = "<i class='fa $icon mr10'></i> " . $client->company_name;
            echo anchor(get_uri("clients/view/" . $client->id), $title, array("class" => "list-group-item"));
        }
    } else {
        ?>
        <div class='list-group-item'>
            <?php echo lang("empty_starred_clients"); ?>              
        </div>
    <?php } ?>
</div>