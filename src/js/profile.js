$(document).on("load",  function() {


});


$(document).ready( function () {

    let url = new URLSearchParams(window.location.search);

    /* fills left panel with informations */
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_left_info",
            user_id: url.get('id')
        },
        success: process_profile_data(data)
    });

    /* fills center part with data */
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "get_profile_profile_info",
            user_id: url.get('id')
        },
        success: process_profile_data(data)
    });

});


/* will split up data from php and put html data into a correspondent element */
function process_profile_data (data) {
    data = data.toString().split("|");

    for (let i = 0; i < data.length; i += 2) {
        if ( data[i] === "profile_picture" ){
            $(data[i]).attr("src", data[i + 1]);
        }
        else {
            $(data[i]).html(data[i + 1]);
        }
    }
}
