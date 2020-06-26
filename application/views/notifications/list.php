<div class="list-group" id="notificaion-popup-list" style="">
    <?php
    $view_data["notifications"] = $notifications;
    $this->load->view("notifications/list_data", $view_data);
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //don't apply scrollbar for mobile devices
        if ($(window).width() > 640) {
            if ($('#notificaion-popup-list').height() >= 400) {
                initScrollbar('#notificaion-popup-list', {
                    setHeight: 400
                });
            } else {
                $('#notificaion-popup-list').css({"overflow-y": "auto"});
            }

        }

    });
</script>
