<?php

if ($files && count($files)) {

    $timeline_file_path = get_setting("timeline_file_path");
    $total_files = count($files);
    echo "<div class='timeline-images mb15'>";
    $file_name = $files[0]['file_name'];
    $more_image = "";
    if ($total_files > 1) {
        $more_count = $total_files - 1;
        $more_image = "<span class='more'>+" . $more_count . " " . lang('more') . "</span>";
    }

    $shown_preview_image = false;
    $is_localhost = is_localhost();

    foreach ($files as $file) {
        $file_name = $file['file_name'];
        $url = get_file_uri($timeline_file_path . $file_name);
        $image = "";
        $actual_file_name = remove_file_prefix($file_name);
        if (is_viewable_video_file($file_name)) {

            if (!$shown_preview_image) {
                $image = "<img src='" . get_file_uri("assets/images/video_preview.jpg") . "' alt='video'/>$more_image";
                $shown_preview_image = true;
            }
            echo "<a href='$url' data-title='" . $actual_file_name . "' class='mfp-iframe'>$image</a>";
        } else if (is_viewable_image_file($file_name)) {

            if (!$shown_preview_image) {
                $image = "<img src='$url' alt='$file_name'/>$more_image";
                $shown_preview_image = true;
            }
            echo "<a href='$url' class='mfp-image' data-title='" . $actual_file_name . "'>$image</a>";
        } else {
            if (!$shown_preview_image) {
                $image = "<img src='" . get_file_uri("assets/images/file_preview.jpg") . "' alt='file'/>$more_image";
                $shown_preview_image = true;
            }
            if (!$is_localhost && is_google_preview_available($file_name)) {
                echo "<a data-viewer='google' href='https://drive.google.com/viewerng/viewer?url=$url?pid=explorer&efh=false&a=v&chrome=false&embedded=true' class='mfp-iframe' data-title='" . $actual_file_name . "'>$image</a>";
            } else {
                $uid = uniqid(rand());
                echo "<a href='#$uid' class='mfp-inline' data-title='" . $actual_file_name . "'>" . $image . "</a>" . '<div id="' . $uid . '" class="mfp-hide container max-w500 text-center p20 bg-white">' . lang("file_preview_is_not_available") . '<div class="text-off">' . $actual_file_name . '</div>' . '</div>';
            }
        }
    }
    echo "</div>";
}