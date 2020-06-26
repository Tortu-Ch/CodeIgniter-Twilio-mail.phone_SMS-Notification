<?php

foreach ($replies as $reply_info) {
    $this->load->view("messages/reply_row", array("reply_info" => $reply_info));
} 