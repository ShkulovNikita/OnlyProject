<?php
include_once "$_SERVER[DOCUMENT_ROOT]/classes/user.php";
include_once "db_connector.php";
include_once "session.php";
/* Вспомогательные функции для профиля пользователя */

// получить данные о пользователе и вернуть в виде объекта
function getUserData($id) {
    // обратиться к БД
    $connection = connect();

    // получить пользователя
    $user = getUser($connection, "id", $id);

    if (!isset($user["id"]))
        return "Не удалось получить пользователя";
    
    return new User($user["id"], $user["name"], fixPhone($user["phone"]), $user["email"], $user["password"]);
}

// обновить данные пользователя
function updateUser($user, $name, $email, $phone, $password) {
    // если какие-то значения не были введены, то переписать их уже существующими
    if ($name == "") $name = $user->name;
    if ($email == "") $email = $user->email;
    if ($phone == "") 
        $phone = $user->phone;
    else
        truncatePhone($phone);
    if ($password == "") 
        $password = $user->password;
    else
        $password = password_hash($password, PASSWORD_DEFAULT);

    // обратиться к БД для обновления данных
    $connection = connect();
    return editUser($connection, $user->id, $name, $phone, $email, $password);
}

// проверка, вошел ли пользователь в аккаунт
function checkLogin() {
    $id = getValueFromSession("user_id");
    if ($id == "")
        return false;
    else
        return $id;
}

// возврат на главную страницу
function redirectToMainPage() {
    storeValueToSession("message", "Войдите в аккаунт");
    header("Location: " . "../index.php");
    die();
}

// добавить +7 к номеру телефона
function fixPhone($phone) {
    return "+7" . $phone;
}
?>