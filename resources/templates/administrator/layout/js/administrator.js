/**
 *
 */

const sideBar = $('#sidebar_section');

$(function () {
    loadAdminMenu(1);
});


/**
 * Загрузка меню, клики по ссылкам меню
 */

const loadAdminMenu = function (menuId) {
    let request =  $.ajax({
        type: "POST",
        url: "/menu/get",
        data: {'menuId' : menuId},
        cache: false
    });
    request.done(function (response) {
        if(response.status === 'success'){
            let menu = `<nav class="main-menu">
                    <div class="area">
                        <ul id="menu-items"></ul>
                    </div>
                </nav>`;
            $('#sidebar_section').append(menu);
            let menuItems = $('#menu-items');
            $.each(response.complete.response[0].menu, function (key, value) {
                let menuItem = `<li id="${value.name}" class="menu-item">
                     <a href="${value.link}" class="menu-link">
                        <i class="fa-for-menu ${value.icon}"></i>
                        <span class="nav-text">${value.title}</span>
                     </a>
                 </li>`;
                menuItems.append(menuItem);
            });
            getSelectedLink();
        }else {
            //Пока алерт. Но потом буду выводить в общий лог ошибок
            alert(response.incomplete.message[0].text);
        }
    });
};

const getSelectedLink = function(){
    let selectedLink = localStorage.getItem("menuSelectedLink");
    $('#'+selectedLink).addClass('selected');
};

sideBar.on('click', '.menu-item',function () {
    $('.menu-item').each(function () {
        $(this).removeClass('selected')
    });
    localStorage.setItem('menuSelectedLink', $(this).attr('id'));
    $(this).addClass('selected');
});

const logOut = function () {
    let request = $.ajax({
        type: "GET",
        url: "/logout",
        cache: false
    });
    request.done(function (response) {
        if (response.status === 'success'){
            window.location.href = '/login';
        } else {
            alert(response.incomplete.message);
        }
    });
};