<?php foreach ($reply_list as $reply) { ?>
    <div id="reply-content-container-<?php echo $reply->id; ?>"  class="media mb15 b-l reply-container">
        <div class="media-left pl15">
            <span class="avatar avatar-xs">
                <img src="<?php echo get_avatar($reply->created_by_avatar); ?>" alt="..." />
            </span>
        </div>
        <div class="media-body">
            <div class="media-heading">
                <?php echo get_team_member_profile_link($reply->created_by, $reply->created_by_user, array("class" => "dark strong")); ?>
                <small><span class="text-off"><?php echo format_to_relative_time($reply->created_at); ?></span></small>


                <?php if ($this->login_user->is_admin || $reply->created_by == $this->login_user->id) { ?>
                    <span class="pull-right dropdown reply-dropdown">
                        <div class="text-off dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true" >
                            <small class="p5"> <i class="fa fa-chevron-down clickable"></i></small>
                        </div>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><?php echo ajax_anchor(get_uri("timeline/delete/$reply->id"), "<i class='fa fa-times'></i> " . lang('delete'), array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#reply-content-container-$reply->id")); ?> </li>
                        </ul>
                    </span>
                <?php } ?>
            </div>

            <p><?php echo nl2br(link_it($reply->description)); ?></p>
        </div>
    </div>
<?php } ?>