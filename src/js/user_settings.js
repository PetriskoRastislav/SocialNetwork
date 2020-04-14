
let url = new URLSearchParams(window.location.search);

/* fills left panel with informations */
get_profile_left_info("me");


/* fills left panel with buttons */
left_panel_buttons("settings");


/* will fill some of the forms */
fill_forms();


$(document).ready( function () {

    document.getElementsByTagName("html")[0].style.visibility = "visible";


    /* will change name, surname of user */
    /*$("#change_name_button").on("click", function () {
        let name = $("#name").attr("value").toString().trim();
        let surname = $("#surname").attr("value").toString().trim();

        if (validate_string(name, 40) && validate_string(surname, 40)){
            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "change_name",
                    name: name,
                    surname: surname
                },
                success: function (data) {
                    data = data.toString();

                    console.log(data);

                    if (data === "true") {
                        $("#res_name").addClass("settings_result_pos");
                        $("#res_name p").html("Successfully changed.");
                    }
                    else {
                        $("#res_name").addClass("settings_result_neg");
                        $("#res_name p").html("Something went wrong.");
                    }
                }
            });
        }
    });*/


});


function fill_forms () {
    $.ajax({
        url: "scripts/query_users.php",
        method: "POST",
        data: {
            mode: "settings_fill"
        },
        success: function (data) {
            data = data.toString().split("|");

            for (let i = 0; i < data.length; i += 3) {
                $(data[i]).attr(data[i + 1], data[i + 2]);
            }
        }
    })
}