<div id="page-content" class="p20 clearfix">

    <div class="view-container">
        <div class="panel panel-default">
            <div class="page-title clearfix">
                <h4><?php echo lang("estimate_request_form_selection_title"); ?></h4>
            </div>

            <div class="panel-body">
                <ul class="list-group mb0">
                    <?php
                    foreach ($estimate_forms as $form) {
                        echo "<li class='list-group-item'>" . anchor(get_uri("request_estimate/form/" . $form->id), $form->title) . "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>