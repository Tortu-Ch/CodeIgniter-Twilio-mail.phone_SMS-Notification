<?php foreach ($reply_list as $reply) { ?>
    <div id="prject-comment-reply-container-<?php echo $reply->id; ?>" class="media mb15 b-l reply-container">
        <div class="media-left pl15">
            <span class="avatar avatar-xs">
                <img src="<?php echo get_avatar($reply->created_by_avatar); ?>" alt="..." />
            </span>
        </div>
        <div class="media-body">
            <div class="media-heading">
                <?php
                if ($reply->user_type === "staff") {
                    echo get_team_member_profile_link($reply->created_by, $reply->created_by_user, array("class" => "dark strong"));
                } else {
                    echo get_client_contact_profile_link($reply->created_by, $reply->created_by_user, array("class" => "dark strong"));
                }
                ?>
                <small><span class="text-off"><?php echo format_to_relative_time($reply->created_at); ?></span></small>


                <?php if ($this->login_user->is_admin || $reply->created_by == $this->login_user->id) { ?>
                    <span class="pull-right dropdown reply-dropdown">
                        <div class="text-off dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" >
                            <i class="fa fa-chevron-down clickable"></i>
                        </div>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><?php echo ajax_anchor(get_uri("projects/delete_comment/$reply->id"), "<i class='fa fa-times'></i> " . lang('delete'), array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#prject-comment-reply-container-$reply->id")); ?> </li>
                        </ul>
                    </span>
                <?php } ?>

            </div>
            <p><?php echo convert_mentions($reply->description); ?></p>
            <div class="comment-image-box clearfix">
                <?php
                if ($reply->files) {
                    $files = unserialize($reply->files);
                    $total_files = count($files);
                    $this->load->view("includes/timeline_preview", array("files" => $files));
                    if ($total_files) {
                        $download_caption = lang('download');
                        if ($total_files > 1) {
                            $download_caption = sprintf(lang('download_files'), $total_files);
                        }

                        echo "<i class='fa fa-paperclip pull-left font-16'></i>";
                        echo anchor(get_uri("projects/download_comment_files/" . $reply->id), $download_caption, array("class" => "pull-right", "title" => $download_caption));
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>