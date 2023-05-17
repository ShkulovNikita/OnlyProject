<?php
include "db_connector.php";

// переменные, соответствующие полям формы
$name = $phone = $email = $password = $password_confirmation = "не задан";

// функция для проверки идентичности введенных паролей
function checkPasswords($password, $password_confirm) {
    if ($password == $password_confirm)
        return true;
    else
        return false;
}

function signUp($name, $phone, $email, $password, $password_confirm) {

    // захэшировать пароль
    $password = password_hash($password, PASSWORD_DEFAULT);

    // установить соединение с БД
    $connection = connect();

    // создать пользователя в БД
    createUser($connection, $name, $phone, $email, $password);
}

?>