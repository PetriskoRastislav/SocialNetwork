
/* will validate length of strings */
function valid_string (string, length) {
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