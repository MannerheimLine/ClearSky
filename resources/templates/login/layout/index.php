<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="resources/templates/login/layout/css/style.css">
        <script type="application/javascript" src="/resources/assets/jquery/jquery-3.4.1.min.js"></script>
        <title id="title"><?=$this->_title?></title>
    </head>
    <body>
    <!-- partial:index.partial.html -->
        <div class="login">
            <h1>Авторизация</h1>
            <div id="login-form">
                <input type="text" name="user-name" placeholder="Имя пользователя" required="required" />
                <input type="password" name="password" placeholder="Пароль" required="required" />
                <button type="button" id="login-button" class="btn btn-primary btn-block btn-large">Вход</button>
            </div>
        </div>
    <script type="application/javascript" src="resources/templates/login/layout/js/login.js"></script>
    </body>
</html>