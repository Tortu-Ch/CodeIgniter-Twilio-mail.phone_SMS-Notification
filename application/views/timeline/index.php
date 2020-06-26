<div class="box">
    <div class="box-content">
        <div id="timeline-content" class="clearfix p15 mb20">
            <?php $this->load->view("timeline/post_form"); ?>
            <?php timeline_widget(array("limit" => 20, "offset" => 0, "is_first_load" => true)); ?>
        </div>
    </div>
    <div class="hidden-xs box-content bg-white" style="width: 250px; min-height: 100%;">
        <div id="user-list-container" >
            <div class="p15">
                <?php
                foreach ($team_members as $member) {
                    ?>
                    <div class="media">
                        <div class="media-left">
                            <span class="avatar avatar-xs">
                                <img src="<?php echo get_avatar($member->image); ?>" alt="..." />
                            </span>
                        </div>
                        <div class="media-body clearfix w100p">
                            <div class="media-heading pull-left m0">
                                <div class="w150"><?php echo get_team_member_profile_link($member->id, $member->first_name . " " . $member->last_name, array("class" => "dark")); ?></div>
                                <small class="text-off w150 block"><?php echo $member->job_title; ?></small>
                            </div>
                            <div class="pull-right">
                                <?php
                                if (get_setting("module_message")) {
                                    echo modal_anchor(get_uri("messages/modal_form/" . $member->id), "<i class='fa fa-envelope-o'></i>", array("class" => "btn btn-default btn-xs round", "title" => lang('send_message')));
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {


        setTimelineScrollable()
        $(window).resize(function () {
            setTimelineScrollable();
        });
    });


    setTimelineScrollable = function () {
        var options = {
            setHeight: $(window).height() - 65
        };

        initScrollbar('#user-list-container', options);

        //don't apply scrollbar for mobile devices
        if ($(window).width() <= 640) {
            $('#timeline-content').css({"overflow": "auto"});
        } else {
            options.callbacks = {
                onTotalScroll: function () {
                    if (!$(".load-more").hasClass("inline-loading")) {
                        $(".load-more").trigger("click"); //auto load more data
                    }
                }
            };
            initScrollbar('#timeline-content', options);
        }

    };
</script>
