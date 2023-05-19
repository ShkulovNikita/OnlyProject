<!DOCTYPE html>
<html>
<head>
<title>Вход в систему</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php 
include_once "helpers/session.php";
include_once "helpers/html_helper.php";

// получить данные из сессии

// логин (если был введен ранее)
$login = getValueFromSession("login");

// ошибки
$login_error = getValueFromSession("login_error");
$password_error = getValueFromSession("password_error");

session_destroy();
?>
<?php createHeader(); ?>
<h2>Форма авторизации</h2>
<form action="formhandlers/authorization.php" method="POST">
    <p>Логин (телефон или почта): <input type="text" name="login" value="<?php echo $login;?>" /><span class="error">* <?php echo $login_error ?></p>
    <p>Пароль: <input type="password" name="password" /><span class="error">* <?php echo $password_error ?></p>
    <input type="submit" value="Войти в систему">
</form>
<?php createFooter(); ?>
</body>
</html>