<?php

if ($timer_status === "open") {
    echo modal_anchor(get_uri("projects/stop_timer_modal_form/". $project_info->id),  "<i class='fa fa fa-clock-o'></i> " . lang('stop_timer'), array("class" => "btn btn-danger", "title" => lang('stop_timer')));
} else {
    echo ajax_anchor(get_uri("projects/timer/" . $project_info->id . "/start"), "<i class='fa fa fa-clock-o'></i> " . lang('start_timer'), array("class" => "btn btn-info", "title" => lang('start_timer'), "data-reload-on-success" => "1"));
}
?>