<div class="panel clearfix <?php
if (isset($page_type) && $page_type === "full") {
    echo "m20";
}
?>">
    <ul data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li class="title-tab"><h4 class="pl15 pt10 pr15">
                <?php
                if ($this->login_user->id === $applicant_id) {
                    echo lang("my_leave");
                } else {
                    echo lang("leaves");
                }
                ?>
            </h4>
        </li>
        <li><a id="monthly-leaves-button"  role="presentation" class="active" href="javascript:;" data-target="#team_member-monthly-leaves"><?php echo lang("monthly"); ?></a></li>
        <li><a role="presentation" href="<?php echo_uri("team_members/yearly_leaves/"); ?>" data-target="#team_member-yearly-leaves"><?php echo lang('yearly'); ?></a></li>
        <?php if ($this->login_user->id === $applicant_id) { ?>
            <div class="tab-title clearfix no-border">
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri('leaves/apply_leave_modal_form'), "<i class='fa fa-plus-circle'></i> " . lang('apply_leave'), array("class" => "btn btn-default", "title" => lang('apply_leave'))); ?>
                </div>
            </div>    
        <?php } ?>

    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="team_member-monthly-leaves">
            <table id="monthly-leaves-table" class="display" cellspacing="0" width="100%">            
            </table>
            <script type="text/javascript">
                loadMembersLeavesTable = function(selector, dateRange) {
                    $(selector).appTable({
                        source: '<?php echo_uri("leaves/all_application_list_data") ?>',
                        dateRangeType: dateRange,
                        filterParams: {applicant_id: "<?php echo $applicant_id; ?>"},
                        columns: [
                            {targets: [1], visible: false, searchable: false},
                            {title: '<?php echo lang("leave_type") ?>'},
                            {title: '<?php echo lang("date") ?>', "class": "w20p"},
                            {title: '<?php echo lang("duration") ?>', "class": "w20p"},
                            {title: '<?php echo lang("status") ?>', "class": "w15p"},
                            {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
                        ],
                        printColumns: [1, 2, 3, 4],
                        xlsColumns: [1, 2, 3, 4]
                    });
                };

                $(document).ready(function() {
                    $("#monthly-leaves-button").trigger("click");
                    loadMembersLeavesTable("#monthly-leaves-table", "monthly");
                });
            </script>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="team_member-yearly-leaves"></div>
    </div>
</div>