<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-calendar"></i>&nbsp; <?php echo lang("events"); ?>
    </div>
    <div id="upcoming-event-container">
        <div class="panel-body">
            <div style="min-height: 190px;">
                <?php
                if ($events) {
                  
                    foreach ($events as $event) {
                        ?>
                        <div class="mb20">
                            <div><?php echo modal_anchor(get_uri("events/view/"), "<i style='color:" . $event->color . "' class='fa " . get_event_icon($event->share_with) . "'></i></span> " . $event->title, array("data-post-id" => encode_id($event->id, "event_id"), "data-post-cycle" => $event->cycle, "title" => lang("event_details"))); ?></div>
                            <div><?php $this->load->view("events/event_time", array("model_info" => $event)); ?></div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='text-center'>" . lang("no_event_found") . "</div>";
                    echo "<div class='text-center p15 text-off'><i class='fa fa-calendar' style='font-size:100px;'></i></div>";
                }
                ?>
            </div>
            <div><?php echo anchor("events", lang("view_on_calendar"), array("class" => "btn btn-default b-a load-more mt15")); ?></div>
        </div>
    </div>
</div> 

<script type="text/javascript">
    $(document).ready(function () {
        initScrollbar('#upcoming-event-container', {
            setHeight: 285
        });
    });
</script> 