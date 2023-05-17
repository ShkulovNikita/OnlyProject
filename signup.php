<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8" />
</head>
<body>
<?php 
    include_once "db_connector.php";
    include_once "validator.php";
    /* Скрипты для обработки формы регистрации */
    
    // переменные, соответствующие полям формы
    $name = $phone = $email = $password = $password_confirmation = "не задан";
    // переменные с ошибками
    $name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";
    
    // валидация значения (value) выбранной функцией (validation_function)
    // с записью ошибки (если есть) в error
    function validate($validation_function, $value, &$error) {
        $validation_result = $validation_function($value);
        if ($validation_result != "ok") 
            $error = $validation_result;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // проверки полей на пустоту: все должны быть заполнены
        if (!empty($_POST["name"])) {
            $name = htmlspecialchars($_POST["name"]);
            // валидация
            validate($validate_name, $name, $name_error);
        }
        else
            $name_error = "Введите имя";

        if (!empty($_POST["phone"])) {
            $phone = htmlspecialchars($_POST["phone"]);
            validate($validate_phone, $phone, $phone_error);
        }
        else
            $phone_error = "Введите номер телефона";

        if (!empty($_POST["email"])) {
            $email = htmlspecialchars($_POST["email"]);
            validate($validate_email, $email, $email_error);
        }
        else 
            $email_error = "Введите адрес почты";

        if (!empty($_POST["password"])) {
            $password = htmlspecialchars($_POST["password"]);
            validate($validate_password, $password, $password_error);
        }
        else
            $password_error = "Введите пароль";

        if (!empty($_POST["password_confirmation"])) 
        {
            $password_confirmation = htmlspecialchars($_POST["password_confirmation"]);
            // проверить совпадение паролей
            if (!empty($_POST["password"])) {
                $val_result = $validate_password_conf($password, $password_confirmation);
                if ($val_result != "ok")
                    $password_conf_error = $val_result;
            }
        }
        else
            $password_conf_error = "Повторите пароль";

    }
?>
<h2>Форма регистрации</h2>
<form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]) ?>" method="POST">
    <p>Имя: <input type="text" name="name" /><span class="error">* <?php echo $name_error ?></p>
    <p>Телефон: <input type="tel" placeholder="+7XXXXXXXXXX" name="phone" /><span class="error">* <?php echo $phone_error ?></p>
    <p>Почта: <input type="email" placeholder="user@yandex.ru" name="email" /><span class="error">* <?php echo $email_error ?></p>
    <p>Пароль: <input type="password" name="password" /><span class="error">* <?php echo $password_error ?></p>
    <p>Подтвердите пароль: <input type="password" name="password_confirmation" /><span class="error">* <?php echo $password_conf_error ?></p>
    <input type="submit" value="Зарегистрироваться">
</form>
</body>
</html>