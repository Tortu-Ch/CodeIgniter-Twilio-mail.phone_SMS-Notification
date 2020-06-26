<div class="panel">
    <div class="panel-heading bg-info p30">
        <br />
    </div>
    <div class="clearfix text-center">
        <div class="mt-50 chart-circle">
            <span class="chart" data-size="100" data-percent="<?php echo $project_progress; ?>"  data-scale-color="transparent" data-bar-color="#16AAD8" >
                <span class="percent chart-label" style="width: 100px; margin-top: 40px;"></span>
            </span>
        </div>
    </div>

    <div class="p10 b-t b-b">
        <?php echo lang("start_date"); ?>: <?php echo is_date_exists($project_info->start_date) ? format_to_date($project_info->start_date) : "-"; ?>
    </div>
    <div class="p10 b-b">
        <?php echo lang("deadline"); ?>: <?php echo is_date_exists($project_info->deadline) ? format_to_date($project_info->deadline) : "-"; ?>
    </div>
    <?php if ($this->login_user->user_type === "staff") { ?>
        <div class="p10">
            <?php echo lang("client"); ?>: <?php echo anchor(get_uri("clients/view/" . $project_info->client_id), $project_info->company_name); ?>
        </div>
    <?php } else { ?>
        <div class="p10">
            <?php echo lang("status"); ?>: <?php echo lang($project_info->status); ?>
        </div>
    <?php } ?>
</div>


<script>
    $(function () {
        $('.chart').easyPieChart({
            trackColor: "#f2f2f2",
            lineWidth: 3, lineCap: 'butt',
            onStep: function (from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent) + "%");
            }
        });
    });
</script>
