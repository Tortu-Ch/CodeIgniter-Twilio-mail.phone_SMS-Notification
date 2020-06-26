<?php

$invoice_statuses_dropdown = array(
    array("id" => "", "text" => "- " . lang("status") . " -"),
    array("id" => "overdue", "text" => lang("overdue")),
    array("id" => "draft", "text" => lang("draft")),
    array("id" => "not_paid", "text" => lang("not_paid")),
    array("id" => "partially_paid", "text" => lang("partially_paid")),
    array("id" => "fully_paid", "text" => lang("fully_paid"))
);
echo json_encode($invoice_statuses_dropdown);
?>