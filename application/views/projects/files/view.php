<div class="app-modal">
    <div class="app-modal-content">
        <?php $this->load->view("includes/file_preview"); ?>
    </div>

    <div class="app-modal-sidebar">
        <div class="mb15 pl15 pr15">
            <div class="media-left ">
                <span class='avatar avatar-sm'><img src='<?php echo get_avatar($file_info->uploaded_by_user_image); ?>' alt='...'></span>
            </div>
            <div class="media-left">
                <div class="mt5"><?php
                    if ($file_info->uploaded_by_user_type == "staff") {
                        echo get_team_member_profile_link($file_info->uploaded_by, $file_info->uploaded_by_user_name);
                    } else {
                        echo get_client_contact_profile_link($file_info->uploaded_by, $file_info->uploaded_by_user_name);
                    }
                    ?></div>
                <small><span class="text-off"><?php echo format_to_relative_time($file_info->created_at); ?></span></small>
            </div>
            <div class="pt10 pb10 b-b">
                <?php echo $file_info->description; ?>
            </div>
        </div>
        <div class="mr15">
            <?php
            if ($can_comment_on_files) {
                $this->load->view("projects/comments/comment_form");
            }
            ?>
            <?php $this->load->view("projects/comments/comment_list"); ?>
        </div>
    </div>

</div>