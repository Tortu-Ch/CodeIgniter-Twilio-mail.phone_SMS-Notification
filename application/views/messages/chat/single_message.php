<?php
$files = unserialize($reply_info->files);
$total_files = count($files);

$files_preview = "";
if ($total_files) {
    $download_caption = lang('download');
    if ($total_files > 1) {
        $download_caption = sprintf(lang('download_files'), $total_files);
    }

    $files_preview = anchor(get_uri("messages/download_message_files/" . $reply_info->id), "<i class='fa fa-paperclip pull-left font-16'></i>" . $download_caption, array("class" => "", "title" => $download_caption));
}

$message_class = "m-row-" . $reply_info->id;
if ($reply_info->from_user_id === $this->login_user->id) {
    ?>
    <div class="chat-me <?php echo $message_class; ?>">
        <div class="chat-msg js-chat-msg"  data-message_id="<?php echo $reply_info->id; ?>"><?php
            echo nl2br(link_it($reply_info->message));
            if ($files_preview) {
                echo "<br>" . $files_preview;
            }
            ?></div>
    </div>
<?php } else {
    ?>

    <div class="chat-other <?php echo $message_class; ?>">
        <div class="avatar-xs avatar mr10" >
            <?php
            $avatar = get_avatar($reply_info->user_image);
            if ($reply_info->user_type == "client") {
                echo get_client_contact_profile_link($reply_info->from_user_id, " <img alt='...' src='" . $avatar . "' /> ", array("class" => "dark strong"));
            } else {
                echo get_team_member_profile_link($reply_info->from_user_id, " <img alt='...' src='" . $avatar . "' /> ", array("class" => "dark strong"));
            }
            ?>
        </div>
        <div class="chat-msg js-chat-msg"  data-message_id="<?php echo $reply_info->id ?>">
            <?php
            echo nl2br(link_it($reply_info->message));
            if ($files_preview) {
                echo "<br>" . $files_preview;
            }
            ?>
        </div>
    </div>

<?php } ?>

<script class="temp-script33">
    //don't show duplicate messages
    $("<?php echo '.' . $message_class; ?>:first").nextAll("<?php echo '.' . $message_class; ?>").remove();
</script>