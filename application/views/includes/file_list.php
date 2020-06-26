<?php

if (isset($files) && $files) {
    $files = unserialize($files);
    if (count($files)) {
        foreach ($files as $file) {
            $file_name = get_array_value($file, "file_name");
            echo "<div class='box saved-file-item-container'><div class='box-content w80p pt5 pb5'>" . remove_file_prefix($file_name) . "</div> <div class='box-content w20p text-right'><a href='#' class='delete-saved-file p5 dark' data-file_name='$file_name'><span class='fa fa-close'></span></a></div> </div>";
        }
    }
}
