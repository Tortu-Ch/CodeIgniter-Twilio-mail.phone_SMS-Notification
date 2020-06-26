<?php if ($timers) { ?>
    <li class="">
        <?php echo js_anchor("&nbsp;", array("id" => "project-timer-icon", "class" => "dropdown-toggle animated-clock", "data-toggle" => "dropdown")); ?>
        <div class="dropdown-menu aside-xl m0 p0 w300">
            <div class="dropdown-details panel bg-white m0 ">
                <div class="list-group">
                    <?php foreach ($timers as $timer) { ?>
                        <div  class="list-group-item"> 
                            <div class="clearfix">
                                <span class="pull-left mt5" title=" <?php echo format_to_datetime($timer->start_time); ?>">
                                    <?php
                                    echo lang("started_at") . " <strong>" . format_to_time($timer->start_time) . "</strong>";
                                    ?>
                                </span>
                                <span class="pull-right"><?php
                                    echo modal_anchor(get_uri("projects/stop_timer_modal_form/" . $timer->project_id), "<i class='fa fa fa-clock-o'></i> " . lang('stop_timer'), array("class" => "btn btn-danger btn-sm", "title" => lang('stop_timer')));
                                    ?>
                                </span>
                            </div>
                            <div class="pt5"> <i class="fa fa-th-large"></i> <?php echo anchor("projects/view/" . $timer->project_id, $timer->project_title, array("class" => "dark")); ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </li>
<?php } ?>

