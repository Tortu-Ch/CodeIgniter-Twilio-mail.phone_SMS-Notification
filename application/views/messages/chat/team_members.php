<?php if ($users) { ?>
    <div id="js-chat-team-members-list">
        <?php
        foreach ($users as $user) {
            $online = "";
            if ($user->last_online && is_online_user($user->last_online)) {
                $online = "<i class='online'></i>";
            }
            ?>
            <div class="message-row js-message-row-of-<?php echo $page_type; ?>" data-id="<?php echo $user->id; ?>" data-index="1" data-reply="">
                <div class="media-left">

                    <span class="avatar avatar-xs">
                        <img alt="..." src="<?php echo get_avatar($user->image); ?>">
                        <?php echo $online; ?>
                    </span>
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <strong> <?php echo $user->first_name . " " . $user->last_name; ?></strong>
                    </div>
                    <?php
                    $subline = $user->job_title;
                    if ($user->user_type === "client" && $user->company_name) {
                        $subline = $user->company_name;
                    }
                    ?>
                    <small class="text-off w200 block"><?php echo $subline; ?></small>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php } else { ?>

    <div class="chat-no-messages text-off text-center">
        <i class="fa fa-frown-o"></i><br />
        <?php echo lang("no_users_found"); ?>
    </div>

<?php } ?>

