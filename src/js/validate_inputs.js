
/* validates if string has minimum length */
function string_has_length (string, length) {
    if (string.length >= length) return true;
    else return false;
}


/* validates if string isn't longer than allowed */
function string_isn_t_longer (string, length) {
    if (string.length > length) return false;
    else return true;
}


/* Verifying that the email address has a valid format. */
function valid_email (email) {
    let regex =  /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    return regex.test(email);
}


/* will validate format of and range */
function valid_year (year) {
    let y = parseInt(year, 10);
    let d = new Date();
    if (y >= 1900 && y <= d.getFullYear()) return true;
    else return false;
}


/* will validate if password contains lowercase letter, uppercase letter, digit, and symbol (not letter nor digit) */
function valid_password (password) {
    let regex = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{10,}/;
    return regex.test(password);
}


/* validates if password contains lowercase letter */
function valid_pas_low_l (password) {
    let regex = /[a-z]+/g;
    return regex.test(password);
}


/* validates if password contains uppercase letter */
function valid_pas_up_l (password) {
    let regex = /[A-Z]+/g;
    return regex.test(password);
}


/* validates if password contains digit */
function valid_pas_d (password) {
    let regex = /[0-9]+/g;
    return regex.test(password);
}


/* validates if password contains symbol (anything but digit or letter) */
function valid_pas_s (password) {
    let regex = /[^a-zA-Z0-9]+/g;
    return regex.test(password);
}


/* will display warning when is something wrong with data in inputs */
function display_warning (where, stat, warning) {
    let w = "#res_" + where;

    $(w).removeClass("form_result_pos");
    $(w).addClass("form_result_neg");

    if (!(stat == null)) {
        let status = $("#" + stat + "_status");
        status.removeClass("hide");
        status.addClass("display_icon");
        status.attr("src", "src_pictures/icons8-checked-no-100.png");
        status.attr("alt", "Input has invalid format.");
    }
    $(w + " p").html(warning);
}


/* displays acknowledgement when data in input has valid email */
function display_ack (where, stat, ack) {
    let w = "#res_" + where;

    $(w).removeClass("form_result_neg");
    //$(w).addClass("form_result_pos");

    if (!(stat == null)) {
        let status = $("#" + stat + "_status");
        status.removeClass("hide");
        status.addClass("display_icon");
        status.attr("src", "src_pictures/icons8-checked-100.png");
        status.attr("alt", "Input has valid format.");
    }

    //$(w + " p").html(ack);
}