<!DOCTYPE html>
<html>
<head>
<title>Вход в систему</title>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css"/>
<!--<script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>-->
</head>
<body>
<?php 
include_once "controllers/signin_controller.php";
include_once "helpers/html_helper.php";

// логин (если был введен ранее)
$login = "";
// ошибки
$login_error = $password_error = "";

loadPage($login, $login_error, $password_error);
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
            <form action="controllers/signin_controller.php" method="POST">
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
                <!--<div
                    id="captcha-container"
                    class="smart-captcha"
                    data-sitekey="ysc1_TNOu5SOalXzb1rg8kKVcdSWeckcp4O8abuBiXHEqc8c7be6e"
                ></div>-->
                <input class="button" type="submit" value="Войти">
            </form>
        </div>
    </div>
    <div class="empty-block"></div>
</div>
<?php createFooter(); ?>
</body>
</html>
