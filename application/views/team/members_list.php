<div class="modal-body clearfix">
    <?php foreach ($team_members as $member) { ?>

        <div class="form-group">
            <div class="media pb10 b-b">
                <div class="media-left pl15">
                    <span class="avatar avatar-xs">
                        <img src="<?php echo get_avatar($member->image); ?>" alt="..." />
                    </span>
                </div>
                <div class="media-body w100p">
                    <div class="media-heading clearfix">
                        <div class="pull-left">
                            <?php echo get_team_member_profile_link($member->id, $member->first_name . " " . $member->last_name); ?>
                        </div>
                        <div class="pull-right pr15">
                            <label class="label label-info"><?php echo $member->job_title; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>
