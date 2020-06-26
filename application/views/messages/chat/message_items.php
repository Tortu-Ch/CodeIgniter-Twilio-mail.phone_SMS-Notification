<?php

foreach ($replies as $reply_info) {
    $this->load->view("messages/chat/single_message", array("reply_info" => $reply_info));
}

if ($is_online) {
    ?>
    <script class="temp-script">
        $("#js-active-chat-online-icon").removeClass("hide");
        $(".temp-script").remove();
        $("#is_user_online").val("1");
    </script>
    <?php

} else {
    ?>
    <script class="temp-script">
            $("#js-active-chat-online-icon").addClass("hide");
            $(".temp-script").remove();
            $("#is_user_online").val("0");
    </script>
    <?php

}