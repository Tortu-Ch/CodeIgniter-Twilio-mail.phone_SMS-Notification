<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "integration";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>
        <div class="col-sm-9 col-lg-10">

            <div class="panel panel-default no-border clearfix ">

                <ul id="integration-tab" data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                    <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo lang("integration"); ?></h4></li>
                    <li><a role="presentation" class="active" href="<?php echo_uri("settings/re_captcha/"); ?>" data-target="#integration-re-captcha">reCAPTCHA</a></li>
                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="integration-re-captcha"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#integration-tab .active").trigger("click");
    });

</script>