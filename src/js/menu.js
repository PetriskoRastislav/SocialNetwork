$(document).ready(function() {


    $("#header_menu_drop_btn").on("click", function () {

        let drop_content = $("#header_drop_content");
        let drop_btn = $("#header_menu_drop_btn");
        let arrow = $("#arrow_btn_menu");

        if (drop_content.hasClass("header_menu_drop_show")) {
            drop_content.removeClass("header_menu_drop_show");
            drop_btn.removeClass("header_menu_drop_btn_active");
            arrow.removeClass("up_arrow");
            arrow.addClass("down_arrow");
        }
        else {
            drop_content.addClass("header_menu_drop_show");
            drop_btn.addClass("header_menu_drop_btn_active");
            arrow.removeClass("down_arrow");
            arrow.addClass("up_arrow");
        }
    });

});
