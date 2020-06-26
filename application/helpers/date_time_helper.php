<?php

/**
 * get user's time zone offset 
 * 
 * @return active users timezone
 */
if (!function_exists('get_timezone_offset')) {

    function get_timezone_offset() {
        $timeZone = new DateTimeZone(get_setting("timezone"));
        $dateTime = new DateTime("now", $timeZone);
        return $timeZone->getOffset($dateTime);
    }

}

/**
 * convert a local time to UTC 
 * 
 * @param string $date
 * @param string $format
 * @return utc date
 */
if (!function_exists('convert_date_local_to_utc')) {

    function convert_date_local_to_utc($date = "", $format = "Y-m-d H:i:s") {
        if (!$date) {
            return false;
        }
        //local timezone
        $time_offset = get_timezone_offset() * -1;

        //add time offset
        return date($format, strtotime($date) + $time_offset);
    }

}

/**
 * get current utc time
 * 
 * @param string $format
 * @return utc date
 */
if (!function_exists('get_current_utc_time')) {

    function get_current_utc_time($format = "Y-m-d H:i:s") {
        $d = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $d->setTimeZone(new DateTimeZone("UTC"));
        return $d->format($format);
    }

}

/**
 * convert a UTC time to local timezon as defined on users setting
 * 
 * @param string $date_time
 * @param string $format
 * @return local date
 */
if (!function_exists('convert_date_utc_to_local')) {

    function convert_date_utc_to_local($date_time, $format = "Y-m-d H:i:s") {
        $date = new DateTime($date_time . ' +00:00');
        $date->setTimezone(new DateTimeZone(get_setting('timezone')));
        return $date->format($format);
    }

}

/**
 * get current users local time
 * 
 * @param string $format
 * @return local date
 */
if (!function_exists('get_my_local_time')) {

    function get_my_local_time($format = "Y-m-d H:i:s") {
        return date($format, strtotime(get_current_utc_time()) + get_timezone_offset());
    }

}

/**
 * convert time string to 24 hours format 
 * 01:00 AM will be converted as 13:00:00 
 * 
 * @param string $time  required time format = 01:00 AM/PM
 * @return 24hrs time
 */
if (!function_exists('convert_time_to_24hours_format')) {

    function convert_time_to_24hours_format($time = "00:00 AM") {
        if (!$time)
            $time = "00:00 AM";

        if (strpos($time, "AM")) {
            $time = trim(str_replace("AM", "", $time));
            $check_time = explode(":", $time);
            if ($check_time[0] == 12) {
                $time = "00:" . get_array_value($check_time, 1);
            }
        } else if (strpos($time, "PM")) {
            $time = trim(str_replace("PM", "", $time));
            $check_time = explode(":", $time);
            if ($check_time[0] > 0 && $check_time[0] < 12) {
                $time = $check_time[0] + 12 . ":" . get_array_value($check_time, 1);
            }
        }
        $time.=":00";
        return $time;
    }

}

/**
 * convert time string to 12 hours format 
 * 13:00:00 will be converted as 01:00 AM
 * 
 * @param string $time  required time format =  00:00:00
 * @return 12hrs time
 */
if (!function_exists('convert_time_to_12hours_format')) {

    function convert_time_to_12hours_format($time = "") {
        if ($time) {
            $am = " AM";
            $pm = " PM";
            if (get_setting("time_format") === "small") {
                $am = " am";
                $pm = " pm";
            }
            $check_time = explode(":", $time);
            $hour = $check_time[0] * 1;
            $minute = get_array_value($check_time, 1) * 1;
            $minute = ($minute < 10) ? "0" . $minute : $minute;

            if ($hour == 0) {
                $time = "12:" . $minute . $am;
            } else if ($hour == 12) {
                $time = $hour . ":" . $minute . $pm;
            } else if ($hour > 12) {
                $hour = $hour - 12;
                $hour = ($hour < 10) ? "0" . $hour : $hour;
                $time = $hour . ":" . $minute . $pm;
            } else {
                $hour = ($hour < 10) ? "0" . $hour : $hour;
                $time = $hour . ":" . $minute . $am;
            }
            return $time;
        }
    }

}

/**
 * prepare a decimal value from a time string
 * 
 * @param string $time  required time format =  00:00:00
 * @return number
 */
if (!function_exists('convert_time_string_to_decimal')) {

    function convert_time_string_to_decimal($time = "00:00:00") {
        $hms = explode(":", $time);
        return $hms[0] + (get_array_value($hms, "1") / 60) + (get_array_value($hms, "2") / 3600);
    }

}

/**
 * prepare a human readable time format from a decimal value of seconds
 * 
 * @param string $seconds
 * @return time
 */
if (!function_exists('convert_seconds_to_time_format')) {

    function convert_seconds_to_time_format($seconds = 0) {
        $is_negative = false;
        if ($seconds < 0) {
            $seconds = $seconds * -1;
            $is_negative = true;
        }
        $seconds = $seconds * 1;
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours * 3600)) / 60);
        $secs = floor($seconds % 60);

        $hours = ($hours < 10) ? "0" . $hours : $hours;
        $mins = ($mins < 10) ? "0" . $mins : $mins;
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $string = $hours . ":" . $mins . ":" . $secs;
        if ($is_negative) {
            $string = "-" . $string;
        }
        return $string;
    }

}

/**
 * get seconds form a given time string
 * 
 * @param string $time
 * @return seconds
 */
if (!function_exists('convert_time_string_to_second')) {

    function convert_time_string_to_second($time = "00:00:00") {
        $hms = explode(":", $time);
        return $hms[0] * 3600 + ($hms[1] * 60) + ($hms[2]);
    }

}


/**
 * convert a datetime string to relative time 
 * ex: $date_time = "2015-01-01 23:10:00" will return like this: Today at 23:10 PM
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date time
 */
if (!function_exists('format_to_relative_time')) {

    function format_to_relative_time($date_time, $convert_to_local = true, $is_short_date = false) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }

        $target_date = new DateTime($date_time);
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone(get_setting('timezone')));
        $today = $now->format("Y-m-d");
        $date = "";
        $short_date = "";
        if ($now->format("Y-m-d") == $target_date->format("Y-m-d")) {
            $date = lang("today_at");   //today
            $short_date = lang("today");
        } else if (date('Y-m-d', strtotime(' -1 day', strtotime($today))) === $target_date->format("Y-m-d")) {
            $date = lang("yesterday_at"); //yesterday
            $short_date = lang("yesterday");
        } else {
            $date = format_to_date($date_time);
            $short_date = format_to_date($date_time);
        }
        if ($is_short_date) {
            return $short_date;
        } else {
            if (get_setting("time_format") == "24_hours") {
                return $date . " " . $target_date->format("H:i");
            } else {
                return $date . " " . convert_time_to_12hours_format($target_date->format("H:i:s"));
            }
        }
    }

}

/**
 * convert a datetime string to date format as defined on settings
 * ex: $date_time = "2015-01-01 23:10:00" will return like this: Today at 23:10 PM
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date
 */
if (!function_exists('format_to_date')) {

    function format_to_date($date_time, $convert_to_local = true) {
        if (!$date_time) {
            return "";
        }

        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);
        return $target_date->format(get_setting('date_format'));
    }

}

/**
 * convert a datetime string to 12 hours time format
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return time
 */
if (!function_exists('format_to_time')) {

    function format_to_time($date_time, $convert_to_local = true) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);

        if (get_setting("time_format") == "24_hours") {
            return $target_date->format("H:i");
        } else {
            return convert_time_to_12hours_format($target_date->format("H:i:s"));
        }
    }

}

/**
 * convert a datetime string to datetime format as defined on settings
 * 
 * @param string $date_time .. it will be considered as UTC time.
 * @param string $convert_to_local .. to prevent conversion, pass $convert_to_local=false 
 * @return date time
 */
if (!function_exists('format_to_datetime')) {

    function format_to_datetime($date_time, $convert_to_local = true) {
        if ($convert_to_local) {
            $date_time = convert_date_utc_to_local($date_time);
        }
        $target_date = new DateTime($date_time);
        $date = $target_date->format(get_setting('date_format'));

        if (get_setting("time_format") == "24_hours") {
            return $date . " " . $target_date->format("H:i");
        } else {
            return $date . " " . convert_time_to_12hours_format($target_date->format("H:i:s"));
        }
    }

}



/**
 * return users local time (today)
 * 
 * @return date
 */
if (!function_exists('get_today_date')) {

    function get_today_date() {
        return date("Y-m-d", strtotime(get_my_local_time()));
    }

}


/**
 * return users local time (tomorrow)
 * 
 * @return date
 */
if (!function_exists('get_tomorrow_date')) {

    function get_tomorrow_date() {
        $today = get_today_date();
        return date('Y-m-d', strtotime($today . ' + 1 days'));
    }

}

/**
 * add days with a given date
 * 
 * $date should be Y-m-d
 * $period_type should be days/months/years/weeks
 * 
 * @return date
 */
if (!function_exists('add_period_to_date')) {

    function add_period_to_date($date, $no_of = 0, $period_type = "days") {
        return date('Y-m-d', strtotime("+$no_of $period_type", strtotime($date)));
    }

}

/**
 * subtract days from a given date
 * 
 * $date should be Y-m-d
 * $period_type should be days/months/years/weeks
 * 
 * @return date
 */
if (!function_exists('subtract_period_from_date')) {

    function subtract_period_from_date($date, $no_of = 0, $period_type = "days") {
        return date('Y-m-d', strtotime("-$no_of $period_type", strtotime($date)));
    }

}


/**
 * get date difference in days
 * 
 * $start_date && $end_date should be Y-m-d format
 * 
 * @return difference in days
 */
if (!function_exists('get_date_difference_in_days')) {

    function get_date_difference_in_days($start_date, $end_date) {

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        return $end->diff($start)->format("%a");
    }

}


/**
 * is online user? if the last online <= 1 minute then we'll assume that the user is online
 * 
 * $start_date && $end_date 
 * 
 * @return boolean
 */
if (!function_exists('is_online_user')) {

    function is_online_user($last_online = "") {

        if (!$last_online) {
            //if we don't get any last online status that means the user is offline
            return false;
        } else {
            //if last online <= 1 minute then we'll assume that the user is online

            $now = get_my_local_time();
            $last_online = convert_date_utc_to_local($last_online);

            $diff_seconds = abs(strtotime($now) - strtotime($last_online));
            if ($diff_seconds <= 60) {
                return true;
            } else {
                return false;
            }
        }
    }

}



/**
 * Check if the date string is not empty.
 * 
 * $date 
 * 
 * @return boolean
 */
if (!function_exists('is_date_exists')) {

    function is_date_exists($date = "") {

        if (!$date || $date == "NULL" || is_null($date)) {
            return false;
        } else {
            return true;
        }
    }

}