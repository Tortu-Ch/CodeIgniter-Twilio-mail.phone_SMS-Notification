<div class="list-group">
    <?php
    if (count($notifications)) {
        foreach ($notifications as $notification) {
            ?>
            <a class="list-group-item" href="<?php
            $message_id = $notification->message_id ? $notification->message_id : $notification->id;
            echo get_uri("messages/inbox/" . $message_id)
            ?>">
                <div class="media-left">
                    <span class="avatar avatar-xs">
                        <img src="<?php echo get_avatar($notification->user_image); ?>" alt="..." />
                    </span>
                </div>
                <div class="media-body w100p">
                    <div class="media-heading">
                        <strong><?php echo $notification->user_name; ?></strong>
                        <span class="text-off pull-right"><small><?php echo format_to_relative_time($notification->created_at); ?></small></span>
                    </div>
                    <div><?php echo lang("sent_you_a_message"); ?></div>
                </div>
            </a>
            <?php
        }
    } else {
        ?>
        <span class="list-group-item"><?php echo lang("no_new_messages"); ?></span>
    <?php } ?>
</div>
