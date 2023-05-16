<?php
include "db_connector.php";

// переменные, соответствующие полям формы
$name = $phone = $email = $password = $password_confirmation = "не задан";

connect();

// функция для проверки идентичности введенных паролей
function checkPasswords($password, $password_confirm) {
    if ($password == $password_confirm)
        return true;
    else
        return false;
}

?>