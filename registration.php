<?php
include_once "db_connector.php";
include_once "validator.php";
/* Скрипты для обработки формы регистрации */


// регистрация пользователя
function signUp($name, $phone, $email, $password) {
    // захэшировать пароль
    $password = password_hash($password, PASSWORD_DEFAULT);

    // сократить номер телефона до 10 цифр
    truncatePhone($phone);

    // установить соединение с БД
    $connection = connect();

    // создать пользователя в БД
    createUser($connection, $name, $phone, $email, $password);
}

// оставить последние 10 цифр телефона
function truncatePhone (&$phone) {
    // убрать плюс, если он есть
    if (strlen($phone) == 12)
        $phone = str_replace("+", "", $phone);

    // убрать первую цифру (7 или 8)
    $phone = substr($phone, 1, strlen($phone) - 1);
}

?>