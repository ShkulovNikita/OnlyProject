<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
</head>
<body>
<?php 
include_once "session.php";

// переменные, соответствующие полям формы
$name = $phone = $email = $password = $password_confirmation = "";
// переменные с ошибками
$name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

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
<form action="registration.php" method="POST">
    <p>Имя: <input type="text" name="name" value="<?php echo $name;?>" /><span class="error">* <?php echo $name_error ?></p>
    <p>Телефон: <input type="tel" placeholder="+7XXXXXXXXXX" name="phone" value="<?php echo $phone;?>" /><span class="error">* <?php echo $phone_error ?></p>
    <p>Почта: <input type="email" placeholder="user@yandex.ru" name="email" value="<?php echo $email;?>" /><span class="error">* <?php echo $email_error ?></p>
    <p>Пароль: <input type="password" name="password" /><span class="error">* <?php echo $password_error ?></p>
    <p>Подтвердите пароль: <input type="password" name="password_confirmation" /><span class="error">* <?php echo $password_conf_error ?></p>
    <input type="submit" value="Зарегистрироваться">
</form>
</body>
</html>