<div id="page-content" class="p20 clearfix">

    <?php
    if (count($dashboards)) {
        $this->load->view("dashboards/dashboard_header");
    }

    announcements_alert_widget();
    ?>

    <div class="row">
        <?php
        $widget_column = "3"; //default bootstrap column class
        $total_hidden = 0;

        if (!$show_attendance) {
            $total_hidden += 1;
        }

        if (!$show_event) {
            $total_hidden += 1;
        }

        if (!$show_timeline) {
            $total_hidden += 1;
        }

        //set bootstrap class for column
        if ($total_hidden == 1) {
            $widget_column = "4";
        } else if ($total_hidden == 2) {
            $widget_column = "6";
        } else if ($total_hidden == 3) {
            $widget_column = "12";
        }
        ?>

        <?php if ($show_attendance) { ?>
            <div class="col-md-<?php echo $widget_column; ?> col-sm-6 widget-container">
                <?php
                clock_widget();
                ?>
            </div>
        <?php } ?>

        <div class="col-md-<?php echo $widget_column; ?> col-sm-6  widget-container">
            <?php
            my_open_tasks_widget();
            ?> 
        </div>

        <?php if ($show_event) { ?>
            <div class="col-md-<?php echo $widget_column; ?> col-sm-6  widget-container">
                <?php
                events_today_widget();
                ?> 
            </div>
        <?php } ?>

        <?php if ($show_timeline) { ?>
            <div class="col-md-<?php echo $widget_column; ?> col-sm-6  widget-container">
                <?php
                new_posts_widget();
                ?>  
            </div>
        <?php } ?>

    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12 mb20 text-center">
                    <div class="bg-white">
                        <?php
                        count_project_status_widget();
                        if ($show_clock_status) {
                            count_clock_status_widget();
                        } else {
                            count_total_time_widget();
                        }
                        ?> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($show_invoice_statistics) {
                        invoice_statistics_widget();
                    } else if ($show_project_timesheet) {
                        project_timesheet_statistics_widget();
                    }
                    ?> 
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 mb15">
                    <?php
                    if ($show_ticket_status) {
                        ticket_status_widget();
                    } else if ($show_attendance) {
                        timecard_statistics_widget();
                    }
                    ?>                        
                </div>
            </div>

        </div>

        <div class="col-md-4 widget-container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-clock-o"></i>&nbsp;  <?php echo lang("project_timeline"); ?>
                </div>
                <div id="project-timeline-container">
                    <div class="panel-body"> 
                        <?php
                        activity_logs_widget(array("log_for" => "project", "limit" => 10));
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 widget-container">
            <?php
            if ($show_income_vs_expenses) {
                income_vs_expenses_widget();
            } else {
                my_task_stataus_widget();
            }
            ?>
        </div>

        <?php if ($show_event) { ?>
            <div class="col-md-3 widget-container">
                <?php events_widget(); ?>
            </div>
        <?php } ?>

        <div class="col-md-3 widget-container">
            <?php sticky_note_widget(); ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        initScrollbar('#project-timeline-container', {
            setHeight: 955
        });

        //update dashboard link
        $(".dashboard-menu, .dashboard-image").closest("a").attr("href", window.location.href);

    });
</script>    

