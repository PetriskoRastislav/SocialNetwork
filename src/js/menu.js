<<<<<<< HEAD



document.getElementById("header_menu_drop_btn").addEventListener("click", function(){
    let drop_content = document.getElementById('header_drop_content');
    let drop_btn = document.getElementById('header_menu_drop_btn');
    let arrow = document.getElementById('arrow_btn_menu');

    if(drop_content.style.display === 'block'){
        drop_content.style.display = 'none';
        drop_btn.classList.remove('header_menu_drop_btn_active');
        arrow.classList.remove('up_arrow');
        arrow.classList.add('down_arrow');
    }
    else{
        drop_content.style.display = 'block';
        drop_btn.classList.add('header_menu_drop_btn_active');
        arrow.classList.remove('down_arrow');
        arrow.classList.add('up_arrow');
    }
=======
$(document).ready(function() {


    $(document).on("click", "#header_menu_drop_btn",  function () {

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

>>>>>>> development
});

/*document.addEventListener('click', function(event) {

    //if (event.target !== document.getElementById('#arrow_btn_menu')) {
        console.log("here i am");

        let drop_content = document.getElementById("header_drop_content");


        if(drop_content.style.display === 'block'){

            let drop_btn = document.getElementById('header_menu_drop_btn');
            let arrow = document.getElementById('arrow_btn_menu');

            drop_content.style.display = 'none';
            drop_btn.classList.remove('header_menu_drop_btn_active');
            arrow.classList.remove('up_arrow');
            arrow.classList.add('down_arrow');
        }
    //}
}, true);*/





/*$(document).ready(function(){
    // Show hide popover
    $(".header_menu_drop_btn").click(function(){
        let drop_content = document.getElementById('header_drop_content');
        let drop_btn = document.getElementById('header_menu_drop_btn');
        let arrow = document.getElementById('arrow_btn_menu');

        if(drop_content.style.display === 'block'){
            drop_content.style.display = 'none';
            drop_btn.classList.remove('header_menu_drop_btn_active');
            arrow.classList.remove('up_arrow');
            arrow.classList.add('down_arrow');
        }
        else{
            drop_content.style.display = 'block';
            drop_btn.classList.add('header_menu_drop_btn_active');
            arrow.classList.remove('down_arrow');
            arrow.classList.add('up_arrow');
        }
    });
});*/


/*$(window).on("click", function(event){
    let $trigger = $(".header_menu_drop_btn");
    let drop_content = document.getElementById('header_drop_content');
    let drop_btn = document.getElementById('header_menu_drop_btn');
    let arrow = document.getElementById('arrow_btn_menu');

    //if($trigger !== event.target && !$trigger.has(event.target).length){

        drop_content.style.display = 'none';
        drop_btn.classList.remove('header_menu_drop_btn_active');
        arrow.classList.remove('up_arrow');
        arrow.classList.add('down_arrow');
    //}
});*/





/*document.getElementById('div_main').addEventListener('click', function (){
    let drop_content = document.getElementById('header_drop_content');
    let drop_btn = document.getElementById('header_menu_drop_btn');
    let arrow = document.getElementById('arrow_btn_menu');

    if(drop_content.style.display === 'block'){
        drop_content.style.display = 'none';
        drop_btn.classList.remove('header_menu_drop_btn_active');
        arrow.classList.remove('up_arrow');
        arrow.classList.add('down_arrow');
    }

});*/


/*function showDropContent(){
    let drop_content = document.getElementById('header_drop_content');
    let drop_btn = document.getElementById('header_menu_drop_btn');
    if(drop_content.style.display === 'block'){
        drop_content.style.display = 'none';
        drop_btn.classList.remove('header_menu_drop_btn_active');
    }
    else{
        drop_content.style.display = 'block';
        drop_btn.classList.add('header_menu_drop_btn_active');
    }
}*/


/*window.onclick = function(e) {
    let drop_btn = document.getElementById('header_menu_drop_btn');
    let drop_content = document.getElementById("header_drop_content");

    if (e.target !== drop_content) {
        if (drop_content.style.display === 'block') {
            drop_content.style.display = 'none';
        }
    }

    if ( ) {
        if(drop_content.style.display === 'block'){
            drop_content.style.display = 'none';
            drop_btn.classList.remove('header_menu_drop_btn_active');
        }
        else{
            drop_content.style.display = 'block';
            drop_btn.classList.add('header_menu_drop_btn_active');
        }
    }

};*/



























/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
/*function showDrop() {
    document.getElementById("header_drop_content").classList.toggle("header_drop_content_show");
}*/

/*$(document).ready(function(){*/

    /*window.onclick = function(event) {
        let drop_content = document.getElementById('header_drop_content');
        let drop_btn = document.getElementById('header_menu_drop_btn');

        if(event.target !== drop_btn || event.target !== drop_content){
            if(drop_content.style.display === 'block') drop_content.style.display = 'none';
        }
    };*/

//});


/*$(document).on('click', '#page', function () {
    let drop_content = document.getElementById('header_drop_content');
    let drop_btn = document.getElementById('header_menu_drop_btn');
    if(drop_content.style.display === 'block'){
        drop_content.style.display = 'none';
        drop_btn.classList.remove('header_menu_drop_btn_active')
    }
});*/

/*$(Document).on('click', '#page', function () {
    let drop_content = document.getElementById('header_drop_content');
    if(drop_content.style.display === 'block') drop_content.style.display = 'none';
});*/

/*function toggleDropContent(){
    let drop_content = document.getElementById('header_drop_content');
    if(drop_content.style.display === 'block')drop_content.style.display = 'none';
    else drop_content.style.display = 'block';
}*/

// Close the dropdown if the user clicks outside of it


/*window.onclick = function(e) {
    if (!e.target.addEventListener)) {
        let myDropdown = document.getElementById("header_drop_content");
        if (myDropdown.classList.contains('show')) {
            myDropdown.classList.remove('show');
        }
    }
};*/

/*$(document).ready(function () {
    $(document.getElementById('header_menu_drop_btn')).on('click', 'body' , function () {

        let drop_content = document.getElementById('header_drop_content');
        if(drop_content.style.display === 'block') drop_content.style.display = 'none';
        else drop_content.style.display = 'block';
    });
});*/

