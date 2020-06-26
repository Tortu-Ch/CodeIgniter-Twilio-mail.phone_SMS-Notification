<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "notifications";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="panel panel-default">
                <div class="page-title clearfix">
                    <h4> <?php echo lang('notification_settings'); ?></h4>
                </div>
                <div class="table-responsive">
                    <table id="notification-settings-table" class="display" cellspacing="0" width="100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#notification-settings-table").appTable({
            source: '<?php echo_uri("settings/notification_settings_list_data") ?>',
            filterDropdown: [{name: "category", class: "w200", options: <?php echo $categories_dropdown; ?>}],
            columns: [
                {visible: false},
                {title: '<?php echo lang("event"); ?>', class: "w30p"},
                {title: '<?php echo lang("notify_to"); ?>'},
                {title: '<?php echo lang("category"); ?>', class: "w10p"},
                {title: '<?php echo lang("enable_email"); ?>', class: "w10p text-center"},
                {title: '<?php echo lang("enable_web"); ?>', class: "w10p text-center"},
                {title: '<?php echo lang("enable_sms"); ?>', class: "w10p text-center"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w50"}
            ],
            order: [[0, "asc"]],
            displayLength: 100
        });
    });
</script>