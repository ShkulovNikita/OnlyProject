<!DOCTYPE html>
<html>
<head>
<title>Профиль пользователя</title>
<meta charset="utf-8" />
</head>
<body>
<?php 
include_once "classes/user.php";
include_once "helpers/session.php";
include_once "helpers/user_form.php";
include_once "helpers/user_helper.php";

// идентификатор текущего пользователя
$id = checkLogin();

// проверить, вошел ли пользователь
if ($id == false) 
    // если нет - редирект на главную
    redirectToMainPage();

$user = getUserData($id);

if ($user == "Не удалось получить пользователя")
    redirectToMainPage();

// ошибки
$name_error = getValueFromSession("name_error");
$phone_error = getValueFromSession("phone_error");
$email_error = getValueFromSession("email_error");
$password_error = getValueFromSession("password_error");
$password_conf_error = getValueFromSession("password_conf_error");

$message = getValueFromSession("message");

// очистить ошибки в сессии
removeValuesFromSession(compact("name_error", "phone_error", "email_error", "password_error", "password_conf_error", "message"));

?>
<?php if (isset($message)) echo "<p>$message</p>" ?>
<h2>Профиль пользователя</h2>
<?php createForm("profile", $user->name, $user->phone, $user->email, $name_error, $phone_error, $email_error, $password_error,$password_conf_error) ?>
</body>
</html>