<!DOCTYPE html>
<html>
<head>
<title>Главная страница</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php
include_once "helpers/html_helper.php";
include_once "router.php";

routeUser("index");
?>
<?php createHeader(); ?>
<div class="flex-container">
    <div class="empty-block"></div>
    <div id="content">
        <!--вывести информационное сообщение, если есть-->
        <?php showMessage(); ?>
        <div id="user-menu">
            <div id="title">
                <h1>Добро пожаловать!</h1>
            </div>
            <div id="buttons">
                <div id="signin">
                    <a id="signin-button" class="button" href="signin.php">Войти</a>
                </div>
                <div id="signup">
                    <a id="signup-button" class="button" href="signup.php">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
    <div class="empty-block"></div>
</div>
<?php createFooter(); ?>
</body>
</html>