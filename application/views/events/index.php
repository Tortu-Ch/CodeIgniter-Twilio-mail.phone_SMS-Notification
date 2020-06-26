<?php
load_css(array(
    "assets/js/fullcalendar/fullcalendar.min.css"
));

load_js(array(
    "assets/js/fullcalendar/fullcalendar.min.js",
    "assets/js/fullcalendar/lang-all.js",
    "assets/js/bootstrap-confirmation/bootstrap-confirmation.js"
));

$client = "";
if (isset($client_id)) {
    $client = $client_id;
}
?>

<div id="page-content<?php echo $client; ?>" class="p20<?php echo $client; ?> clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <?php if ($client) { ?>
                <h4><?php echo lang('events'); ?></h4>
            <?php } else { ?>
                <h1><?php echo lang('event_calendar'); ?></h1>
            <?php } ?>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("events/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_event'), array("class" => "btn btn-default", "title" => lang('add_event'), "data-post-client_id" => $client)); ?>
                <?php echo modal_anchor(get_uri("events/modal_form"), "", array("class" => "hide", "id" => "add_event_hidden", "title" => lang('add_event'), "data-post-client_id" => $client)); ?>
                <?php echo modal_anchor(get_uri("events/view"), "", array("class" => "hide", "id" => "show_event_hidden", "data-post-client_id" => $client, "data-post-cycle" => "0", "data-post-editable" => "1", "title" => lang('event_details'))); ?>
                <?php echo modal_anchor(get_uri("leaves/application_details"), "", array("class" => "hide", "data-post-id" => "", "id" => "show_leave_hidden")); ?>
            </div>
        </div>
        <div class="panel-body">
            <div id="event-calendar"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#event-calendar").fullCalendar({
            lang: AppLanugage.locale,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: "<?php echo_uri("events/calendar_events/" . $client); ?>",
            dayClick: function (date, jsEvent, view) {
                $("#add_event_hidden").attr("data-post-start_date", date.format("YYYY-MM-DD"));
                var startTime = date.format("HH:mm:ss");
                if (startTime === "00:00:00") {
                    startTime = "";
                }
                $("#add_event_hidden").attr("data-post-start_time", startTime);
                var endDate = date.add(1, 'hours');

                $("#add_event_hidden").attr("data-post-end_date", endDate.format("YYYY-MM-DD"));
                var endTime = "";
                if (startTime != "") {
                    endTime = endDate.format("HH:mm:ss");
                }

                $("#add_event_hidden").attr("data-post-end_time", endTime);
                $("#add_event_hidden").trigger("click");
            },
            eventClick: function (calEvent, jsEvent, view) {
                $("#show_event_hidden").attr("data-post-id", calEvent.encrypted_event_id);
                $("#show_event_hidden").attr("data-post-cycle", calEvent.cycle);
                $("#show_leave_hidden").attr("data-post-id", calEvent.encrypted_event_id);

                if (calEvent.event_type === "event") {
                    $("#show_event_hidden").trigger("click");
                } else {
                    $("#show_leave_hidden").trigger("click");
                }
            },
            eventRender: function (event, element) {
                if (event.icon) {
                    element.find(".fc-title").prepend("<i class='fa " + event.icon + "'></i> ");
                }
            },
            firstDay: AppHelper.settings.firstDayOfWeek

        });

        var client = "<?php echo $client; ?>";
        if (client) {
            setTimeout(function () {
                $('#event-calendar').fullCalendar('today');
            });
        }


        //autoload the event popover
        var encrypted_event_id = "<?php echo isset($encrypted_event_id) ? $encrypted_event_id : ''; ?>";

        if (encrypted_event_id) {
            $("#show_event_hidden").attr("data-post-id", encrypted_event_id);
            $("#show_event_hidden").trigger("click");
        }


    });
</script>