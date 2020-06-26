<?php

$today = get_today_date();
$tomorrow = get_tomorrow_date();

if ($model_info->start_date == $model_info->end_date) {
    if ($model_info->start_date === $today) {
        echo lang("today");
    } else if ($model_info->start_date === $tomorrow) {
        echo lang("tomorrow");
    } else {
        $day_name = lang("short_" . strtolower(date("l", strtotime($model_info->start_date)))); //get short day name from language
        $month_name = lang(strtolower(date("F", strtotime($model_info->start_date)))); //get month name from language
        echo $day_name . ", " . $month_name . " " . date("d", strtotime($model_info->start_date));
    }

    if (is_date_exists($model_info->start_time)) {
        echo ", " . format_to_time($model_info->start_date . " " . $model_info->start_time, false);
        echo " – " . format_to_time($model_info->end_date . " " . $model_info->end_time, false);
    }
} else {

    $day_name = lang("short_" . strtolower(date("l", strtotime($model_info->start_date)))); //get short day name from language
    $month_name = lang(strtolower(date("F", strtotime($model_info->start_date)))); //get month name from language
    echo $day_name . ", " . $month_name . " " . date("d", strtotime($model_info->start_date));

    if (is_date_exists($model_info->start_time)) {
        echo ", " . format_to_time($model_info->start_date . " " . $model_info->start_time, false);
    }


    $end_day_name = lang("short_" . strtolower(date("l", strtotime($model_info->end_date)))); //get short day name from language
    $end_month_name = lang(strtolower(date("F", strtotime($model_info->end_date)))); //get month name from language
    echo " – " . $end_day_name . ", " . $end_month_name . " " . date("d", strtotime($model_info->end_date));

    if (is_date_exists($model_info->end_time)) {
        echo ", " . format_to_time($model_info->end_date . " " . $model_info->end_time, false);
    }
}
?>