<?php
include_once "db_connector.php";
include_once "session.php";
/* Функции для валидации полей форм */

// валидация значения (value) выбранной функцией (validation_function)
// с записью ошибки (если есть) в error
function validate($validation_function, $value, &$error) {
    $validation_result = $validation_function($value);
    if ($validation_result != "ok") 
        $error = $validation_result;
}

// функция для валидации имени
$validate_name = function ($name) {
    // имя должно содержать только буквы, пробелы и дефисы
    if (!preg_match("/^(([a-zA-Z-' ])|([а-яА-ЯЁё])|([0-9]))*$/", $name)) 
        return "Некорректные символы в имени";
    // проверка количества символов
    if (strlen($name) > 150) 
        return "Слишком длинное имя";
    if (strlen($name) < 4) 
        return "Слишком короткое имя";
    return "ok";
};

// функция для проверки уникальности имени
$validate_name_unique = function($name) {
    $connection = connect();
    if (nameExists($connection, $name))
        return "Имя уже используется";
    return "ok";
};

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
    if (emailExists($connection, $email))
        return "Адрес почты уже используется";
    return "ok";
};

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
    if (phoneExists($connection, $phone))
        return "Телефон уже используется";
    return "ok";
};

// функция проверки пароля
$validate_password = function ($password) {
    // количество символов в пароле
    if (strlen($password) < 6) 
        return "Пароль должен состоять минимум из 6 символов"; 
    return "ok";
};

// функция для проверки идентичности введенных паролей
$validate_password_conf = function ($password, $password_confirm) {
    // совпадение паролей
    if ($password != $password_confirm) 
        return "Пароли не совпадают";
    return "ok";
};

// оставить последние 10 цифр телефона
function truncatePhone (&$phone) {
    // убрать первую цифру и плюс, если есть
    $phone = match(strlen($phone)) {
        11 => substr($phone, 1, strlen($phone) - 1),
        12 => substr($phone, 2, strlen($phone) - 1),
    };
}
?>