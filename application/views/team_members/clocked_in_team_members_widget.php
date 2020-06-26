<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-clock-o"></i>&nbsp; <?php echo lang("clocked_in_team_members"); ?>
    </div>
    <div class="panel-body active-team-members-list p0" id="clocked-in-team-members-list">
        <?php
        if ($users) {
            foreach ($users as $user) {
                $attendance_in_time = $user->in_time;
                $explode_attendance_in_time = explode(" ", $attendance_in_time);

                $in_time = "<span class='text-off'>" . "<i class='fa fa-clock-o'></i>" . " ";

                if ($explode_attendance_in_time[0] == get_today_date()) {
                    //if the attendance has been started today, then show only time
                    $in_time .= format_to_time($attendance_in_time);
                } else {
                    //if the attendance hasn't been started today, then show only time
                    $in_time .= format_to_relative_time($attendance_in_time);
                }

                $in_time .= "</span>";
                ?>
                <div class="message-row">
                    <div class="media-left">

                        <span class="avatar avatar-xs">
                            <img alt="..." src="<?php echo get_avatar($user->created_by_avatar); ?>">
                        </span>
                    </div>
                    <div class="media-body">
                        <div class="media-heading clearfix">
                            <strong class="pull-left"> 
                                <?php echo get_team_member_profile_link($user->user_id, $user->created_by_user); ?>
                            </strong>
                            <span class="pull-right"><?php echo $in_time; ?></span>
                        </div>
                        <?php $subline = $user->user_job_title; ?>
                        <small class="text-off block"><?php echo $subline; ?></small>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        initScrollbar('#clocked-in-team-members-list', {
            setHeight: 330
        });
    });
</script>