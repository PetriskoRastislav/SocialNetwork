
let url = new URLSearchParams(window.location.search);

/* fills left panel with informations */
get_profile_left_info("me");


/* fills left panel with buttons */
left_panel_buttons("settings");


/* will fill some of the forms */
fill_forms();


$(document).ready( function () {

    document.getElementsByTagName("html")[0].style.visibility = "visible";


    /* changes password */
    $("#change_pass_button").on("click", function () {
        let password_old = $("#password_old").val().toString();
        let password_new = $("#password_new").val().toString();
        let password_new_again = $("#password_new_again").val().toString();

        if (password_new === password_new_again) {
            if (valid_password(password_new) && valid_password(password_new_again)){
                $.ajax({
                    url: "scripts/query_users.php",
                    method: "POST",
                    data: {
                        mode: "change_password",
                        password_old: password_old,
                        password_new: password_new,
                        password_new_again: password_new_again
                    },
                    success: display_result
                });
            }
            else {
                display_warning("pass", "New password has wrong format.");
            }
        }
        else {
            display_warning("pass", "New password aren't same.");
        }

    });


    /* will change name, surname of user */
    $("#change_name_button").on("click", function () {
        let name = $("#name").val().toString().trim();
        let surname = $("#surname").val().toString().trim();

        if (valid_string(name, 40) && valid_string(surname, 40)){
            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "change_name",
                    name: name,
                    surname: surname
                },
                success: display_result
            });
        }
        else {
            display_warning("name", "Name or surname is longer than allowed.");
        }
    });


    /* changes email */
    $("#change_email_button").on("click", function () {
        let email = $("#email").val().toString().trim();

        if(valid_email(email)){
            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "change_email",
                    email: email
                },
                success: display_result
            });
        }
        else {
            display_warning("mail", "Email has wrong format.");
        }
    });


    /* changes profile picture */
    $("#change_pic_button").on("click", function () {

    });


    /* changes information  */
    $("#change_info_button").on("click", function () {
        let location = $("#location").val().toString().trim();
        let gender = $("#gender").val().toString();
        let day_of_birth = $("#day_of_birth").val().toString();
        let month_of_birth = $("#month_of_birth").val().toString();
        let year_of_birth = $("#year_of_birth").val().toString().trim();

        if (valid_string(location, 100)) {
            if (valid_year(year_of_birth)) {
                $.ajax({
                    url: "scripts/query_users.php",
                    method: "POST",
                    data: {
                        mode: "change_profile_det",
                        location: location,
                        gender: gender,
                        day_of_birth: day_of_birth,
                        month_of_birth: month_of_birth,
                        year_of_birth: year_of_birth
                    },
                    success: display_result
                });
            }
            else {
                display_warning("info", "Year has wrong format (isn't year or is in forbidden range).");
            }
        }
        else {
            display_warning("info", "Location is longer than allowed.");
        }
    });


    /* changes theme */
    $("#change_theme_button").on("click", function () {
        let theme = $("#change_theme").is(":checked");
        if (theme) theme = "dark";
        else theme = "light";

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "change_theme",
                theme: theme
            },
            success: display_result
        });
    });


    /* changes biography */
    $("#change_bio_button").on("click", function () {
        let bio = $("#biography").val().toString().trim();

        $.ajax({
            url: "scripts/query_users.php",
            method: "POST",
            data: {
                mode: "change_bio",
                bio: bio
            },
            success: display_result
        });
    });

});


/* fills some of the fields in settings with values fom database */
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
                if (data[i] === "textarea[name='biography']" ) {
                    $(data[i]).html(data[i + 2]);
                }
                else {
                    $(data[i]).attr(data[i + 1], data[i + 2]);
                }

            }
        }
    })
}


/* display result of changing information about profile in selected div */
function display_result (data) {

    console.log(data.toString());

    data = data.toString().split("|");

    if (data[1] === "1") {
        $('#res_' + data[0]).removeClass("settings_result_neg");
        $("#res_" + data[0]).addClass("settings_result_pos");
        $("#res_" + data[0] + " p").html("Successfully changed.");
    }
    else {
        $('#res_' + data[0]).removeClass("settings_result_pos");
        $("#res_" + data[0]).addClass("settings_result_neg");
        $("#res_" + data[0] + " p").html("Something went wrong.");
    }
}


/*  */
function display_warning (where, warning) {
    $('#res_' + where).removeClass("settings_result_pos");
    $("#res_" + where).addClass("settings_result_neg");
    $("#res_" + where + " p").html(warning);
}