
let url = new URLSearchParams(window.location.search);


/* fills left panel with informations */
get_profile_left_info(url.get('user'));


/* fills center part with data */
get_profile_profile_info(url.get('user'));


/* function simulating button with links */
left_panel_buttons();

$(".requests_image[title='Friends']").on("click", function () {
    window.location.href = "friends.php?user=" + url.get('user');
});


/* displaying document after everything is ready */
$(document).ready( function () {

    document.getElementsByTagName("html")[0].style.visibility = "visible";

});