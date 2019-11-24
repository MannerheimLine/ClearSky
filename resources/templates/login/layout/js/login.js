/*
 *
 *
 *
 *
 *
 */

const loginButton = $('#login-button');

loginButton.on('click', function () {
    let login = $("input[name='user-name']").val();
    let password = $("input[name='password']").val();
    let request = $.ajax({
        type: "POST",
        url: "/login/do",
        data: {'login' : login, 'password' : password},
        cache: false
    });
    request.done(function (response) {
        $('.login-error-message').remove();

        if (response.status === 'success'){
            $('.login').empty();
            setTimeout(function () {
                window.location.href = '/patient-card';
            },1000);
            preload(response.complete.response[0].message.text);
        }else {
            $('#login-errors').append(`<div class="login-error-message">${response.incomplete.response[0].message.text}</div>`);
        }
    });
});

const preload = function (text) {
    let message = `<div class="login-redirect-message">${text}</div>`;
    let loader = `<div class="loader-wrapper">
        <div class="loader"></div>
      </div>`;
    let login = $('.login');
    login.append(message);
    setTimeout(function () {
        $('.login-redirect-message').text('Переадресация');
        login.prepend(loader);
    },500)
};