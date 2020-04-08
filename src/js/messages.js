$(document).ready(function() {

    fetch_users_all();


    /* periodical update */
    setInterval(function() {
        refresh_user_list();
    }, 1000);

    setInterval(function () {
        refresh_chat();

    }, 500);


    /* will fetch users from with whom had logged user conversations from database */
    function fetch_users_all() {
        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "all",
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
                mode: "refresh",
            },
            success: function(data){
                let ret_data = data.toString().split(" ");

                for(let i = 0; i < ret_data.length; i += 5){

                    /* console.log(ret_data[i] + " " + ret_data[i + 1] + " " + ret_data[i + 2] + " " + ret_data[i + 3] + " " + ret_data[i + 4]); */


                    let last_active_sign = $("#user_last_active");
                    let active_mark = $("#active_mark_" + ret_data[i]);
                    let new_message_notification = $("#mes_not_" + ret_data[i]);


                    /* label with last active time or with sign active in chat header */

                    if(last_active_sign.hasClass(ret_data[i]) && ret_data[i + 1] === "online" && last_active_sign.text() !== "Aktívny"){
                        last_active_sign.html("Aktívny");
                    }
                    else if(last_active_sign.hasClass(ret_data[i]) && ret_data[i + 1] === "offline" && last_active_sign.text() === "Aktívny"){
                        last_active_sign.html("Naposledy aktívny " + ret_data[i + 2] + " " + ret_data[i + 3]);
                        $(".list_users_item[id_user_to='" + ret_data[i] + "']").attr("last_active", ret_data[i + 2] + " " + ret_data[i + 3]);
                    }


                    /* active mark in the list of conversations */

                    if(active_mark.hasClass("active_mark") && ret_data[i + 1] === "offline"){
                        active_mark.removeClass("active_mark");
                    }
                    else if(!active_mark.hasClass("active_mark") && ret_data[i + 1] === "online"){
                        active_mark.addClass("active_mark");
                    }


                    /* mark of a new unread message in the list of conversations */

                    if(ret_data[i + 4] === "0" && new_message_notification.hasClass("mes_not_chat")){
                        new_message_notification.removeClass("mes_not_chat");
                    }
                    else if(ret_data[i + 4] !== "0" && !new_message_notification.hasClass("mes_not_chat")) {
                        new_message_notification.addClass("mes_not_chat");
                    }

                }
            }
        });
    }


    /* will display chat with particular user */
    $(document).on('click', '.list_users_item', function(){
        let id_user_to = $(this).attr("id_user_to");
        let name_user_to = $(this).attr("name_user_to");
        let last_active = $(this).attr("last_active");
        create_chat(id_user_to, name_user_to, last_active);
    });


    /* will create content in conversations section */
    function create_chat(id_user_to, name_user_to, last_active){

        let conversation_header = "<img class='avatar' src='' alt='Avatar' />";
        conversation_header += "<p>" + name_user_to + "</p>";
        conversation_header += "<span id='user_last_active' class='time " + id_user_to + "'>Naposledy aktívny " + last_active + "</span>";
        conversation_header += "<img id='conversation_close_button' src='srcPictures/icons8-no-100.png' alt='send icon' />";

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
                id_user_to: id_user_to,
            },
            success: function (data) {
                $("#conversation").html(data);
                scroll_chat(true);
            }
        });
        write_last_message_id(id_user_to);
    }


    /* will write id of the last fetched message into a conversation_header */
    function write_last_message_id(id_user_to){
        $.ajax({
            url: "scripts/query_user_chat.php",
            method: "POST",
            data: {
                mode: "id_message",
                id_user_to: id_user_to,
            },
            success: function (data) {
                $("#conversation_header").attr("last_message", data);
            }
        });
    }


    /* will send message into a database */
    $(document).on("click", "#send_button", function () {
        let id_user_to = $(this).attr("id_user_to");
        let message = $("#message_to_send").val();

        message = message.trim();

        if(message !== ""){
            $.ajax({
                url: "scripts/query_user_chat.php",
                method: "POST",
                data: {
                    mode: "send_message",
                    id_user_to: id_user_to,
                    message: message,
                },
                success: function(){
                    $("#message_to_send").val("");
                    //refresh_chat();
                }
            });
        }
    });


    /* will send message also after clicking on Enter */
    $(document).on("keyup", "#message_to_send", function (event) {

        if (event.keyCode === 13) {
            event.preventDefault();
            $("#send_button").click();
        }

    });


    /* will refresh chat */
    function refresh_chat(){
        let id_user_to = $("#send_button").attr("id_user_to");
        let last_message_id = $("#conversation_header").attr("last_message");

        if(id_user_to > 0) {

            $.ajax({
                url: "scripts/query_user_chat.php",
                method: "POST",
                data: {
                    mode: "refresh",
                    id_user_to: id_user_to,
                    last_message_id: last_message_id
                },
                success: function (data) {
                    if(data.length > 0) {
                        $("#conversation").append(data);
                        scroll_chat(false);
                    }
                }
            });

            write_last_message_id(id_user_to);
        }
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
        let con_head = $("#conversation_header");
        con_head.html("");
        con_head.removeAttr("last_message");
        $("#conversation").html("");
    });


    /* will "remove" message of a logged user */
    $(document).on("click", ".remove_message", function () {
        let id_message = $(this).attr("id");
        id_message = id_message.split("_");
        id_message = id_message[2];

        $.ajax({
            url: "scripts/query_user_chat.php",
            method: "POST",
            data: {
                mode: "remove_message",
                id_message: id_message,
            },
            success: function () {

            },
        })
    });



    /* will search for a particular user */
    $(document).on("keyup", "#search_user_con_list", function (event) {

        if ((event.type === "keydown" || event.type === "keyup") && event.which === 27) {
            $("#search_result_con_list").removeClass("visible");
        }
        else if( (event.which >= 68 && event.which <= 90) || event.which === 8 || event.which === 46){

            let value = $(this).val();

            if (value !== "") {
                $(".clear_search_users").addClass("clear_search_users_visible");
            }
            else if (value === undefined) {
                $(".clear_search_users").removeClass("clear_search_users_visible");
            }

            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "find_user",
                    value: value,
                },
                success: function (data) {
                    let result = $("#search_result_con_list");
                    result.html(data);
                    result.addClass("visible");

                },
            });
        }
    });


    /* will display div with search result on focus on a search input */
    $(document).on("focus", "#search_user_con_list", function () {
        $("#search_result_con_list").addClass("visible");
    });


    /* will hide div with a search result on a blur of a search input */
    $(document).on("blur", "#search_user_con_list", function () {
        if ($("#search_user_con_list").val().toString() === "") {
            $("#search_result_con_list").removeClass("visible");
            $(".clear_search_users").removeClass("clear_search_users_visible");
        }
    });


    /* will clear search field for searching users in conversations header */
    $(document).on("click", ".clear_search_users", function () {
        $("#search_user_con_list").val("");
        $(this).removeClass("clear_search_users_visible");
        let result = $("#search_result_con_list");
        result.removeClass("visible");
        result.html("");
    });


    /* after clicking on a user of a result list will open conversation with him */
    $(document).on("click", ".search_result_item", function () {

        let id_user_to = $(this).attr("id").split("_")[2];
        let name_user_to = $(this).attr("name_user_to");
        let last_active = $(this).attr("last_active");

        $(".clear_search_users").click();
        create_chat(id_user_to, name_user_to, last_active);

        console.log(id_user_to);
    });

});