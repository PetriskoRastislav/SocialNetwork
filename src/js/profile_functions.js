
/* fills left panel with informations */
function get_profile_left_info (id_user) {

    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_left_info",
            user_id: id_user
        },
        success: process_profile_data
    });
}


/* fills center part with data */
function get_profile_profile_info (id_user) {
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_profile_info",
            user_id: id_user
        },
        success: process_profile_data
    });
}


/* fills list of user's friends */
function get_profile_friends_list (id_user) {
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_friends_list",
            user_id: id_user
        },
        success: function (data) {
            $(".right_column").html(data.toString());
        }
    });
}


/* will return heading of page with someone's friends */
function get_profile_friend_page_heading (id_user) {
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_friend_page_heading",
            user_id: id_user
        },
        success: process_profile_data
    });
}


function left_panel_buttons () {
    if (url.get('user') === "me") {
        /*let write_message = $(".requests_image[title='Write a Message']");
        write_message.addClass("requests_image_dis");
        write_message.removeClass("requests_image_en");*/

        let request_friendship = $(".requests_image[title='Request Friendship']");
        request_friendship.addClass("requests_image_dis");
        request_friendship.removeClass("requests_image_en");
        request_friendship.attr("title", "Wanna be friend with yourself? I guess it won't work.");
    }
    else {
        $(".requests_image[title='Request Friendship']").on("click", function () {

        });
    }

    $(".requests_image[title='Write a Message']").on("click", function () {
        window.location.href = "messages.php?user=" + url.get('user');
    });
}


/* will split up data from php and put html data into a correspondent element */
function process_profile_data (data) {
    data = data.toString().split("|");

    for (let i = 0; i < data.length; i += 2) {
        if (data[i] === "#info_profile_picture") {
            $(data[i]).attr("src", data[i + 1]);
        } else {
            $(data[i]).html(data[i + 1]);
        }
    }
}