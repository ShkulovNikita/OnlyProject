<!DOCTYPE html>
<html>
<head>
<title>Профиль пользователя</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php 
include_once "classes/user.php";
include_once "helpers/session.php";
include_once "helpers/user_helper.php";
include_once "helpers/html_helper.php";

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

// очистить ошибки в сессии
removeValuesFromSession(compact("name_error", "phone_error", "email_error", "password_error", "password_conf_error"));

?>
<?php createHeader(); ?>
<div class="flex-container">
    <div class="empty-block"></div>
    <div id="content">
        <?php showMessage(); ?>
        <div id="user-menu">
            <div id="title">
                <h1>Профиль пользователя</h1>
            </div>
            <?php createForm("profile", $user->name, $user->phone, $user->email, $name_error, $phone_error, $email_error, $password_error,$password_conf_error) ?>
            <a id="logout-button" class="button" href="logout.php">Выйти из профиля</a>
        </div>
    </div>
    <div class="empty-block"></div>
</div>
<?php createFooter(); ?>
</body>
</html>