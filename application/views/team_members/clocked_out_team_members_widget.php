<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-history"></i>&nbsp; <?php echo lang("clocked_out_team_members"); ?>
    </div>
    <div class="panel-body active-team-members-list p0" id="clocked-out-team-members-list">
        <?php
        if ($users) {
            foreach ($users as $user) {
                if ($user->last_online && is_online_user($user->last_online)) {
                    ?>

                    <div class="message-row">
                        <div class="media-left">

                            <span class="avatar avatar-xs">
                                <img alt="..." src="<?php echo get_avatar($user->image); ?>">
                            </span>
                        </div>
                        <div class="media-body">
                            <div class="media-heading clearfix">
                                <strong class="pull-left"> 
                                    <?php echo get_team_member_profile_link($user->id, $user->member_name); ?>
                                </strong>
                                <span class="pull-right"><i class='online'></i></span>
                            </div>
                            <?php $subline = $user->job_title; ?>
                            <small class="text-off block"><?php echo $subline; ?></small>
                        </div>
                    </div> 

                    <?php
                }
            }
        }
        ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        initScrollbar('#clocked-out-team-members-list', {
            setHeight: 330
        });
    });
</script>