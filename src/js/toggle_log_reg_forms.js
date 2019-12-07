function shreg() {
    let log = document.getElementById("login");
    let reg = document.getElementById("registration");

    log.style.display = "none";
    reg.style.display = "block";
}

function shlog(event) {
    let log = document.getElementById("login");
    let reg = document.getElementById("registration");

    reg.style.display = "none";
    log.style.display = "block";
}