<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('leaves'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("leaves/apply_leave_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('apply_leave'), array("class" => "btn btn-default", "title" => lang('apply_leave'))); ?>
                <?php echo modal_anchor(get_uri("leaves/assign_leave_modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('assign_leave'), array("class" => "btn btn-default", "title" => lang('assign_leave'))); ?>
            </div>
        </div>
        <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white inner" role="tablist">
            <li><a  role="presentation" class="active" href="<?php echo_uri("leaves/pending_approval/"); ?>" data-target="#leave-pending-approval"><?php echo lang("pending_approval"); ?></a></li>
            <li><a  role="presentation" href="<?php echo_uri("leaves/all_applications/"); ?>" data-target="#leave-all-applications"><?php echo lang("all_applications"); ?></a></li>
            <li><a  role="presentation" href="<?php echo_uri("leaves/summary/"); ?>" data-target="#leave-summary"><?php echo lang("summary"); ?></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade active" id="leave-pending-approval"></div>
            <div role="tabpanel" class="tab-pane fade" id="leave-all-applications"></div>
            <div role="tabpanel" class="tab-pane fade" id="leave-summary"></div>
        </div>
    </div>
</div>