<div class="rise-chat-header box">
    <div class="box-content chat-back" id="js-back-to-team-members-tab">
        <i class="fa fa-chevron-left"></i>
    </div>
    <div class="box-content chat-title">
        <div>
            <?php echo $user_name; ?>
        </div>
    </div>
</div>
<div id="js-single-user-chat-list" class="rise-chat-body full-height">
  
<div class='clearfix p10 b-b'>
    <?php
    if (get_setting("module_chat")) {
        echo modal_anchor(get_uri("messages/modal_form/" . $user_id), "<i class='fa fa-plus-circle'></i> " . lang("new_conversation"), array("class" => "btn btn-default col-md-12", "title" => lang('send_message')));
    }
    ?>
</div>
    <div id="chatlist-of-user">
<?php
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
?>
    </div>
</div>

<script>
    $("#js-back-to-team-members-tab").click(function(){
        loadChatTabs("<?php echo $tab_type; ?>");
    });
</script>