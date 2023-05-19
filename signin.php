<!DOCTYPE html>
<html>
<head>
<title>Вход в систему</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<?php 
include_once "router.php";
include_once "helpers/session.php";
include_once "helpers/html_helper.php";

routeUser("signin");

// получить данные из сессии

// логин (если был введен ранее)
$login = getValueFromSession("login");

// ошибки
$login_error = getValueFromSession("login_error");
$password_error = getValueFromSession("password_error");

removeValuesFromSession(compact("login_error", "password_error"));
session_destroy();

?>
<?php createHeader(); ?>
<div class="flex-container">
    <div class="empty-block"></div>
    <div id="content">
        <?php showMessage(); ?>
        <div id="user-menu">
            <div id="title">
                <h1>Вход в систему</h1>
            </div>
            <form action="formhandlers/authorization.php" method="POST">
                <div class="flex-container">
                    <div class="left-side">
                        <p>Логин (телефон или почта):</p>
                    </div>
                    <div class="right-side">
                        <input type="text" name="login" value="<?php echo $login;?>" /><span class="error">*</span>
                    </div>
                </div>    
                <div class="error-line">
                    <?php showError($login_error); ?>
                </div>
                <div class="flex-container">
                    <div class="left-side">
                        <p>Пароль:</p>
                    </div>
                    <div class="right-side">
                        <input type="password" name="password" /><span class="error">*</span>
                    </div>
                </div>   
                <div class="error-line">
                    <?php showError($password_error); ?>
                </div>
                <input class="button" type="submit" value="Войти">
            </form>
        </div>
    </div>
    <div class="empty-block"></div>
</div>
<?php createFooter(); ?>
</body>
</html>


