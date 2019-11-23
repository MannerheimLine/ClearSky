/*
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
        $('#message').remove();
        if (response.status === 'success'){
            setTimeout(function () {
                window.location.href = '/patient-card';
            },1000);
            $('#login-form').prepend(`<div id="message">${response.complete.response[0].message.text}</div>`);
        }else {
            switch (errorType) {
                case 'emptyFields' : emptyFields(); break;
                default : $('#login-form').prepend(`<div id="message">${response.complete.response[0].message.text}</div>`);
            }

        }
    });
});

const emptyFields = function (data) {
    $.each(data, function (key, value) {
        $('#login-form').prepend(`<div id="message">${value.message.text}</div>`);
    })
};
