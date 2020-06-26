<?php

if ($value) {
    $value = explode(",", $value);
    $output = "";
    foreach ($value as $v) {
        if ($output)
            $output.=", ";
        $output.=$v;
    }
    echo $output;
};
