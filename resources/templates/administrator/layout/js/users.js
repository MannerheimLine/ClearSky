/*
 *
 *
 *
 *
 */

const usersMenu = $('#users-menu');
const usersBody = $('#users-body');

$(function () {
    loadMenu();
    let state = localStorage.getItem("usersState");
    switch (state){
        case "users": loadUsers(); break;
        case "rbac":  loadRBAC(); break;
        default: loadUsers(); break; //Если состояние еще не установлено, будет подгружаться заданная страница
    }
});

usersMenu.on('click','.btn', function () {
    usersMenu.each(function () {
        $('.btn').addClass('btn-outline-dark').removeClass('btn-dark');
    });
    $(this).addClass('btn-dark').removeClass('btn-outline-dark');
});

usersMenu.on('click', '#users-button', function () {
    loadUsers();
});

usersMenu.on('click', '#rbac-button', function () {
    loadRBAC();
});

const loadUsers = function () {
    flipButtons('#users-button');
    usersBody.empty();
    let line = `<div>Тут будут пользователи</div>`;
    usersBody.append(line);
    localStorage.setItem('usersState', 'users');
};

const loadRBAC = function () {
    flipButtons('#rbac-button');
    usersBody.empty();
    let line = `<div>Тут будут привелегии и роли</div>`;
    usersBody.append(line);
    localStorage.setItem('usersState', 'rbac');
};

const loadMenu = function () {
    let usersButton = $(`<button id="users-button" class="btn btn-outline-dark btn-sm mr-1"><i class="fa fa-user"></i> Пользователи</button>`).hide().fadeIn(1000);
    let rbacButton = $(`<button id="rbac-button" class="btn btn-outline-dark btn-sm mr-1"><i class="fa fa-user-tag"></i> Роли и привелегии</button>`).hide().fadeIn(1000);

    usersMenu.append(usersButton);
    usersMenu.append(rbacButton);
};

const flipButtons = function (buttonId) {
    usersMenu.each(function () {
        $('.btn').addClass('btn-outline-dark').removeClass('btn-dark');
    });
    $(buttonId).addClass('btn-dark').removeClass('btn-outline-dark');
};