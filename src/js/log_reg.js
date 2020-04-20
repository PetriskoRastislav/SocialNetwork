
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


    /* validates password at the same time as user is typing */
    $("#password_reg").on("keyup", function (event) {
        event.preventDefault();

        if ( !valid_pas_low_l( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain digit.");
        }

        if ( !valid_pas_s( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg", "Password doesn't contain symbol (anything but digit or letter).");
        }

        if ( !string_has_length( $(this).val().toString(), 10) ) {
            display_warning("reg", "pass_reg", "Password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        if ( valid_password( $(this).val().toString() ) ) {
            display_ack("reg", "pass_reg", "Password has valid format.");
        }
    });


    /* validates confirming password format at the same time as user is typing */
    $("#password_reg_again").on("keyup", function (event) {
        event.preventDefault();

        if ( !valid_pas_low_l( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain lowercase letter.");
        }

        if ( !valid_pas_up_l( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain uppercase letter.");
        }

        if ( !valid_pas_d( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain digit.");
        }

        if ( !valid_pas_s( $(this).val().toString() ) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't contain symbol (anything but digit or letter)");
        }

        if ( !string_has_length( $(this).val().toString(), 10) ) {
            display_warning("reg", "pass_reg_again", "Confirming password doesn't meet minimum length. Minimal length is 10 characters.");
        }

        let pass = $("#password_reg").val().toString();

        if (!($(this).val().toString() === pass)){
            display_warning("reg", "pass_reg_again", "Confirming password and New password aren't same.");
        }

        if ( valid_password( $(this).val().toString() ) && ($(this).val().toString() === pass)) {
            display_ack("reg", "pass_reg_again", "Confirming password has valid format.");
        }
    });


    /* validates email format at the same time as user is typing */
    $("#email_reg").on("keyup", function (event) {
        event.preventDefault();

        if ( valid_email( $(this).val().toString() ) ) {
            display_ack("res", "email_reg", "Email has valid format.");
        }
        else {
            display_warning("res", "email_reg", "Email has invalid format.");
        }
    });


});


