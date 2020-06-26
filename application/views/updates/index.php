<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "updates";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="panel panel-default">
                <div class="page-title clearfix">
                    <h4> <?php echo lang('updates'); ?></h4>
                    <div class="title-button-group">
                        <?php echo "<a href='" . get_setting("app_update_url") . "/info' data-title='Info' class='update-instruction btn btn-info font-18' style='padding:2px 10px'><i class='fa fa-info-circle'></i></a>"; ?>
                    </div>
                </div>

                <div id="app-update-container" class="panel-body font-14">
                    <p>
                        <strong><?php echo lang("current_version") . " : " . $current_version; ?></strong>
                    </p>

                    <?php if (count($installable_updates) || count($downloadable_updates)) { ?>

                        <script type='text/javascript'>
                            $(document).ready(function () {
                                appAlert.warning("Please backup all files and database before start the installation.", {container: "#app-update-container", animate: false});
                                $(".app-alert-message").css("max-width", 1000);
                            });
                        </script>

                        <?php
                        foreach ($installable_updates as $salt => $version) {
                            echo "<p><a class='do-update' data-version='$version' href='#'>Click here to Install the version - <b>$version</b></a></p>";
                        }
                        foreach ($downloadable_updates as $salt => $version) {
                            echo "<p class='download-updates' data-salt='$salt' data-version='$version'>Version - <b>$version</b> available, awaiting for download.</p>";
                        }
                    } else {
                        echo "<p>No updates found.</p>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var startDownload = function () {
            var $link = $(".download-updates").first(),
                    version = $link.attr("data-version"),
                    salt = $link.attr("data-salt");

            if ($link.length) {
                $link.replaceWith("<p class='downloading downloading-" + version + "'><span class='download-loader inline-loader inline-block'>.....</span> Downloading the version - <b>" + version + "</b>. Please wait...</p>");
                $.ajax({
                    url: "<?php echo_uri("updates/download_updates/"); ?>" + "/" + version + "/" + salt,
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            $(".downloading").html("<a class='do-update' data-version='" + version + "' href='#'>Click here to Install the version - <b>" + version + "</b></a>").removeClass("downloading");
                            startDownload();
                        } else {
                            $(".downloading").html("<p>" + response.message + "</p>").removeClass("downloading").addClass("alert alert-danger");
                        }
                    }
                });
            }
        };
        startDownload();


        $('body').on('click', '.do-update', function () {
            var version = $(this).attr("data-version");
            $("#app-update-container").html("<h3><span class='inline-loader inline-block'>.....</span> Installing version - " + version + ". Please wait... </h3>");
            $.ajax({
                url: "<?php echo_uri("updates/do_update/"); ?>" + "/" + version,
                dataType: "json",
                success: function (response) {
                    $("#app-update-container").html("");
                    if (response.success) {
                        appAlert.success(response.message, {container: "#app-update-container", animate: false});
                    } else {
                        appAlert.error(response.message, {container: "#app-update-container", animate: false});
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        });

        $('.update-instruction').magnificPopup({
            type: 'iframe'
        });
    });
</script>