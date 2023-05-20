<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php 
include_once "helpers/html_helper.php";
include_once "controllers/signup_controller.php";

/* переменные, используемые на странице */
// значения полей ввода
$name = $phone = $email = ""; 
// сообщения об ошибках в полях
$name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

loadPage($name, $phone, $email, $name_error, $phone_error, $email_error, $password_error, $password_conf_error);
?>
<?php createHeader(); ?>
<div class="flex-container">
    <div class="empty-block"></div>
    <div id="content">
        <?php showMessage(); ?>
        <div id="user-menu">
            <div id="title">
                <h1>Форма регистрации</h1>
            </div>
            <?php createForm("signup", $name, $phone, $email, $name_error, $phone_error, $email_error, $password_error, $password_conf_error) ?>
        </div>
    </div>
    <div class="empty-block"></div>
</div>
<?php createFooter() ?>
</body>
</html>