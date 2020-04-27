$(document).ready(function() {


    /* opens a dropdown on menu */
    $("#header_menu_drop_btn").on("click", function () {

        let drop_content = $("#header_drop_content");
        let drop_btn = $("#header_menu_drop_btn");
        let arrow = $("#arrow_btn_menu");

        if (drop_content.hasClass("header_menu_drop_show")) {
            drop_content.removeClass("header_menu_drop_show");
            drop_btn.removeClass("header_menu_li_active");
            arrow.removeClass("up_arrow");
            arrow.addClass("down_arrow");
        }
        else {
            drop_content.addClass("header_menu_drop_show");
            drop_btn.addClass("header_menu_li_active");
            arrow.removeClass("down_arrow");
            arrow.addClass("up_arrow");
        }
    });


    /* displays field for searching users */
    $("#menu_search_icon").on("click", function () {
        let search_field_menu = $("#menu_search_field");
        let menu_search_icon = $(this);

        if (menu_search_icon.hasClass("menu_search_icon_active")) {

            search_field_menu.removeClass("show_v");
            search_field_menu.addClass("hide_v");
            menu_search_icon.removeClass("menu_search_icon_active");
        }
        else {

            search_field_menu.removeClass("hide_v");
            search_field_menu.addClass("show_v");
            menu_search_icon.addClass("menu_search_icon_active");
        }
    });


    /* will search for a user */
    $("#menu_search_field").on("keyup", function (event) {

        let value = $(this).val().toString();

        console.log(!(value.length > 0));


        if (!(value.length > 0)) {
            $("#menu_search_result").removeClass("show_v");
        }


        if (event.which === 27) {
            $("#menu_search_result").removeClass("show_v");
        }
        else if (event.which === 8 && value === "") {
            let result = $("#menu_search_result");
            result.html("");
            result.removeClass("show_v");
        }
        else if( !(event.which === 13 || event.which === 27)){

            $.ajax({
                url: "scripts/query_users.php",
                method: "POST",
                data: {
                    mode: "find_user_menu",
                    value: value
                },
                success: function (data) {

                    let result = $("#menu_search_result");
                    result.html(data);
                    result.addClass("show_v");

                }
            });
        }
    });

});
