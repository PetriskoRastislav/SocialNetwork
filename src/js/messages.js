$(document).ready(function() {


    fetch_users_all();
    open_chat();


    /* periodical update */

    setInterval(function() {
        refresh_user_list();
    }, 1000);


    setInterval(function () {
        refresh_chat(false);
    }, 400);


    /* opens a conversation to a user whom id is contained in link */
    function open_chat() {
        let url = new URLSearchParams(window.location.search);

        if (url.get('user') > 0) {
            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "get_username",
                    id_user: url.get('user')
                },
                success: function (data) {
                    data = data.toString().split("|");

                    create_chat(data[0], data[1], data[2], data[3]);
                }
            });
        }
    }


    /* will fetch users from with whom had logged user conversations from database */
    function fetch_users_all() {
        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "all"
            },
            success: function (data) {
                $("#list_users_list").html(data);
            }
        });
    }


    /* will refresh users list, what means it will refresh active marks
    and will display notification of new message if any is there */
    function refresh_user_list(){
        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "refresh_list"
            },
            success: function (data) {
                let ret_data = data.toString().split("|");
                let list = $("#list_users_list");

                for (let i = 0; i < ret_data.length; i += 2) {

                    try {

                        let id_list_item = $(".list_users_item[id_user_to=" + ret_data[i] + "]").attr("id_user_to");
                        if (!(id_list_item > 0)) {
                            console.log(id_list_item);
                            list.prepend(ret_data[i + 1]);
                        }
                    }
                    catch (ex) {

                    }
                }
            }
        });

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "refresh_marks"
            },
            success: function(data){
                let ret_data = data.toString().split("|");

                for (let i = 0; i < ret_data.length; i += 4) {

                    let last_active_sign = $("#user_last_active");
                    let active_mark = $("#active_mark_" + ret_data[i]);
                    let new_message_notification = $("#mes_not_" + ret_data[i]);


                    /* label with last active time or with sign active in chat header */

                    if (last_active_sign.hasClass(ret_data[i]) && ret_data[i + 1] === "online" && last_active_sign.text() !== "Online"){
                        last_active_sign.html("Online");
                    }
                    else if (last_active_sign.hasClass(ret_data[i]) && ret_data[i + 1] === "offline") {
                        if (last_active_sign.html() !== "Last online " + ret_data[i + 2]) {
                            last_active_sign.html("Last online " + ret_data[i + 2]);
                        }
                    }


                    /* active mark in the list of conversations */

                    if(active_mark.hasClass("active_mark") && ret_data[i + 1] === "offline"){
                        active_mark.removeClass("active_mark");
                    }
                    else if(!active_mark.hasClass("active_mark") && ret_data[i + 1] === "online"){
                        active_mark.addClass("active_mark");
                    }


                    /* mark of a new unread message in the list of conversations */

                    if(ret_data[i + 3] === "0" && new_message_notification.hasClass("notification_mark")){
                        new_message_notification.removeClass("notification_mark");
                    }
                    else if(ret_data[i + 3] !== "0" && !new_message_notification.hasClass("notification_mark")) {
                        new_message_notification.addClass("notification_mark");
                    }

                }
            }
        });
    }


    /* will display chat with particular user */
    $(document).on("click", ".list_users_item", function() {
        let id_user_to = $(this).attr("id_user_to");

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "get_username",
                id_user: id_user_to
            },
            success: function (data) {
                data = data.toString().split("|");

                create_chat(data[0], data[1], data[2], data[3]);
            }
        });
    });


    /* will create content in conversations section */
    function create_chat(id_user_to, name_user_to, last_active, profile_picture){

        let conversation_header = "";
        let img = "";

        if (profile_picture === "") {
            img = "src_pictures\/blank-profile-picture-png-8.png";
        }
        else {
            img = "user_pictures\/" + profile_picture;
        }
        img = "background-image: url('" + img + "');";

        conversation_header += '<div class="avatar" style="' + img + '"></div>';
        conversation_header += "<p><a class='common' href='profile.php?user=" + id_user_to + "'>" + name_user_to + "</a></p>";
        conversation_header += "<span id='user_last_active' class='time " + id_user_to + "'>Last online " + last_active + "</span>";
        conversation_header += "<img id='conversation_close_button' src='";

        if (theme === "dark") {
            conversation_header += "src_pictures/icons8-no-100-white.png";
        }
        else {
            conversation_header += "src_pictures/icons8-no-100.png";
        }

        conversation_header += "' alt='send icon' />";

        $("#conversation_header").html(conversation_header);

        fetch_user_chat(id_user_to);

        let send_button = $("#send_button");
        send_button.attr("id_user_to", id_user_to);
    }


    /* will fetch chat of particular user */
    function fetch_user_chat(id_user_to){
        $.ajax({
            url: "scripts/query_user_chat.php",
            method: "POST",
            data: {
                mode: "all",
                id_user_to: id_user_to
            },
            success: function (data) {
                $("#conversation").html(data);
                scroll_chat(true);
            }
        });
    }


    /* will send message into a database */
    $("#send_button").on("click", function () {
        let id_user_to = $(this).attr("id_user_to");
        let message = $("#message_to_send").val();

        message = message.trim();

        if(message !== "" && id_user_to > 0){
            $.ajax({
                url: "scripts/query_user_chat.php",
                method: "POST",
                data: {
                    mode: "send_message",
                    id_user_to: id_user_to,
                    message: message
                },
                success: function(){
                    $("#message_to_send").val("");
                    let last_message_id = -1;
                    try {
                        last_message_id = $("#conversation div.mes_wrap:last").attr("id").split("_")[1];
                    }
                    catch (ex){
                    }

                    if (last_message_id === -1){
                        refresh_chat(true);
                    }

                }
            });
        }
    });


    /* will send message also after clicking on Enter */
    $("#message_to_send").on("keyup", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $("#send_button").click();
        }
    });


    /* will refresh chat */
    function refresh_chat(force){
        let id_user_to = $("#send_button").attr("id_user_to");
        let last_message_id = -1;

        try {
            last_message_id = $("#conversation div.mes_wrap:last").attr("id").split("_")[1];
        }
        catch (ex){
        }

        if ((id_user_to > 0 && last_message_id >= 0) || force) {

            $.ajax({
                url: "scripts/query_user_chat.php",
                method: "POST",
                data: {
                    mode: "load_new_messages",
                    id_user_to: id_user_to,
                    last_message_id: last_message_id
                },
                success: function (data) {
                    if(data.length > 0) {
                        $("#conversation").append(data);
                        scroll_chat(false);
                    }
                },
            });
        }

        if (id_user_to > 0) {

            $.ajax({
                url: "scripts/query_user_chat.php",
                method: "POST",
                data: {
                    mode: "refresh_messages",
                    id_user_to: id_user_to
                },
                success: function (data) {
                    let ret_data = data.toString().split("|");

                    for (let i = 0; i < ret_data.length; i += 2) {

                        if (ret_data [i] > 0) {

                            try {
                                let old_message = $("#mes_" + ret_data[i]);
                                let old_message_content = old_message.html();
                                let new_message_content = ret_data[i + 1].toString();

                                let new_message_content_alt = new_message_content.replace("mes_time_info", "mes_time_info mes_time_info_show");

                                if (!(strings_equal(old_message_content, new_message_content)) && !(strings_equal(old_message_content, new_message_content_alt))) {
                                    old_message.html(ret_data[i + 1]);
                                    old_message.removeClass("mes_wrap_active");
                                }
                            } catch (ex) {
                                console.log(ex.message);
                            }
                        }
                    }
                }
            });
        }
    }


    /* verifies whether two strings are identical */
    function strings_equal (string1, string2) {
        for (let i = 0; i < string1.length; i++) {
            if (string1.charCodeAt(i) !== string2.charCodeAt(i)) {
                /*console.log("false " + i + " " + string1.charCodeAt(i) + " " + string1.charAt(i) + " " + string2.charCodeAt(i) + " " + string2.charAt(i) +
                    " | " + string1.slice(i - 10, i) + " | " + string1.charAt(i) + " | " + string1.slice(i, i + 10) +
                    " | " + string2.slice(i - 10, i) + " | " + string2.charAt(i) + " | " + string2.slice(i, i + 10) + " |");*/
                return false;
            }
        }
        return true;
    }


    /* auto scroll to the bottom of a conversation */
    function scroll_chat(force){
        let chat = $("#conversation");

        let actual_position = chat.scrollTop();
        let down_position = chat[0].scrollHeight - chat.height();

        if(down_position - actual_position < 650) {
            chat.animate({scrollTop: chat[0].scrollHeight}, "slow");
        }

        if(force){
            chat.animate({scrollTop: chat[0].scrollHeight}, "slow");
        }
    }


    /* will clear conversation and conversation header sections */
    $(document).on("click", "#conversation_close_button", function () {
        $("#conversation_header").html("");
        $("#send_button").removeAttr("id_user_to");
        $("#conversation").html("");
    });


    /* will "remove" message of a logged user */
    $(document).on("click", ".remove_message", function () {
        let id_message = $(this).attr("id").split("_")[2];

        $.ajax({
            url: "scripts/query_user_chat.php",
            method: "POST",
            data: {
                mode: "remove_message",
                id_message: id_message
            },
            success: function () {

            }
        })
    });


    /* will search for a particular user */
    $("#list_users_search_field").on("keyup", function (event) {

        let value = $(this).val().toString();


        if (value.length > 0) {
            $(".clear_search_users").addClass("clear_search_users_visible");
        }
        else {
            $(".clear_search_users").removeClass("clear_search_users_visible");
            $("#list_users_search_result").removeClass("visible");
        }


        if (event.which === 27) {
            $("#list_users_search_result").removeClass("visible");
        }
        else if ((event.which === 8 && value === "")) {
            let result = $("#list_users_search_result");
            result.html("");
            result.removeClass("visible");
        }
        else if( !(event.which === 13 || event.which === 27)){

            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "find_user",
                    value: value
                },
                success: function (data) {
                    let result = $("#list_users_search_result");
                    result.html(data);
                    result.addClass("visible");

                }
            });
        }
    });


    /* will display div with search result on focus on a search input */
    $("#list_users_search_field").on("focus", function () {
        $("#list_users_search_result").addClass("visible");
    });


    /* will hide div with a search result on a blur of a search input */
    $("#list_users_search_field").on("blur", function (event) {
        if ($("#list_users_search_field").val().toString() === "") {
            $("#list_users_search_result").removeClass("visible");
            $(".clear_search_users").removeClass("clear_search_users_visible");
            $(".list_users_search_result").html("");
        }
    });


    /* will clear search field for searching users in conversations header */
    $(".clear_search_users").on("click", function () {
        $("#list_users_search_field").val("");
        $(this).removeClass("clear_search_users_visible");
        let result = $("#list_users_search_result");
        result.removeClass("visible");
        result.html("");
    });


    /* after clicking on a user from a result list of search will open conversation with him */
    $(document).on("click", ".search_result_item", function () {
        let id_user_to = $(this).attr("id").split("_")[2];

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "get_username",
                id_user: id_user_to
            },
            success: function (data) {
                data = data.toString().split("|");

                create_chat(data[0], data[1], data[2], data[3]);
            }
        });

        $(".clear_search_users").click();
    });


    /* after clicking on a message will display complete time information */
    $(document).on("click", ".message", function () {
        let id_mes = $(this).parent().attr("id").split("_")[1];

        let time_info = $("#mes_" + id_mes + " .mes_time_info");

        if (time_info.hasClass("mes_time_info_show")) {
            time_info.removeClass("mes_time_info_show");
            $(this).parent().removeClass("mes_wrap_active");
        }
        else {
            time_info.addClass("mes_time_info_show");
            $(this).parent().addClass("mes_wrap_active");
        }
    });

});