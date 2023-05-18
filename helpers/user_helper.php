<?php
include_once "$_SERVER[DOCUMENT_ROOT]/classes/user.php";
include_once "db_connector.php";
include_once "session.php";

// получить данные о пользователе и вернуть в виде объекта
function getUserData($id) {
    // обратиться к БД
    $connection = connect();

    // получить пользователя
    $user = getUserById($connection, $id);

    if (!isset($user["id"]))
        return "Не удалось получить пользователя";
    
    return new User($user["name"], fixPhone($user["phone"]), $user["email"]);
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
}

// добавить +7 к номеру телефона
function fixPhone($phone) {
    return "+7" . $phone;
}
?>