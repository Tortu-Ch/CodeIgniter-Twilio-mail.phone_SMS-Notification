<div class="rise-chat-header box">
    <div class="box-content chat-back" id="js-back-to-chat-tabs">
        <i class="fa fa-chevron-left"></i>
    </div>
    <div class="box-content chat-title">
        <div><?php
            $hide_online_icon = " hide";

            if (is_online_user($message_info->another_user_last_online)) {
                $hide_online_icon = "";
            }


            $user_id = "";
            if ($message_info->from_user_id == $this->login_user->id) {
                $user_id = $message_info->to_user_id;
            } else {
                $user_id = $message_info->from_user_id;
            }

            echo "<i id='js-active-chat-online-icon' class='online $hide_online_icon' data-user_id='$user_id'></i> ";


            if ($message_info->another_user_id === $this->login_user->id) {
                echo $message_info->user_name;
            } else {
                echo $message_info->another_user_name;
            }
            ?>
        </div>
    </div>
</div>
<div id="js-chat-messages-container" class="rise-chat-body clearfix"></div>
<div class="rise-chat-footer">
    <div id="chat-reply-form-dropzone" class="post-dropzone">
        <?php echo form_open(get_uri("messages/reply/1"), array("id" => "chat-message-reply-form", "class" => "general-form", "role" => "form")); ?>


        <?php $this->load->view("includes/dropzone_preview"); ?>    


        <input type="hidden" id="is_user_online" name="is_user_online" value="<?php echo is_online_user($message_info->another_user_last_online) ? 1 : 0; ?>">
        <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
        <input type="hidden" name="last_message_id" value="">
        <span class="chat-file-upload-icon upload-file-button"><i class="fa fa-camera"></i></span>
            <?php
            echo form_textarea(array(
                "id" => "js-chat-message-textarea",
                "name" => "reply_message",
                "data-rule-required" => true,
                "autofocus" => true,
                "data-msg-required" => "",
                "placeholder" => lang('write_a_message')
            ));
            ?>

        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var textarea = document.querySelector('.rise-chat-footer textarea');
        textarea.addEventListener('keydown', autosizeRISEChatBox);
        function autosizeRISEChatBox() {
            var el = this;
            setTimeout(function () {
                if (el.scrollHeight < 110) {
                    $(".rise-chat-body").height(330 - el.scrollHeight);
                    el.style.cssText = 'height:' + el.scrollHeight + 'px';
                }
            });
        }




        loadMessages(1);
        $('.rise-chat-header').mousedown(handle_mousedown);
        $("#js-chat-message-textarea").keypress(function (e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                $("#chat-message-reply-form").submit();
                $(this).attr("style", "")
                return false;
            }
        });
        var uploadUrl = "<?php echo get_uri("messages/upload_file"); ?>";
        var validationUrl = "<?php echo get_uri("messages/validate_message_file"); ?>";
        var dropzone = attachDropzoneWithForm("#chat-reply-form-dropzone", uploadUrl, validationUrl);
        $("#chat-message-reply-form").appForm({
            isModal: false,
            beforeAjaxSubmit: function (data) {

                //send the last message id
                $.each(data, function (index, obj) {
                    if (obj.name === "last_message_id") {
                        data[index]["value"] = $(".chat-msg").last().attr("data-message_id");
                    }
                });
                //clear message input box
                $("#js-chat-message-textarea").val("");
            },
            onSuccess: function (response) {
                if (dropzone) {
                    dropzone.removeAllFiles();
                }
                if (response.success) {
                    renderMessages(response.data);
                }

            }
        });


        //set focus

        $("#js-chat-message-textarea").focus();

        $("#js-back-to-chat-tabs").click(function () {
            loadChatTabs(); // this method should be loaded when chat box loaded

            //reset the previous interval timer
            if (window.activeChatChecker) {
                window.clearInterval(window.activeChatChecker);
            }
        });
        //bind scroll with chat messages and load more messages when scrolling on top
        var fatchNewData = true,
                topMessageId = 0;
        $("#js-chat-messages-container").scroll(function () {
            if ($(this).scrollTop() < 50 && fatchNewData) {
                fatchNewData = false;
                loadMoreMessages(function () {
                    fatchNewData = true; //reset the status so that it can call again
                });
            }
        });




    });
    function handle_mousedown(e) {
        var dragging = {};
        dragging.pageX0 = e.pageX;
        dragging.pageY0 = e.pageY;
        dragging.offset0 = $(this).offset();
        function handleDragging(e) {
            var left = dragging.offset0.left + (e.pageX - dragging.pageX0);
            var top = dragging.offset0.top + (e.pageY - dragging.pageY0);
            $(".rise-chat-wrapper").offset({top: top, left: left});
        }

        function handleMouseup(e) {
            $('body').off('mousemove', handleDragging).off('mouseup', handleMouseup);
        }
        $('body').on('mouseup', handleMouseup).on('mousemove', handleDragging);
    }

    function chatScrollToBottom() {
        //scroll to bottom only if the foucs on textarea
        var $focused = $(':focus');
        if ($focused && $focused.is("textarea")) {
            $(".rise-chat-body").animate({scrollTop: 10000000}, 100);
        }
    }

    function loadMessages(firstLoad) {
        checkNewMessagesAutomatically();
        var message_id = "<?php echo $message_id; ?>";
        $.ajax({
            url: "<?php echo get_uri('messages/view_chat'); ?>",
            type: "POST",
            data: {
                message_id: message_id,
                last_message_id: $(".js-chat-msg").last().attr("data-message_id"),
                is_first_load: firstLoad,
                another_user_id: $("#js-active-chat-online-icon").attr("data-user_id")
            },
            success: function (response) {
                if (response) {
                    renderMessages(response);
                }

            }
        });
    }

    function loadMoreMessages(callback) {
        if($("#js-chat-old-messages").attr("no-messages")==="1") return false; //there is no messages to show.
        
        var message_id = "<?php echo $message_id; ?>";

        $("#js-chat-old-messages").prepend("<div id='loading-more-chat-messages-" + message_id + "' class='inline-loader' >....<br></br></div>");

        $.ajax({
            url: "<?php echo get_uri('messages/view_chat'); ?>",
            type: "POST",
            data: {
                message_id: "<?php echo $message_id; ?>",
                top_message_id: $(".js-chat-msg").first().attr("data-message_id"),
                another_user_id: $("#js-active-chat-online-icon").attr("data-user_id")
            },
            success: function (response) {
                if (response) {
                    $("#js-chat-old-messages").prepend(response);
                    if (callback) {
                        callback(); //has more data?
                    }
                }
                
                //if we got empty message, then we'll add a flag to stop finding new messages for next calls.
                if(!$(response).find("#temp-script").remove().text()){
                    $("#js-chat-old-messages").attr("no-messages","1");  
                }
                
                

                $('#loading-more-chat-messages-' + message_id).remove();

            }
        });
    }


    function renderMessages(html) {
        $("#js-chat-messages-container").append(html);
        chatScrollToBottom();
    }


    //reset existing timmer and check new message after a certain time
    function checkNewMessagesAutomatically() {

        //reset the previous interval timer
        if (window.activeChatChecker) {
            window.clearInterval(window.activeChatChecker);
        }

        window.activeChatChecker = window.setInterval(function () {
            loadMessages();
        }, 5000); //check message in every 5 seconds
    }




</script>  
