
/* will fill some of the forms */
fill_forms();


$(document).ready( function () {


    /* changes password */
    $("#change_pass_button").on("click", function (event) {
        event.preventDefault();
        let password_old = $("#password_old").val().toString();
        let password_new = $("#password_new").val().toString();
        let password_new_again = $("#password_new_again").val().toString();

        if (password_new !== password_new_again) {
            display_warning("pass", "pass_new_again", "Confirming new password doesn't match new password");
            $(this).blur();
            return;
        }

        if (!valid_password(password_new)) {
            display_warning("pass", "pass_new", "New password has invalid format.");
            $(this).blur();
            return;
        }

        if (!valid_password(password_new_again)) {
            display_warning("pass", "pass_new_again", "Confirming password has invalid format.");
            $(this).blur();
            return;
        }

        $.ajax({
            url: "scripts/query_settings.php",
            method: "POST",
            data: {
                mode: "change_password",
                password_old: password_old,
                password_new: password_new,
                password_new_again: password_new_again
            },
            success: display_result
        });

        $(this).blur();

    });


    /* validates password at the same time as user is typing */
    $("#password_new").on("keyup", function (event) {
        event.preventDefault();
        let value = $(this).val().toString();

        if ( !valid_pas_low_l( value ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( value ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( value ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain digit.");
        }

        if ( !valid_pas_s( value ) ) {
            display_warning("pass", "pass_new", "New password doesn't contain symbol (anything but digit or letter).");
        }

        if ( !string_has_length( value, 10) ) {
            display_warning("pass", "pass_new", "New password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        if ( valid_password( value ) ) {
            display_ack("pass", "pass_new", null);
        }
    });


    /* validates confirming password at the same time as user is typing */
    $("#password_new_again").on("keyup", function (event) {
        event.preventDefault();
        let value = $(this).val().toString();

        if ( !valid_pas_low_l( value ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( value ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( value ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain digit.");
        }

        if ( !valid_pas_s( value ) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't contain symbol (anything but digit or letter)");
        }

        if ( !string_has_length( value, 10) ) {
            display_warning("pass", "pass_new_again", "Confirming password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        let pass = $("#password_new").val().toString();

        if (value !== pass){
            display_warning("pass", "pass_new_again", "Confirming password and New password aren't same.");
        }

        if ( valid_password( value ) && (value === pass)) {
            display_ack("pass", "pass_new_again", null);
        }
    });


    /* will change name, surname of user */
    $("#change_name_button").on("click", function (event) {
        event.preventDefault();

        let name = $("#name").val().toString();
        let surname = $("#surname").val().toString();

        if (!string_isn_t_longer(name, 40)) {
            display_warning("name", null, "Name is longer than is allowed. Max allowed length of name is 40 characters.");
            $(this).blur();
            return;
        }

        if (!string_isn_t_longer(surname, 40)) {
            display_warning("name", null, "Surname is longer than is allowed. Max allowed length of surname is 40 characters.");
            $(this).blur();
            return;
        }

        $.ajax({
            url: "scripts/query_settings.php",
            method: "POST",
            data: {
                mode: "change_name",
                name: name,
                surname: surname
            },
            success: display_result
        });

    });


    /* changes email */
    $("#change_email_button").on("click", function (event) {
        event.preventDefault();
        let email = $("#email").val().toString();

        if (!string_isn_t_longer(email, 40)) {
            display_warning("mail", "mail", "Email is longer than is allowed. Max allowed length of email is 100 characters.");
            $(this).blur();
            return;
        }

        if (!valid_email(email)) {
            display_warning("mail", "mail", "Email has invalid format.");
            $(this).blur();
            return;
        }

        $.ajax({
            url: "scripts/query_settings.php",
            method: "POST",
            data: {
                mode: "change_email",
                email: email
            },
            success: display_result
        });

    });


    /* validates email format at the same time as user is typing */
    $("#email").on("keyup", function (event) {
        event.preventDefault();

        if ( valid_email( $(this).val().toString() ) ) {
            display_ack("mail", "mail", null);
        }
        else {
            display_warning("mail", "mail", "Email has invalid format.");
        }
    });


    /* changes profile picture */
    $("#change_pic_button").on("click", function (event) {
        event.preventDefault();

        if( $("#profile_pic").get(0).files.length === 0) {
            display_warning("pic", null, "No file has been selected.");
            return;
        }

        let form_data = new FormData($("#change_pic")[0]);

        $.ajax({
            url: "scripts/upload_profile_img.php",
            type: "POST",
            data: form_data,
            processData: false,
            cache: false,
            contentType: false,
            success: function(data) {

                data = data.toString().split("|");

                if (data[0] === "0") {
                    display_warning("pic", null, data[1]);
                }
                else {

                    /* view uploaded file. */
                    $("#preview img").attr("src", data);
                    $("#change_pic")[0].reset();

                    /* display confirming message */
                    display_ack("pic", null, "Profile image changed successfully.");

                }
            },
            fail: function (data) {
                display_warning("pic", null, data);
            }
        });

        $(this).blur();
    });


    /* displays preview of a image intended to be uploaded */
    function imagesPreview (placeToInsertImagePreview) {

        /* Empty preview so we can safely rebuild it */
        $(placeToInsertImagePreview).empty();

        /* Get file */
        let elem = document.getElementById("profile_pic");

        /* preview file */

        if (elem.files.length !== 0) {
            let reader = new FileReader();
            let id = $(elem).attr('id');

            reader.onload = (function(id) {
                return function(e){
                    $($.parseHTML('<img>')).attr({
                        'src' : e.target.result,
                        'alt' : "Upload image preview"
                    }).appendTo(placeToInsertImagePreview);
                }
            })(id);

            reader.readAsDataURL(elem.files[0]);
        }

    }


    /* if value of input[type=file] changes will display preview */
    $("#profile_pic").on("change", function() {
        imagesPreview("#preview");
    });


    /* changes information  */
    $("#change_info_button").on("click", function () {
        let location = $("#location").val().toString();
        let gender = $("#gender").val().toString();
        let day_of_birth = $("#day_of_birth").val().toString();
        let month_of_birth = $("#month_of_birth").val().toString();
        let year_of_birth = $("#year_of_birth").val().toString().trim();

        if (!string_isn_t_longer(location, 100)) {
            display_warning("info", null, "Location is longer than allowed. Max allowed length of location is 100 characters.");
            $(this).blur();
            return;
        }

        if (year_of_birth !== "") {
            if (!valid_year(year_of_birth)) {
                display_warning("info", null, "Year has wrong format (isn't year or is in forbidden range).");
                $(this).blur();
                return;
            }
        }

        $.ajax({
            url: "scripts/query_settings.php",
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

    });


    /* changes theme */
    $("#change_theme_button").on("click", function () {
        let theme = $("#change_theme").is(":checked");
        if (theme) theme = "dark";
        else theme = "light";

        $.ajax({
            url: "scripts/query_settings.php",
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
        let bio = $("#biography").val().toString();

        $.ajax({
            url: "scripts/query_settings.php",
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
        url: "scripts/query_settings.php",
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
        $('#res_' + data[0]).removeClass("form_result_neg");
        $("#res_" + data[0]).addClass("form_result_pos");
        $("#res_" + data[0] + " p").html("Successfully changed.");

        if(data[0] === "theme" || data[0] === "name") {
            $.ajax({
                url: "scripts/query_settings.php",
                method: "POST",
                data: {
                    mode: "update_session"
                },
                success: function () {
                    location.reload();
                }
            });
        }
    }
    else {
        $('#res_' + data[0]).removeClass("form_result_pos");
        $("#res_" + data[0]).addClass("form_result_neg");
        $("#res_" + data[0] + " p").html(data[2]);
    }
}
