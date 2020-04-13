
let url = new URLSearchParams(window.location.search);


/* fills left panel with informations */
get_profile_left_info(url.get('user'));


/* will return heading of page with someone's friends */
get_profile_friend_page_heading(url.get('user'));


/* fills list of user's friends */
get_profile_friends_list(url.get('user'));


/* function simulating button with links */
left_panel_buttons();

$(".requests_image[title='Profile']").on("click", function () {
    window.location.href = "profile.php?user=" + url.get('user');
});


/* displaying document after everything is ready */
$(document).ready( function () {

    document.getElementsByTagName("html")[0].style.visibility = "visible";

});