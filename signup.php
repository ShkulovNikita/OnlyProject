<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php 
include_once "helpers/session.php";
include_once "helpers/html_helper.php";

// значения полей (если были введены ранее)
$name = getValueFromSession("name");
$phone = getValueFromSession("phone");
$email = getValueFromSession("email");

// ошибки
$name_error = getValueFromSession("name_error");
$phone_error = getValueFromSession("phone_error");
$email_error = getValueFromSession("email_error");
$password_error = getValueFromSession("password_error");
$password_conf_error = getValueFromSession("password_conf_error");

session_destroy();
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