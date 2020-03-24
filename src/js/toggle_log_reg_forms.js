function showRegForm() {
    let log = document.getElementById("login");
    let reg = document.getElementById("registration");
    let log_button = document.getElementById("log_button");
    let reg_button = document.getElementById("reg_button");

    log.style.display = "none";
    log_button.classList.remove("logreg_active");
    reg.style.display = "block";
    reg_button.classList.add("logreg_active");
}

function showLogForm() {
    let log = document.getElementById("login");
    let reg = document.getElementById("registration");
    let log_button = document.getElementById("log_button");
    let reg_button = document.getElementById("reg_button");

    reg.style.display = "none";
    reg_button.classList.remove("logreg_active");
    log.style.display = "block";
    log_button.classList.add("logreg_active");
}