/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
/*function showDrop() {
    document.getElementById("header_drop_content").classList.toggle("header_drop_content_show");
}*/

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

window.onclick = function(e) {
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

};


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
    if (!e.target.addEventListene)) {
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

