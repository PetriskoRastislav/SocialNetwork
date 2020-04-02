$(document).ready(function() {

    setInterval(function() {
        update_last_active();
    }, 1500);


    /* will update time of last activity of user in database */
    function update_last_active(){
        $.ajax({
            url: "scripts/update_last_active.php",
            success: function () {

            }
        });
    }

});