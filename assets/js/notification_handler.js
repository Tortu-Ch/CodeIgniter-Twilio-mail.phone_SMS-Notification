checkNotifications = function (params, updateStatus) {
    if (params && params.notificationUrl) {
        var data = {check_notification: 1};
        if (params.isMessageNotification) {
            data = {active_message_id: getCookie("active_chat_id")};
        }

        $.ajax({
            url: params.notificationUrl,
            type: "POST",
            data: data,
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    if (result.total_notifications && result.total_notifications * 1) {

                        //for new message notification, we'll also change the color of the chat icon.
                        if (params.isMessageNotification && window.prepareUnreadMessageChatBox) {
                            window.prepareUnreadMessageChatBox(result.total_notifications);
                        }

                        params.notificationSelector.html("<i class='fa " + params.icon + "'></i> <span class='badge bg-danger up'>" + result.total_notifications + "</span>");

                        //compaire if there are new notifications, if so, show the push notification
                        if (params.showPushNotification && params.notificationSelector.attr("data-total") != result.total_notifications) {

                            //play a notification sound
                            var notificationSoundVolume = Number("0." + AppHelper.settings.notificationSoundVolume) || 0;
                            if (notificationSoundVolume) {
                                try {
                                    document.getElementById("notificationPlayer").volume = notificationSoundVolume;
                                    document.getElementById("notificationPlayer").play();
                                } catch (err) {
                                }
                            }

                            //show push notification

                        }

                        params.notificationSelector.attr("data-total", result.total_notifications);


                    }

                    params.notificationSelector.parent().find(".dropdown-details").html(result.notification_list);

                    if (updateStatus) {
                        //update last notification checking time
                        $.ajax({
                            url: params.notificationStatusUpdateUrl,
                            success: function () {
                                params.notificationSelector.html("<i class='fa " + params.icon + "'></i>");
                            }
                        });
                    }


                }
                if (!updateStatus) {
                    //check notification again after sometime
                    var check_notification_after_every = params.checkNotificationAfterEvery;
                    check_notification_after_every = check_notification_after_every * 1000;
                    if (check_notification_after_every < 10000) {
                        check_notification_after_every = 10000; //don't allow to call this requiest before 10 seconds
                    }

                    //overwrite the settings since we added the chat module.
                    //for chat, it should be 5000
                    if (params.isMessageNotification) {
                        check_notification_after_every = 5000;
                    }

                    setTimeout(function () {
                        //add param to check push notification.
                        //when this method called by page reload, we'll not show the push notifications.
                        //but after next calls, we'll show push notifications (if notifications are availabele )
                        params.showPushNotification = true;

                        checkNotifications(params);
                    }, check_notification_after_every);
                }
            }
        });
    }
};

