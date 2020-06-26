<div class="rise-chat-header box">
    <!--    <div class="box-content chat-back">
            <i class="fa fa-chevron-left"></i>
        </div>-->

    <div class="box-content">
        <ul class="chat-tab p0 m0 nav nav-tabs box"  data-toggle="ajax-tab" role="tablist">

            <li class="box-content" id="chat-inbox-tab-button">
                <a role="presentation" href="#" data-target="#chat-inbox-tab"><i class="fa fa-comments"></i></a>
            </li>

            <?php if ($show_users_list) { ?>
                <li class="box-content" id="chat-users-tab-button">
                    <a role="presentation"  href="<?php echo_uri("messages/users_list/staff"); ?>" data-target="#chat-users-tab"> <i class="fa fa-user  "></i></a>
                </li>
            <?php } ?>
                
            <?php if ($show_clients_list) { ?>
                <li class="box-content" id="chat-clients-tab-button">
                    <a role="presentation"  href="<?php echo_uri("messages/users_list/client"); ?>" data-target="#chat-clients-tab"><i class="fa fa-briefcase  "></i></a>
                </li>
            <?php } ?>

        </ul>
    </div>

</div>


<div class="rise-chat-body long clearfix">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="chat-inbox-tab">
            <?php $this->load->view("messages/chat/chat_list", array("messages" => $messages)); ?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="chat-users-tab"></div>
        <div role="tabpanel" class="tab-pane fade" id="chat-clients-tab"></div>
    </div>
</div>