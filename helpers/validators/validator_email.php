<?php
/* Валидация почты */

// проверить корректность адреса почты
function checkEmail(&$email_value, &$email_error, $validation_function, $unique_function) {
    if (!empty($_POST["email"])) 
        validate_field("email", $email_value, $email_error, $validation_function, true, $unique_function);
    else 
        $email_error = "Введите адрес почты";
}

// функция для валидации почты
$validate_email = function ($email) {
    // проверка на формат электронной почты
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        return "Некорректный формат адреса почты";
    // проверка на число символов
    if (strlen($email) > 100)
        return "Слишком длинный адрес почты";
    return "ok";
};

// функция для проверки уникальности почты
$validate_email_unique = function($email) {
    $connection = connect();
    if (sameUserExists($connection, "email", $email))
        return "Адрес почты уже используется";
    return "ok";
};
?>