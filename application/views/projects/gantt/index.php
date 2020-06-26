<div class="panel">
    <div class="tab-title clearfix">
        <h4><?php echo lang('gantt'); ?></h4>
        <div class="pull-right p10 mr10">
            <?php
            if ($show_project_members_dropdown) {
                echo lang("group_by") . " : ";
                echo form_dropdown("gantt-group-by", array("milestones" => lang("milestones"), "members" => lang("team_members")), array(), "class='select2 w200 mr10 reload-gantt' id='gantt-group-by'");

                echo form_input(array(
                    "id" => "gantt-members-dropdown",
                    "name" => "gantt-members-dropdown",
                    "class" => "select2 w200 reload-gantt hide",
                    "placeholder" => lang('team_member')
                ));
            }
            ?>
            <?php
            echo form_input(array(
                "id" => "gantt-milestone-dropdown",
                "name" => "gantt-milestone-dropdown",
                "class" => "select2 w200 reload-gantt",
                "placeholder" => lang('milestone')
            ));
            ?>
            <?php
            echo form_input(array(
                "id" => "gantt-status-dropdown",
                "name" => "gantt-status-dropdown",
                "class" => "select2 w200 reload-gantt ml10",
                "placeholder" => lang('status')
            ));
            ?>
        </div>
    </div>
    <div class="w100p pt10">
        <div id="gantt-chart" style="width: 100%;"></div>
    </div>

</div>

<script type="text/javascript">
    var loadGantt = function (group_by, id, status) {
        group_by = group_by || "milestones";
        id = id || "0";
        status = status || "";

        $("#gantt-chart").html("<div style='height:100px;'></div>");
        appLoader.show({container: "#gantt-chart", css: "right:50%;"});

        $("#gantt-chart").ganttView({
            dataUrl: "<?php echo get_uri("projects/gantt_data/" . $project_id); ?>" + "/" + group_by + "/" + id + "/"+ status,
            monthNames: AppLanugage.months,
            dayText: "<?php echo lang('day'); ?>",
            daysText: "<?php echo lang('days'); ?>"
        });
    };

    $(document).ready(function () {
        var $ganttGroupBy = $("#gantt-group-by"),
                $ganttMilestone = $("#gantt-milestone-dropdown"),
                $ganttMembers = $("#gantt-members-dropdown"),
                $ganttStatus = $("#gantt-status-dropdown");

        $ganttGroupBy.select2();
       
        $ganttMilestone.select2({
            data: <?php echo $milestone_dropdown; ?>
        });

        if ($ganttMembers.length) {
            $ganttMembers.select2({
                data: <?php echo $project_members_dropdown; ?>
            });
        }


        $ganttStatus.select2({
            data: <?php echo $status_dropdown; ?>
        });



        $(".reload-gantt").change(function () {
            var group_by = $ganttGroupBy.val() || "milestones",
                    id = 0,
                    status = $ganttStatus.val() ;

            if (group_by === "milestones") {
                $ganttMilestone.removeClass("hide");
                id = $ganttMilestone.val();
                $ganttMembers.addClass("hide");
            } else {
                $ganttMembers.removeClass("hide");
                id = $("#gantt-members-dropdown").val();
                $ganttMilestone.addClass("hide");
            }

            loadGantt(group_by, id, status);
        });

        loadGantt();
    });
</script>