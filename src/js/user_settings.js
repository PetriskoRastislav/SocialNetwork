
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


    /* validates password at the same time as user is typing */
    $("#password_new").on("keyup", function (event) {
        event.preventDefault();

        if ( !valid_pas_low_l( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain digit.");
        }

        if ( !valid_pas_s( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain symbol (anything but digit or letter).");
        }

        if ( !string_has_length( $(this).val().toString(), 10) ) {
            display_warning("pass", "pass_new", "New password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        if ( valid_password( $(this).val().toString() ) ) {
            display_ack("pass", "pass_new", "New password has valid format.");
        }
    });


    /* validates confirming password format at the same time as user is typing */
    $("#password_new_again").on("keyup", function (event) {
        event.preventDefault();

        if ( !valid_pas_low_l( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain digit.");
        }

        if ( !valid_pas_s( $(this).val().toString() ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain symbol (anything but digit or letter)");
        }

        if ( !string_has_length( $(this).val().toString(), 10) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        if (!($(this).val().toString() === $("#password_new").val().toString())){
            display_warning("pass", "pass_new_again", "Confirming password and New password aren't same.");
        }

        if ( valid_password( $(this).val().toString() ) && ($(this).val().toString() === $("#password_new").val().toString())) {
            display_ack("pass", "pass_new_again", "Confirming password has valid format.");
        }
    });


    /* will change name, surname of user */
    $("#change_name_button").on("click", function () {
        let name = $("#name").val().toString().trim();
        let surname = $("#surname").val().toString().trim();

        if (string_has_length(name, 40) && string_has_length(surname, 40)){
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
            display_warning("mail", "Email has invalid format.");
        }
    });


    /* validates email format at the same time as user is typing */
    $("#email").on("keyup", function (event) {
        event.preventDefault();

        if ( valid_email( $(this).val().toString() ) ) {
            display_ack("mail", "mail", "Email has valid format.");
        }
        else {
            display_warning("mail", "mail", "Email has invalid format.");
        }
    });


    /* changes profile picture */
    $("#change_pic_button").on("click", function (event) {

        event.preventDefault();
        let form_data = new FormData($("#change_pic")[0]);

        $.ajax({
            url: "scripts/upload_profile_img.php",
            type: "POST",
            data: form_data,
            processData: false,
            cache: false,
            contentType: false,
            success: function(data) {
                console.log(data.toString());

                data = data.toString().split("|");

                if (data[0] === "0") {
                    display_warning("pic", data[1]);
                }
                else {
                    // view uploaded file.
                    $("#preview img").attr("src", data);
                    $("#change_pic")[0].reset();
                }
            },
            error: function (data) {
                display_warning("pic", data);
            }
        });

        $(this).blur();
    });


    /* displays preview of a image intended to be uploaded */
    $("#profile_pic").on("change", function () {
        readURL(this);
    });

    function readURL (input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (event) {
                $("#preview img").attr("src", event.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }


    /* changes information  */
    $("#change_info_button").on("click", function () {
        let location = $("#location").val().toString().trim();
        let gender = $("#gender").val().toString();
        let day_of_birth = $("#day_of_birth").val().toString();
        let month_of_birth = $("#month_of_birth").val().toString();
        let year_of_birth = $("#year_of_birth").val().toString().trim();

        if (string_has_length(location, 100)) {
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

    data = data.toString().split("|");

    if (data[1] === "1") {
        $('#res_' + data[0]).removeClass("settings_result_neg");
        $("#res_" + data[0]).addClass("settings_result_pos");
        $("#res_" + data[0] + " p").html("Successfully changed.");

        if(data[0] === "theme") {
            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "update_theme"
                },
                success: function () {
                    location.reload();
                }
            });
        }
    }
    else {
        $('#res_' + data[0]).removeClass("settings_result_pos");
        $("#res_" + data[0]).addClass("settings_result_neg");
        $("#res_" + data[0] + " p").html("Something went wrong.");
    }
}


/* will display warning when is something wrong with data in inputs */
function display_warning (where, stat, warning) {
    let w = "#res_" + where;

    $(w).removeClass("settings_result_pos");
    $(w).addClass("settings_result_neg");

    let status = $("#" + stat + "_status");
    status.addClass("display_icon");
    status.attr("src", "srcPictures/icons8-checked-no-100.png");
    status.attr("alt", "Input has invalid format.");

    $(w + " p").html(warning);
}


/* displays acknowledgement when data in input has valid email */
function display_ack (where, stat, ack) {
    let w = "#res_" + where;

    $(w).removeClass("settings_result_neg");
    //$(w).addClass("settings_result_pos");

    let status = $("#" + stat + "_status");
    status.addClass("display_icon");
    status.attr("src", "srcPictures/icons8-checked-100.png");
    status.attr("alt", "Input has valid format.");

    //$(w + " p").html(ack);
}