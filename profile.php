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
include_once "helpers/html_helper.php";
include_once "controllers/profile_controller.php";

// переменные с ошибками, используемые на странице
$name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";
// редактируемый пользователь
$user = loadPage($name_error, $phone_error, $email_error, $password_error, $password_conf_error);
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