<?php
if ($is_first_load) {
    echo "<div id='timeline'>";
}

foreach ($posts as $post) {
    ?>
    <div id="post-content-container-<?php echo $post->id; ?>" class="post-content">
        <div class="post clearfix">
            <div class="post-date clearfix">
                <span><?php echo format_to_relative_time($post->created_at, true, true); ?></span>
            </div>
            <div class="media clearfix">

                <div class="media-body">
                    <div class="clearfix mb15">
                        <div class="media-left ">
                            <span class="avatar avatar-sm">
                                <img src="<?php echo get_avatar($post->created_by_avatar); ?>" alt="..." />
                            </span>
                        </div>
                        <div class="media-left ">
                            <div class="mt5"><?php echo get_team_member_profile_link($post->created_by, $post->created_by_user, array("class" => "dark strong")); ?></div>
                            <small><span class="text-off"><?php echo format_to_relative_time($post->created_at); ?></span></small>
                        </div>

                        <!--  only admin and creator can delete the post -->
                        <?php if ($this->login_user->is_admin || $post->created_by == $this->login_user->id) { ?>
                            <span class="pull-right mt-50 dropdown">
                                <div class="text-off dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" >
                                    <i class="fa fa-chevron-down clickable"></i>
                                </div>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><?php echo ajax_anchor(get_uri("timeline/delete/$post->id"), "<i class='fa fa-times'></i> " . lang('delete'), array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#post-content-container-$post->id")); ?> </li>
                                </ul>
                            </span>
                        <?php } ?>

                    </div>

                    <p>
                        <?php echo nl2br(link_it($post->description)); ?>
                    </p>

                    <?php
                    $files = unserialize($post->files);
                    $total_files = count($files);
                    $this->load->view("includes/timeline_preview", array("files" => $files));
                    ?>

                    <div class="mb15 clearfix">
                        <?php
                        echo ajax_anchor(get_uri("timeline/post_reply_form/" . $post->id), "<i class='fa fa-reply font-11'></i> " . lang('reply'), array("data-real-target" => "#reply-form-container-" . $post->id, "class" => "dark"));
                        ?>
                        <?php
                        $reply_caption = "";
                        if ($post->total_replies == 1) {
                            $reply_caption = lang("reply");
                        } else if (($post->total_replies > 1)) {
                            $reply_caption = lang("replies");
                        }

                        if ($reply_caption) {
                            echo ajax_anchor(get_uri("timeline/view_post_replies/" . $post->id), "<i class='fa fa-comment-o'></i> " . lang("view") . " " . $post->total_replies . " " . $reply_caption, array("class" => "btn btn-default btn-xs view-replies", "id" => "show-replies-button-$post->id", "data-remove-on-success" => "#show-replies-button-$post->id", "data-real-target" => "#reply-list-" . $post->id));
                        }
                        //create link for reply success. trigger this link after submit any reply
                        echo ajax_anchor(get_uri("timeline/view_post_replies/" . $post->id), "", array("class" => "hide", "id" => "reload-reply-list-button-" . $post->id, "data-real-target" => "#reply-list-" . $post->id));


                        if ($total_files) {
                            $download_caption = lang('download');
                            if ($total_files > 1) {
                                $download_caption = sprintf(lang('download_files'), $total_files);
                            }
                            echo anchor(get_uri("timeline/download_files/" . $post->id), $download_caption, array("class" => "pull-right", "title" => $download_caption));
                        }
                        ?>

                    </div>
                    <div id="reply-list-<?php echo $post->id; ?>"></div>
                    <div id="reply-form-container-<?php echo $post->id; ?>"></div>

                </div>
            </div>
        </div>
    </div>
    <?php
}
if ($result_remaining > 0) {
    $next_container_id = "load" . $next_page_offset;
    ?>
    <div id="<?php echo $next_container_id; ?>">
        <div class="clearfix"></div>
    </div>

    <div id="loader-<?php echo $next_container_id; ?>">
        <div class="text-center">
            <?php
            echo ajax_anchor(get_uri("timeline/load_more_posts/" . $next_page_offset), lang("load_more"), array("class" => "btn btn-default load-more mt15 p10", "data-remove-on-success" => "#loader-" . $next_container_id, "title" => lang("load_more"), "data-inline-loader" => "1", "data-real-target" => "#" . $next_container_id));
            ?>
        </div>
    </div>
    <?php
}
if ($is_first_load) {
    echo "</div>";
}