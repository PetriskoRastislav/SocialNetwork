$(document).ready(function() {

    fetch_users_all();

    /* periodically update */

    setInterval(function() {
        refresh_user_list();
        refresh_chat();
    }, 2000);
/*
    setInterval(function () {
        refresh_chat();
    }, 500);
    */

    /* will fetch users from with whom had logged user conversations from database */
    function fetch_users_all() {
        $.ajax({
            url: "scripts/fetch_users.php",
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
            url: "scripts/fetch_users.php",
            method: "POST",
            data: {
                mode: "refresh",
            },
            success: function(data){
                let ret_data = data.toString().split(" ");

                for(let i = 0; i < ret_data.length; i += 4){

                    let el = $("#active_mark_" + ret_data[i]);
                    let el2 = $("#user_last_active");

                    if(el2.hasClass(ret_data[i]) && ret_data[i + 1] === "online" && el2.text() !== "Aktívny"){
                        el2.html("Aktívny");
                    }
                    else if(el2.hasClass(ret_data[i]) && ret_data[i + 1] === "offline" && el2.text() === "Aktívny"){
                        el2.html("Naposledy aktívny " + ret_data[i + 2] + " " + ret_data[i + 3]);
                        $(".list_users_item[id_user_to='" + ret_data[i] + "']").attr("last_active", ret_data[i + 2] + " " + ret_data[i + 3]);
                    }

                    if(el.hasClass("active_mark") && ret_data[i + 1] === "online") {

                    }
                    else if(el.hasClass("active_mark") && ret_data[i + 1] === "offline"){
                        el.removeClass("active_mark");
                    }
                    else if(!el.hasClass("active_mark") && ret_data[i + 1] === "online"){
                        el.addClass("active_mark");
                    }
                    else if(!el.hasClass("active_mark") && ret_data[i + 1] === "offline"){

                    }
                    else{
                        //console.log("someone or something has fucked up.")
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

        $("#conversation_header").html(conversation_header);

        fetch_user_chat(id_user_to);

        let send_button = $("#send_button");
        send_button.attr("id_user_to", id_user_to);
    }


    /* will fetch chat of particular user */
    function fetch_user_chat(id_user_to){
        $.ajax({
            url: "scripts/fetch_user_chat.php",
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
            url: "scripts/fetch_user_chat.php",
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

        if(message !== ""){
            $.ajax({
                url: "scripts/send_message.php",
                method: "POST",
                data: {
                    id_user_to: id_user_to,
                    message: message,
                },
                success: function(){
                    $("#message_to_send").val("");
                    refresh_chat(true);
                }
            });
        }
    });


    /* will refresh chat */
    function refresh_chat(){
        let id_user_to = $("#send_button").attr("id_user_to");
        let last_message_id = $("#conversation_header").attr("last_message");

        if(id_user_to > 0) {

            $.ajax({
                url: "scripts/fetch_user_chat.php",
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
        let down_position = chat[0].scrollHeight;

        console.log(actual_position + " " + down_position);

        if(actual_position === down_position) {
            chat.animate({scrollTop: chat[0].scrollHeight}, "slow");
        }

        if(force){
            chat.animate({scrollTop: chat[0].scrollHeight}, "slow");
        }
    }



});