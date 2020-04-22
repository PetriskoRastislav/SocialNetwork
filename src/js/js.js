$(document).ready(function() {


    update_last_active();


    setInterval(function() {
        update_last_active();
    }, 1500);


    /* will update time of last activity of user in database */
    function update_last_active(){
        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "update_active",
            },
            success: function () {

            }
        });
    }

});
