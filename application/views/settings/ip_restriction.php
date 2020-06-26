<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "ip_restriction";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <?php echo form_open(get_uri("settings/save_ip_settings"), array("id" => "ip-settings-form", "class" => "general-form", "role" => "form")); ?>
            <div class="panel">
                <div class="panel-default panel-heading">
                    <h4><?php echo lang("ip_restriction"); ?></h4>
                </div>

                <div class="form-group">
                    <div class="p15 col-md-12 clearfix">
                        <strong> <?php echo lang("allow_timecard_access_from_these_ips_only"); ?></strong>
                    </div>
                    <div class=" col-md-12 clearfix">
                        <?php
                        echo form_textarea(array(
                            "id" => "allowed_ip_addresses",
                            "name" => "allowed_ip_addresses",
                            "value" => get_setting("allowed_ip_addresses"),
                            "class" => "form-control",
                            "style" => "min-height:100px"
                        ));
                        ?>
                    </div>
                    <div class="pt5 col-md-12 clearfix">
                        <i class="fa fa-info-circle"></i> <?php echo lang("enter_one_ip_per_line"); ?>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#ip-settings-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });
    });
</script>