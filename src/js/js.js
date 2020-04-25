$(document).ready(function() {


    update_last_active();
    update_notifications();


    setInterval(function() {
        update_last_active();
        update_notifications();
    }, 1500);


    /* will update time of last activity of user in database */
    function update_last_active(){
        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "update_active"
            },
            success: function () {

            }
        });
    }


    function update_notifications () {

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "update_notifications"
            },
            success: function (data) {

                data = data.toString().split("|");

                let message_notification = $("#menu_messages .notification_mark");
                let friend_notification = $("#menu_friends .notification_mark");

                if (data[0] === "1") {

                    if (message_notification.length === 0) {

                        $("#menu_messages").append("<span class='notification_mark menu_notification'></span>");

                    }
                }
                else {
                    if (message_notification.length !== 0) {
                        message_notification.remove();
                    }
                }
                if (data[1] === "1") {

                    if (friend_notification.length === 0) {

                        $("#menu_friends").append("<span class='notification_mark menu_notification'></span>");
                    }
                }
                else {
                    if (friend_notification.length !== 0) {
                        friend_notification.remove();
                    }
                }

            }
        })

    }

});