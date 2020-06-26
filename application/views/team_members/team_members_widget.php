<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-user"></i>&nbsp; <?php echo lang("all_team_members"); ?>
    </div>
    <div class="panel-body" id="all-team-members-list">
        <?php
        if ($members) {
            foreach ($members as $member) {
                $image_url = get_avatar($member->image);
                $avatar = "<span data-toggle='tooltip' title='" . $member->first_name . " " . $member->last_name . "' class='avatar avatar-sm mr10 mb15'><img src='$image_url' alt='...'></span>";

                echo get_team_member_profile_link($member->id, $avatar);
            }
        }
        ?>

    </div>
</div>

<script>
    $(document).ready(function () {
        initScrollbar('#all-team-members-list', {
            setHeight: 330
        });
        
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>