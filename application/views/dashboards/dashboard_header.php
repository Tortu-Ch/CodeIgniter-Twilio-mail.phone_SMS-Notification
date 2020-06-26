<?php
if (!isset($dashboard_info)) {
    $dashboard_info = new stdClass();
}

$title = lang("dashboard");
$color = "#fff";
$selected_dashboard = "border-circle";
if ($dashboard_type == "custom") {
    $title = $dashboard_info->title;
    $color = $dashboard_info->color;
    $selected_dashboard = "";
}
?>

<div class="clearfix mb15 dashbaord-header-area">

    <div class="clearfix pull-left">
        <span class="pull-left p10 pl0">
            <span style="background-color: <?php echo $color; ?>" class="color-tag border-circle"></span>
        </span>
        <h4 class="pull-left"><?php echo $title; ?></h4>
    </div>

    <div class="pull-right clearfix">
        <span class="pull-right dropdown dashboard-dropdown ml10">
            <div class="dropdown-toggle clickable" type="button" data-toggle="dropdown" aria-expanded="true" >
                <i class="fa fa-ellipsis-h"></i>
            </div>
            <ul class="dropdown-menu" role="menu">
                <?php if ($dashboard_type == "default") { ?>
                    <li role="presentation"><?php echo modal_anchor(get_uri("dashboard/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_new_dashboard'), array("title" => lang('add_new_dashboard'))); ?> </li>
                <?php } else { ?>
                    <li role="presentation"><?php echo anchor(get_uri("dashboard/edit_dashboard/" . $dashboard_info->id), "<i class='fa fa-columns'></i> " . lang('edit_dashboard'), array("title" => lang('edit_dashboard'))); ?> </li>
                    <li role="presentation"><?php echo modal_anchor(get_uri("dashboard/modal_form/" . $dashboard_info->id), "<i class='fa fa-pencil'></i> " . lang('edit_title'), array("title" => lang('edit_title'), "id" => "dashboard-edit-title-button")); ?> </li>
                    <li role="presentation"><?php echo js_anchor("<i class='fa fa-times fa-fw'></i>" . lang('delete'), array('title' => lang('delete'), "class" => "delete", "data-id" => $dashboard_info->id, "data-action-url" => get_uri("dashboard/delete"), "data-action" => "delete-confirmation", "data-success-callback" => "onDashboardDeleteSuccess")); ?> </li>
                <?php } ?>
            </ul>
        </span>

        <span class="pull-right">
            <?php
            echo anchor(get_uri("dashboard"), "<span class='clickable p10 mr5 inline-block'><span style='background-color: #fff' class='color-tag $selected_dashboard'  title='" . lang("default_dashboard") . "'></span></span>");

            if ($dashboards) {
                foreach ($dashboards as $dashboard) {
                    $selected_dashboard = "";

                    if ($dashboard_type == "custom") {
                        if ($dashboard_info->id == $dashboard->id) {
                            $selected_dashboard = "border-circle";
                        }
                    }

                    $color = $dashboard->color ? $dashboard->color : "#83c340";

                    echo anchor(get_uri("dashboard/view/" . $dashboard->id), "<span class='clickable p10 mr5 inline-block'><span style='background-color: $color' class='color-tag $selected_dashboard' title='$dashboard->title'></span></span>");
                }
            }
            ?>
        </span>

    </div>
</div>