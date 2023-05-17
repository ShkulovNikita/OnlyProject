<?php
include_once "db_connector.php";
include_once "validator.php";
/* Скрипты для обработки формы регистрации */


// регистрация пользователя
function signUp($name, $phone, $email, $password, $password_confirm) {
    // захэшировать пароль
    $password = password_hash($password, PASSWORD_DEFAULT);

    // установить соединение с БД
    $conn = connect();

    // создать пользователя в БД
    createUser($connection, $name, $phone, $email, $password);
}

?>