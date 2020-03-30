$(document).ready(function() {

    fetch_users();

    // refresh at

    setInterval(function() {

        fetch_users();
    }, 2000);


    /* will fetch users from with whom had logged user conversations from database */
    function fetch_users() {
        $.ajax({
            url: "scripts/fetch_users.php",
            method: "POST",
            success: function (data) {
                $("#list_users_list").html(data);
            }
        })
    }


    /*
    $(document).on('click', '.list_users_item', function(){
        let id_user_to = $(this).data('id_user_to');
        let name_user_to = $(this).data('name_user_to');
    });*/


    /*

    function create_chat(id_user_to, name_user_to){

    }

    */

    /*$(document).on('click', '#start_new_conversation', function(){

        $(this).style.
    });*/



});