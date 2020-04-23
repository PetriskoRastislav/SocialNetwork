

/* function that handles request friendship */
function process_request_friendship () {

    console.log("process request friendship");

    let url = new URLSearchParams(window.location.search);

    $.ajax({
        url: "scripts/query_friends.php",
        method: "POST",
        data: {
            mode: "request_friendship",
            user_to: url.get("user")
        },
        success: function (data) {

            if (data.toString() === "1") {

                let button = '<img class="requests_image requests_image_en" src="';
                if (theme === "dark") button += "src_pictures/icons8-remove-user-group-man-man-100-white.png";
                else button += "src_pictures/icons8-remove-user-group-man-man-100.png";
                button += '" id="cancel_friendship_request" title="Cancel Friendship Request" alt="Cancel Friendship Request" onclick="process_cancel_friendship_request">';

                console.log("switching to cancel friendship request");

                $("#request_friendship").replaceWith(button);


            }
        }

    });

}


/* function that handles cancel friendship request */
function process_cancel_friendship_request () {

    console.log("process cancel friendship request");

    let url = new URLSearchParams(window.location.search);

    $.ajax({
        url: "scripts/query_friends.php",
        method: "POST",
        data: {
            mode: "cancel_friendship_request",
            user_to: url.get("user")
        },
        success: function (data) {

            if (data.toString() === "1") {

                let button = '<img class="requests_image requests_image_en" src="';
                if (theme === "dark") button += "src_pictures/icons8-add-user-group-man-man-100-white.png";
                else button += "src_pictures/icons8-add-user-group-man-man-100.png";
                button += '" id="request_friendship" title="Request Friendship" alt="Request Friendship" onclick="process_request_friendship()">';

                console.log("switching to request friendship");

                $("#cancel_friendship_request").replaceWith(button);


            }

        }
    });

}


/* function that handles cancel friendship */
function process_cancel_friendship () {

    console.log("process cancel friendship");

    let url = new URLSearchParams(window.location.search);

    $.ajax({
        url: "scripts/query_friends.php",
        method: "POST",
        data: {
            mode: "cancel_friendship",
            user_to: url.get("user")
        },
        success: function (data) {

            if (data.toString() === "1") {

                let button = '<img class="requests_image requests_image_en" src="';
                if (theme === "dark") button += "src_pictures/icons8-add-user-group-man-man-100-white.png";
                else button += "src_pictures/icons8-add-user-group-man-man-100.png";
                button += '" id="request_friendship" title="Request Friendship" alt="Request Friendship" onclick="process_request_friendship()">';

                console.log("switching to request friendship");

                $("#cancel_friendship").replaceWith(button);

            }

        }
    });

}

