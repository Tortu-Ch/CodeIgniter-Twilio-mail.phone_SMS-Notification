<div id="js-chat-messages-title">
    <?php
    $me = $this->login_user->id;
    echo "<strong class='p10 block chat-message-title'>" . lang("subject") . ": " . $first_message->subject . "</strong>";
    $this->load->view("messages/chat/single_message", array("reply_info" => $first_message));
    ?>

</div>
<div id="js-chat-old-messages">

</div>
