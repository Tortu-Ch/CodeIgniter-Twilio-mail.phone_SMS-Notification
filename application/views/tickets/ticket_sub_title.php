<div class="bg-white p15 pt0 b-b">
    <?php
    $ticket_labels = "";
    if ($ticket_info->labels && $this->login_user->user_type == "staff") {
        $labels = explode(",", $ticket_info->labels);
        foreach ($labels as $label) {
            $ticket_labels .= "<span class='label label-info'  title='$label'>" . $label . "</span> ";
        }
    }
    echo "<span class='mr15'>" . $ticket_labels . " </span>";
    ?>

    <span class="text-off"><?php echo lang("status") . ": "; ?></span>

    <?php
    $ticket_status_class = "label-danger";
    if ($ticket_info->status === "new") {
        $ticket_status_class = "label-warning";
    } else if ($ticket_info->status === "closed") {
        $ticket_status_class = "label-success";
    }

    if ($ticket_info->status === "client_replied" && $this->login_user->user_type === "client") {
        $ticket_info->status = "open"; //don't show client_replied status to client
    }

    $ticket_status = "<span class='label $ticket_status_class large'>" . lang($ticket_info->status) . "</span> ";
    echo $ticket_status;
    ?>
    <?php if ($this->login_user->user_type === "staff") { ?>
        <span class="text-off ml15"><?php echo lang("client") . ": "; ?></span>
        <?php echo $ticket_info->company_name ? anchor(get_uri("clients/view/" . $ticket_info->client_id), $ticket_info->company_name) : "-"; ?>
    <?php } ?>

    <?php if ($ticket_info->project_id != "0" && $show_project_reference == "1") { ?>
        <span class="text-off ml15"><?php echo lang("project") . ": "; ?></span>
        <?php echo $ticket_info->project_title ? anchor(get_uri("projects/view/" . $ticket_info->project_id), $ticket_info->project_title) : "-"; ?>
    <?php } ?>

    <span class="text-off ml15"><?php echo lang("created") . ": "; ?></span>
    <?php echo format_to_relative_time($ticket_info->created_at); ?> 

    <span class="text-off ml15"><?php echo lang("ticket_type") . ": "; ?></span>
    <?php echo $ticket_info->ticket_type; ?> 
    <?php
    if ($ticket_info->assigned_to && $this->login_user->user_type == "staff") {
        //show assign to field to team members only

        $image_url = get_avatar($ticket_info->assigned_to_avatar);
        $assigned_to_user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $ticket_info->assigned_to_user";
        ?>
        <span class="text-off ml15 mr10"><?php echo lang("assigned_to") . ": "; ?></span>
        <?php
        echo get_team_member_profile_link($ticket_info->assigned_to, $assigned_to_user);
    }
    ?>
</div>

<?php
if (count($custom_fields_list)) {
    $fields = "";
    foreach ($custom_fields_list as $data) {
        if ($data->value) {
            $fields .= "<div class='p15 bg-white b-b '><i class='fa fa-check-square ml15'></i> <span class='text-off'> $data->title:</span> " . $this->load->view("custom_fields/output_" . $data->field_type, array("value" => $data->value), true) . "</div>";
        }
    }
    if ($fields) {
        echo $fields;
    }
}