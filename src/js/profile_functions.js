
/* fills left panel with informations */
function get_profile_left_info (id_user) {

    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_left_info",
            id_user: id_user
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
            id_user: id_user
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
            id_user: id_user
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
            id_user: id_user
        },
        success: process_profile_data
    });
}


/* will generate buttons in left column of profile and affiliated pages */
function left_panel_buttons (page, id_user) {

    let buttons = '';

    if (page === "settings") {
        buttons +=
            '<a href="messages.php?user=me" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-new-message-100-white.png";
        else buttons += "src_pictures/icons8-new-message-100.png";

        buttons += '" title="Write a Message" alt="Write a Message">' +
            '</a>' +
            '<a href="profile.php?user=me" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-user-100-white.png";
        else buttons += "src_pictures/icons8-user-100.png";

        buttons += '" title="Profile" alt="Profile">' +
            '</a>';
    }

    if (page === "profile") {
        buttons +=
            '<a href="messages.php?user=' + id_user + '" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-new-message-100-white.png";
        else buttons += "src_pictures/icons8-new-message-100.png";

        buttons += '" title="Write a Message" alt="Write a Message">' +
            '</a>';

        if (id_user === "me") {
            console.log("here");
        }
        else {
            buttons += '<img class="requests_image requests_image_en" src="';

            if (theme === "dark") buttons += "src_pictures/icons8-add-user-group-man-man-100-white.png";
            else buttons += "src_pictures/icons8-add-user-group-man-man-100.png";

            buttons += '" title="Request Friendship" alt="Request Friendship">';
        }

        buttons +=
            '<a href="friends.php?user=' + id_user + '" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-user-account-100-white.png";
        else buttons += "src_pictures/icons8-user-account-100.png";

        buttons += '" title="Friends" alt="Friends"></a>';
    }

    if (page === "friends") {
        buttons +=
            '<a href="messages.php?user=' + id_user + '" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-new-message-100-white.png";
        else buttons += "src_pictures/icons8-new-message-100.png";

        buttons += '" title="Write a Message" alt="Write a Message"></a>';

        if (id_user === "me") {

        }
        else {
            buttons += '<img class="requests_image requests_image_en" src="';

            if (theme === "dark") buttons += "src_pictures/icons8-add-user-group-man-man-100-white.png";
            else buttons += "src_pictures/icons8-add-user-group-man-man-100.png";

            buttons += '"title="Request Friendship" alt="Request Friendship">';
        }

        buttons +=
            '<a href="profile.php?user=' + id_user + '" class="requests_a">' +
            '<img class="requests_image requests_image_en" src="';

        if (theme === "dark") buttons += "src_pictures/icons8-user-100-white.png";
        else buttons += "src_pictures/icons8-user-100.png";

        buttons += '" title="Profile" alt="Profile"></a>';

    }


    $(".requests").html(buttons);
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