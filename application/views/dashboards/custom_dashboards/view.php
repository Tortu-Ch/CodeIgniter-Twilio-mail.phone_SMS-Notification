<div id="page-content" class="p20 clearfix dashboard-view">

    <?php $this->load->view("dashboards/dashboard_header"); ?>

    <div class="clearfix row">
        <div class="col-md-12 widget-container">
            <?php announcements_alert_widget(); ?>
        </div>
    </div>

    <?php
    if ($widget_columns) {
        echo $widget_columns;
    } else {
        $this->load->view("dashboards/custom_dashboards/no_widgets");
    }
    ?>

</div>

<?php $this->load->view("dashboards/helper_js"); ?>

<script>
    $(document).ready(function () {
        //we have to reload the same page when editting title
        $("#dashboard-edit-title-button").click(function () {
            window.dashboardTitleEditMode = true;
        });

        //update dashboard link
        $(".dashboard-menu, .dashboard-image").closest("a").attr("href", window.location.href);

        onDashboardDeleteSuccess = function (result, $selector) {
            window.location.href = "<?php echo get_uri("dashboard"); ?>";
        };

        initScrollbar('#project-timeline-container', {
            setHeight: 719
        });

        initScrollbar('#upcoming-event-container', {
            setHeight: 330
        });

        initScrollbar('#client-projects-list', {
            setHeight: 316
        });

    });
</script>