
let url = new URLSearchParams(window.location.search);

/* fills left panel with informations */
get_profile_left_info("me");


/* function simulating button with links */
left_panel_buttons();

$(".requests_image[title='Profile']").on("click", function () {
    window.location.href = "profile.php?user=" + url.get('user');
});


/* will fill some of the forms */
fill_forms();


$(document).ready( function () {

    document.getElementsByTagName("html")[0].style.visibility = "visible";

});


function fill_forms () {
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "settings_fill_change_name"
        },
        success: function (data) {
            data = data.toString().split("|");

            for (let i = 0; i < data.length; i += 3) {
                $(data[i]).attr(data[i + 1], data[i + 2]);
            }
        }
    })
}