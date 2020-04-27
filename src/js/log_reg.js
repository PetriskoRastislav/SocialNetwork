;
$(document).ready( function () {


    /* will show register form and hide login form */
    $("#show_registration").on("click", function () {
        $("#login").addClass("hide");
        $("#registration").removeClass("hide");

        $("#show_login").removeClass("log_reg_active");
        $(this).addClass("log_reg_active");
    });


    /* will show login form and hide register form */
    $("#show_login").on("click", function () {
        $("#registration").addClass("hide");
        $("#login").removeClass("hide");

        $("#show_registration").removeClass("log_reg_active");
        $(this).addClass("log_reg_active");
    });


    /* validates email format at the same time as user is typing */
    $("#email_reg").on("keyup", function (event) {
        event.preventDefault();

        if ( valid_email( $(this).val().toString() ) ) {
            display_ack("reg", "email_reg", "Email has valid format.");
        }
        else {
            display_warning("reg", "email_reg", "Email has invalid format.");
        }
    });


    /* validates password at the same time as user is typing */
    $("#password_reg").on("keyup", function (event) {
        event.preventDefault();
        let value = $(this).val().toString();

        if ( !valid_pas_low_l( value ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( value ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( value ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain digit.");
        }

        if ( !valid_pas_s( value ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain symbol (anything but digit or letter).");
        }

        if ( !string_has_length( value, 10) ) {
            display_warning("reg", "pass_reg", "Password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        if ( valid_password( value ) ) {
            display_ack("reg", "pass_reg", "Password has valid format.");
        }
    });


    /* validates confirming password format at the same time as user is typing */
    $("#password_reg_again").on("keyup", function (event) {
        event.preventDefault();
        let value = $(this).val().toString();

        if ( !valid_pas_low_l( value ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( value ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( value ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain digit.");
        }

        if ( !valid_pas_s( value ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain symbol (anything but digit or letter).");
        }

        if ( !string_has_length( value, 10) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        let pass = $("#password_reg").val().toString();

        if (value !== pass){
            display_warning("reg", "pass_reg_again", "Confirming password and password aren't same.");
        }

        if ( valid_password( value ) && (value === pass)) {
            display_ack("reg", "pass_reg_again", "Confirming password has valid format.");
        }
    });


    /* logs in user, if credentials are valid php will redirect user to his profile,
     if not then will display error message here */
    $("#login_submit").on("click", function () {
        let email = $("#email_log").val().toString();
        let pass = $("#password_log").val().toString();

        if (! valid_email(email)) {
            display_warning("log", null, "Email has invalid format.");
            $(this).blur();
            return;
        }

        $.ajax({
            url: "scripts/login.php",
            method: "POST",
            data: {
                email: email,
                password: pass
            },
            success: res_log_reg
        });

        $(this).blur();
    });


    /* registers new user and validates inputs */
    $("#register_submit").on("click", function () {
        let name = $("#name_reg").val().toString();
        let surname = $("#surname_reg").val().toString();
        let email = $("#email_reg").val().toString();
        let pass = $("#password_reg").val().toString();
        let pass_again = $("#password_reg_again").val().toString();

        if (!string_isn_t_longer(name, 40)) {
            display_warning("reg", null, "Name is longer than is allowed. Max allowed length of name is 40 characters.");
            $(this).blur();
            return;
        }

        if (!string_isn_t_longer(surname, 40)) {
            display_warning("reg", null, "Surname is longer than is allowed. Max allowed length of surname is 40 characters.");
            $(this).blur();
            return;
        }

        if (!string_isn_t_longer(email, 40)) {
            display_warning("reg", null, "Email is longer than is allowed. Max allowed length of email is 100 characters.");
            $(this).blur();
            return;
        }

        if (!valid_email(email)) {
            display_warning("log", "email_reg", "Email has invalid format.");
            $(this).blur();
            return;
        }

        if (!valid_password(pass)) {
            display_warning("reg", "pass_reg", "Password has invalid format.");
            $(this).blur();
            return;
        }

        if (!valid_password(pass_again)) {
            display_warning("reg", "pass_reg_again", "Confirming password has invalid format.");
            $(this).blur();
            return;
        }

        if (!string_has_length(pass, 10)) {
            display_warning("reg", "pass_reg", "Password doesn't meet minimum length. Minimal length is 10 characters.");
            $(this).blur();
            return;
        }

        if (pass !== pass_again) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't match password");
            $(this).blur();
            return;
        }

        $.ajax({
            url: "scripts/registration.php",
            method: "POST",
            data: {
                name: name,
                surname: surname,
                email: email,
                password: pass,
                password_confirm: pass_again
            },
            success: res_log_reg
        });

        $(this).blur();
    });


});


/* display result of changing information about profile in selected div */
function res_log_reg (data) {
    console.log(data.toString());
    let a_data = data.toString().split("|");
    if(a_data[1] === "0" ) {
        display_warning(a_data[0], null, a_data[2]);
    }
    else {
        window.location.replace("profile.php?user=" + data.toString());
    }
}
