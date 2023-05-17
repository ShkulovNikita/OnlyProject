<?php
include_once "db_connector.php";
/* Функции для валидации полей форм */

// функция для проверки идентичности введенных паролей
function checkPasswords($password, $password_confirm) {
    if ($password == $password_confirm)
        return true;
    else
        return false;
}

// функция для валидации имени
function validateName($name) {
    // имя должно содержать только буквы, пробелы и дефисы
    if (!preg_match("/^[a-zA-Zа-яёА-ЯЁ-' ]*$/", $name)) {
        return "Некорректные символы в имени";
    }
    // проверка количества символов
    if (strlen($name) > 150) {
        return "Слишком длинное имя";
    }
    if (strlen($name) < 4) {
        return "Слишком короткое имя";
    }
    return "ok";
}

// функция для валидации почты
function validateEmail($email) {
    // проверка на формат электронной почты
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        return "Некорректный формат адреса почты";
    // проверка на число символов
    if (strlen($email > 100))
        return "Слишком длинный адрес почты";
    // проверка на существование пользователя с такой почтой
    $connection = connect();
    if (emailExists($connection, $email))
        return "Адрес почты уже используется";
    return "ok";
}

// функция для валидации номера телефона
function validatePhone($phone) {
    /* проверить соответствие формату телефона */
    $regex_pattern = '~^(?:\+7|8|7)\d{10}$~';
    if (preg_match($regex_pattern, $phone) == 0)
        return "Неверный формат номера телефона"
    // проверка на существование пользователя с таким же номером телефона
    $connection = connect();
    if (phoneExists($connection, $phone))
        return "Телефон уже используется";
    return "ok";
}

// функция проверки паролей и их совпадения
function validatePassword($password, $password_confirm) {
    // количество символов в пароле
    if (strlen($password) < 7) {
        return "Пароль должен состоять минимум из 6 символов";
    }
    // совпадение паролей
    if ($password != $password_confirm) {
        return "Пароли не совпадают";
    }
}

?>