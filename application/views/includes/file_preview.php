<?php if ($is_image_file) { ?>
    <img src="<?php echo $file_url; ?>" />
    <?php
} else if (is_localhost() || !$is_google_preview_available) {
    //don't show google preview in localhost
    echo lang("file_preview_is_not_available") . "<br />";
    echo anchor($file_url, lang("download"));
} else {
    ?>
    <iframe id='google-file-viewer' src="https://drive.google.com/viewerng/viewer?url=<?php echo $file_url; ?>?pid=explorer&efh=false&a=v&chrome=false&embedded=true" style="width: 100%; margin: 0; border: 0;"></iframe>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#google-file-viewer").css({height: $(window).height() + "px"});
            $(".app-modal .expand").hide();
        });
    </script>
<?php } ?>