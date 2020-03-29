$(document).ready(function() {

    fetch_users();

    // refresh at

    setInterval(function() {
        fetch_users();
    }, 2000);


    function fetch_users(){
        $.ajax({
            url: "scripts/fetch_users.php",
            method: "POST",
            success: function(data) {
                $("#list_users_list").html(data);
            }
        })
    }



});