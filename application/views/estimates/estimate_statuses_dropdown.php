<?php

$estimate_statuses_dropdown = array(
    array("id" => "", "text" => "- " . lang("status") . " -"),
    array("id" => "draft", "text" => lang("draft")),
    array("id" => "sent", "text" => lang("sent")),
    array("id" => "accepted", "text" => lang("accepted")),
    array("id" => "declined", "text" => lang("declined"))
);
echo json_encode($estimate_statuses_dropdown);
