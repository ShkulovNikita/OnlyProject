<?php
include_once "db_connector.php";
include_once "validator.php";
/* Скрипты для обработки формы регистрации */


// регистрация пользователя
function signUp($name, $phone, $email, $password) {
    // захэшировать пароль
    $password = password_hash($password, PASSWORD_DEFAULT);

    // оставить последние 10 цифр номера телефона
    truncatePhone($phone);

    // установить соединение с БД
    $connection = connect();

    // создать пользователя в БД
    createUser($connection, $name, $phone, $email, $password);
}
?>