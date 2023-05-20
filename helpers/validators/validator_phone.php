<?php
/* Валидация номера телефона */

// проверить корректность поля телефона
function checkPhone(&$phone_value, &$phone_error, $validation_function, $unique_function) {
    if (!empty($_POST["phone"]))
        validate_field("phone", $phone_value, $phone_error, $validation_function, true, $unique_function);
    else
        $phone_error = "Введите номер телефона";
}

// функция для валидации номера телефона
$validate_phone = function ($phone) {
    /* проверить соответствие формату телефона */
    $regex_pattern = '~^(?:\+7|8|7)\d{10}$~';
    if (!preg_match($regex_pattern, $phone))
        return "Неверный формат номера телефона";
    return "ok";
};

// функция для проверки уникальности телефона
$validate_phone_unique = function ($phone) {
    $connection = connect();
    // оставить последние 10 цифр телефона
    truncatePhone($phone);
    if (sameUserExists($connection, "phone", $phone))
        return "Телефон уже используется";
    return "ok";
};
?>