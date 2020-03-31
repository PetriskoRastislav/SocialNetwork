$(document).ready(function() {

    fetch_users_all();

    /* periodically update */

    setInterval(function() {

        fetch_users_refresh();
    }, 2000);


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
        })
    }


    /* will refresh users list, what means it will refresh active marks
    and will display notification of new message if any is sent */
    function fetch_users_refresh(){
        $.ajax({
            url: "scripts/fetch_users.php",
            method: "POST",
            data: {
                mode: "refresh",
            },
            success: function(data){
                let ret_data = data.toString().split(" ");

                for(let i = 0; i < ret_data.length; i += 2){
                    let el = $("#active_mark_" + ret_data[i]);
                    let el2 = $("#user_last_active");

                    if(el2.hasClass(ret_data[i]) && ret_data[i + 1] === "online"){
                        el2.html("Aktívny");
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
        })
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
    }


    /* will fetch chat of particular user */
    function fetch_user_chat(id_user_to){
        $.ajax({
            url: "scripts/fetch_user_chat.php",
            method: "POST",
            data: {
                id_user_to: id_user_to,
            },
            success: function (data) {
                $("#conversation").html(data);
            }
        })
    }


    /*$(document).on('click', '#start_new_conversation', function(){

        $(this).style.
    });*/



});