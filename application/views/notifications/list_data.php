<?php
if (count($notifications)) {

    foreach ($notifications as $notification) {
        $url = "#";
        $ajax_modal_url = "";
        $app_modal_url = "";
        $url_id = "";

        //prepare url
        $info = get_notification_config($notification->event, "info", $notification);
        if (is_array($info)) {
            $url = get_array_value($info, "url");
            $ajax_modal_url = get_array_value($info, "ajax_modal_url");
            $app_modal_url = get_array_value($info, "app_modal_url");
            $url_id = get_array_value($info, "id");
        }

        if ($ajax_modal_url) {
            $url_attributes = "href='#' data-act='ajax-modal' data-action-url='$ajax_modal_url' data-post-id='$url_id' ";
        } else if ($app_modal_url) {
            $url_attributes = "href='#' data-toggle='app-modal' data-url='$app_modal_url' ";
        } else {
            $url_attributes = "href='$url'";
        }


        //check read/unread class
        $notification_class = "";
        if (!$notification->is_read) {
            $notification_class = "unread-notification";
        }

        if (!$url || $url == "#") {
            $notification_class.=" not-clickable";
        }
        ?>

        <a class="list-group-item <?php echo $notification_class; ?>" data-notification-id="<?php echo $notification->id; ?>" <?php echo $url_attributes; ?> >
            <div class="media-left">
                <span class="avatar avatar-xs">
                    <img src="<?php echo get_avatar($notification->user_id ? $notification->user_image : "system_bot"); ?>" alt="..." />
                    <!--  if user name is not present then -->
                </span>
            </div>
            <div class="media-body w100p">
                <div class="media-heading">
                    <strong><?php echo $notification->user_id ? $notification->user_name : get_setting("app_title"); ?></strong>
                    <span class="text-off pull-right"><small><?php echo format_to_relative_time($notification->created_at); ?></small></span>
                </div>
                <div class="media m0">
                    <?php
                    echo sprintf(lang("notification_" . $notification->event), "<strong>" . $notification->to_user_name . "</strong>");

                    $this->load->view("notifications/notification_description", array("notification" => $notification));
                    ?>
                </div>
            </div>
        </a>
        <?php
    }

    if ($result_remaining) {
        $next_container_id = "load" . $next_page_offset;
        ?>
        <div id="<?php echo $next_container_id; ?>">

        </div>

        <div id="loader-<?php echo $next_container_id; ?>" >
            <div class="text-center p20 clearfix mt-5">
                <?php
                echo ajax_anchor(get_uri("notifications/load_more/" . $next_page_offset), lang("load_more"), array("class" => "btn btn-default load-more mt15 p10", "data-remove-on-success" => "#loader-" . $next_container_id, "title" => lang("load_more"), "data-inline-loader" => "1", "data-real-target" => "#" . $next_container_id));
                ?>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <span class="list-group-item"><?php echo lang("no_new_notifications"); ?></span>               
<?php } ?>


<script type="text/javascript">
    $(document).ready(function () {
        $(".unread-notification").click(function (e) {
            $.ajax({
                url: '<?php echo get_uri("notifications/set_notification_status_as_read") ?>/' + $(this).attr("data-notification-id")
            });
            $(this).removeClass("unread-notification");
        });
    });
</script>