<!DOCTYPE html>
<html>
<head>
<title>Главная страница</title>
<meta charset="utf-8" />
</head>
<body>
<div id="header">
    <h2>Добро пожаловать!</h2>
</div>
<div id="message">
    <?php
    include "session.php";

    // вывести информационное сообщение, если есть
    echo "<p>" . getValueFromSession("message") . "</p>";

    session_destroy();
    ?>
</div>
<div id="buttons">
    <div id="signin">
        <a href="signin.php">Войти</a>
    </div>
    <div id="signup">
        <a href="signup.php">Зарегистрироваться</a>
    </div>
</div>
</body>
</html>