<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
</head>
<body>
<h2>Форма регистрации</h2>
<form action="registration.php" method="POST">
    <p>Имя: <input type="text" name="name" /></p>
    <p>Телефон: <input type="tel" placeholder="+7-(XXX)-XXX-XXXX" name="phone" /></p>
    <p>Почта: <input type="email" placeholder="user@yandex.ru" name="email" /></p>
    <p>Пароль: <input type="password" name="password" /></p>
    <p>Подтвердите пароль: <input type="password" name="password_confirmation" /></p>
    <input type="submit" value="Зарегистрироваться">
</form>
</body>
</html>