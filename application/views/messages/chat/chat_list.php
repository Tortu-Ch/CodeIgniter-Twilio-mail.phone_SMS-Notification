<?php
if ($messages) {

    foreach ($messages as $message) {
        $online = "";
        if ($message->last_online && is_online_user($message->last_online)) {
            $online = "<i class='online'></i>";
        }

        $status = "";
        $last_message_from = $message->from_user_id;
        if ($message->last_from_user_id) {
            $last_message_from = $message->last_from_user_id;
        }

        if ($message->status === "unread" && $last_message_from != $this->login_user->id) {
            $status = "unread";
        }
        ?>
        <div class='js-message-row pull-left message-row <?php echo $status; ?>' data-id='<?php echo $message->id; ?>' data-index='<?php echo $message->id; ?>'><div class='media-left'>
                <span class='avatar avatar-xs'>
                    <img src='<?php echo get_avatar($message->user_image); ?>' />
                    <?php echo $online; ?>
                </span>
            </div>
            <div class='media-body'>
                <div class='media-heading'>
                    <strong><?php echo $message->user_name; ?></strong>
                    <span class='text-off pull-right time'><?php echo format_to_relative_time($message->message_time); ?></span>
                </div>
                <?php echo $message->subject; ?>
            </div>
        </div>

        <?php
    }
} else {
    ?>

    <div class="chat-no-messages text-off text-center">
        <i class="fa fa-comments-o"></i><br />
        <?php echo lang("no_messages_text"); ?>
    </div>

<?php } ?>

<script>
    $(document).ready(function () {
        //trigger the users list tab if there is no messages
<?php if (!$messages) { ?>
            setTimeout(function () {
                $("#chat-users-tab-button a").trigger("click");
            }, 500);
<?php } ?>
    });
</script>