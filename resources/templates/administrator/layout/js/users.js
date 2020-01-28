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
        case "accounts": loadAccounts(); break;
        case "roles":  loadRoles(); break;
        case "permissions":  loadPermissions(); break;
        default: loadAccounts(); break; //Если состояние еще не установлено, будет подгружаться заданная страница
    }
});

const loadMenu = function () {
    let usersButton = $(`<button id="accounts-button" class="btn btn-outline-dark btn-sm mr-1"><i class="fa fa-user"></i> Учетные записи</button>`).hide().fadeIn(1000);
    let rolesButton = $(`<button id="roles-button" class="btn btn-outline-dark btn-sm mr-1"><i class="fa fa-user-tag"></i> Роли</button>`).hide().fadeIn(1000);
    let permissionsButton = $(`<button id="permissions-button" class="btn btn-outline-dark btn-sm mr-1"><i class="fa fa-user-check"></i> Привелегии</button>`).hide().fadeIn(1000);
    usersMenu.append(usersButton);
    usersMenu.append(rolesButton);
    usersMenu.append(permissionsButton);
};

const flipButtons = function (buttonId) {
    //usersMenu.each(function () {
    //$('.btn').addClass('btn-outline-dark').removeClass('btn-dark');
    //});
    $(buttonId).addClass('btn-dark').removeClass('btn-outline-dark');
};

usersMenu.on('click','.btn', function () {
    usersMenu.each(function () {
        $('.btn').addClass('btn-outline-dark').removeClass('btn-dark');
    });
    $(this).addClass('btn-dark').removeClass('btn-outline-dark');
});

usersMenu.on('click', '#accounts-button', function () {
    loadAccounts();
});

usersMenu.on('click', '#roles-button', function () {
    loadRoles();
});

usersMenu.on('click', '#permissions-button', function () {
    loadPermissions();
});


/**
 * Вкладка пользователи
 */

const loadAccounts = function () {
    flipButtons('#accounts-button');
    usersBody.empty();
    let line = `<div id="accounts-tab-menu">
                    <button class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Добавить</button>
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Удалить выбранные</button>
                </div>`;
    usersBody.append(line);
    usersBody.append(loadAccountsTableTemplate());
    localStorage.setItem('usersState', 'accounts');
    let request = $.ajax({
        type: "GET",
        url: "/administrator/accounts/get",
        cache: false
    });
    request.done(function (response) {
        let tableContent = $('#accounts-table-content');
        $.each(response, function (key, value) {
           let line = loadAccountsTableContentLine(value);
           tableContent.append(line);
        });
    });
};

const loadAccountsTableTemplate = function () {
    return `
        <div id="accounts-tab-content" class="row" style="padding: 10px;">
            <table id="accounts-data-table" class="table-striped table-mine full-width box-shadow--2dp">
                 <thead>
                     <tr>
                         <th style="width: 5%;"><input type="checkbox"></th>
                         <th style="width: 20%;">Имя учетной записи</th>
                         <th style="width: 30%;">ФИО</th>
                         <th style="width: 30%;">Роли</th>
                         <th style="width: 15%;">Действия</th>
                     </tr>
                 </thead>
                 <tbody id="accounts-table-content"></tbody>
            </table>
        </div>
        <div id="accounts-tab-pagination">
        <div class="text-xs-center">
            <ul class="pagination pagination-center">
                <input id="current-page" name="current-page" hidden>
                <li class="page-item"><a id="previous-page" class="page-link" href="#">Предыдущая</a></li>
                <li class="page-item"><a id="next-page" class="page-link" href="#">Следующая</a></li>
            </ul>
        </div>
        <div id="modals">
            <!-- Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Редактирование пользователя: {Login}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm">Сохранить</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->
        </div>
    </div>`
};

const loadAccountsTableContentLine = function (response) {
    return $(`<tr class="tr-table-content">
                    <td hidden><input name="user-id" value="${response.id}"></td>
                    <td><input type="checkbox"></td>
                    <td>${response.login}</td>
                    <td>${response.surname ? response.surname : ''} ${response.firstname ? response.firstname : ''} ${response.secondname ? response.secondname : ''}</td>
                    <td>${formRolesCell(response)}</td>
                    <td>
                        <button class="btn btn-outline-warning btn-sm mr-1" data-toggle="modal" data-target="#editUserModal">
                            <i class="fa fa-edit"></i> 
                        </button>
                        <button class="btn btn-outline-danger btn-sm mr-1" onclick="loadCard(${response.id})">
                            <i class="fa fa-trash"></i> 
                        </button>
                    </td>
                </tr>`).hide().fadeIn(1000);
};

const formRolesCell = function (response) {
    let result = '';
    $.each(response.roles,function (index, value) {
        result += `<span class="badge badge-primary mr-1">${value.role_description}</span>`;
    });
    return result;
};

/**
 * Вкладка роли
 */

const loadRoles = function () {
    flipButtons('#roles-button');
    usersBody.empty();
    let line = `<div>Тут будут роли</div>`;
    usersBody.append(line);
    localStorage.setItem('usersState', 'roles');
};

/**
 * Вкладка привелегии
 */
const loadPermissions = function () {
    flipButtons('#permissions-button');
    usersBody.empty();
    let line = `<div>Тут будут привелегии</div>`;
    usersBody.append(line);
    localStorage.setItem('usersState', 'permissions');
};





