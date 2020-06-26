<div class="media b-b p15 m0 bg-white js-message-reply" data-message_id="<?php echo $reply_info->id; ?>" href="#reply-<?php echo $reply_info->id; ?>" >
    <div class="media-left">
        <span class="avatar avatar-sm">
            <img src="<?php echo get_avatar($reply_info->user_image); ?>" alt="..." />
        </span>
    </div>
    <div class="media-body w100p">
        <div class="media-heading">
            <strong><?php
                if ($reply_info->from_user_id === $this->login_user->id) {
                    echo lang("me");
                } else {
                    if ($reply_info->user_type == "client") {
                        echo get_client_contact_profile_link($reply_info->from_user_id, $reply_info->user_name, array("class" => "dark strong"));
                    } else {
                        echo get_team_member_profile_link($reply_info->from_user_id, $reply_info->user_name, array("class" => "dark strong"));
                    }
                }
                ?>
            </strong>
            <span class="text-off pull-right"><?php echo format_to_relative_time($reply_info->created_at); ?></span>
        </div>
        <p><?php echo nl2br(link_it($reply_info->message)); ?></p>

        <p>
            <?php
            $files = unserialize($reply_info->files);
            $total_files = count($files);

            if ($total_files) {
                $download_caption = lang('download');
                if ($total_files > 1) {
                    $download_caption = sprintf(lang('download_files'), $total_files);
                }
                echo "<i class='fa fa-paperclip pull-left font-16'></i>";
                echo anchor(get_uri("messages/download_message_files/" . $reply_info->id), $download_caption, array("class" => "", "title" => $download_caption));
            }
            ?>
        </p>
    </div>
</div>