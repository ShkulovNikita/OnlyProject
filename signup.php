<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
</head>
<body>
<?php 
include_once "helpers/user_form.php";
include_once "helpers/session.php";

// получить данные из сессии

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
<h2>Форма регистрации</h2>
<?php createForm("signup", $name, $phone, $email, $name_error, $phone_error, $email_error, $password_error, $password_conf_error) ?>
</body>
</html>