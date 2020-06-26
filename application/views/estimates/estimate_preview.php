<div id="page-content" class="p20 clearfix">
    <?php
    load_css(array(
        "assets/css/invoice.css",
    ));
    ?>

    <div class="invoice-preview">
        <?php
        if ($this->login_user->user_type === "client" && $estimate_info->status == "new") {
            ?>

            <div class = "panel panel-default  p15 no-border clearfix">

                <div class="mr15 strong pull-left">
                    <?php echo ajax_anchor(get_uri("estimates/update_estimate_status/$estimate_info->id/accepted"), "<i class='fa fa fa-check-circle'></i> " . lang('mark_as_accepted'), array("class" => "btn btn-success mr15", "title" => lang('mark_as_accepted'), "data-reload-on-success" => "1")); ?>
                    <?php echo ajax_anchor(get_uri("estimates/update_estimate_status/$estimate_info->id/declined"), "<i class='fa fa-times-circle-o'></i> " . lang('mark_as_rejected'), array("class" => "btn btn-danger mr15", "title" => lang('mark_as_rejected'), "data-reload-on-success" => "1")); ?>
                </div>
                <div class="pull-right">
                    <?php
                    echo "<div class='text-center'>" . anchor("estimates/download_pdf/" . $estimate_info->id, lang("download_pdf"), array("class" => "btn btn-default round")) . "</div>";
                    ?>
                </div>

            </div>

            <?php
        } else if ($this->login_user->user_type === "client") {

            echo "<div class='text-center'>" . anchor("estimates/download_pdf/" . $estimate_info->id, lang("download_pdf"), array("class" => "btn btn-default round")) . "</div>";
        }
        if ($show_close_preview)
            echo "<div class='text-center'>" . anchor("estimates/view/" . $estimate_info->id, lang("close_preview"), array("class" => "btn btn-default round")) . "</div>"
            ?>

        <div class="bg-white mt15 p30">
            <div class="col-md-12">
                <div class="ribbon"><?php echo $estimate_status_label; ?></div>
            </div>

            <?php
            echo $estimate_preview;
            ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#payment-amount").change(function () {
            var value = $(this).val();
            $(".payment-amount-field").each(function () {
                $(this).val(value);
            });
        });
    });



</script>
