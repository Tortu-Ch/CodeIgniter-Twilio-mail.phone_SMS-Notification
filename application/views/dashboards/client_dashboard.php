<div id="page-content" class="p20 clearfix">
    <?php
    if (count($dashboards)) {
        $this->load->view("dashboards/dashboard_header");
    }

    announcements_alert_widget();
    ?>
    <div class="row">
        <?php $this->load->view("clients/info_widgets/index"); ?>
    </div>

    <?php if (!in_array("projects", $hidden_menu)) { ?>
        <div class="">
            <?php $this->load->view("clients/projects/index"); ?>
        </div>
    <?php } ?>

</div>