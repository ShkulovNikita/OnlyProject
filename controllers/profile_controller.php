<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/session.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/user_helper.php";
include_once "$_SERVER[DOCUMENT_ROOT]/classes/user.php";
include_once "$_SERVER[DOCUMENT_ROOT]/router.php";

/* Скрипты, связанные с редактированием профиля пользователя */

// действия при отправке формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // переменные для полей формы 
    $name = $phone = $email = $password = $password_confirmation = "";
    // переменные с ошибками
    $name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

    // получить текущего пользователя
    $id = User::isLoggedIn();
    if ($id == false)
        redirectToMainPage();

    $user = getUserData($id);
    // проверить ошибки получения пользователя из БД
    if (is_string($user))
        if (strpos($user, "Ошибка") !== false) {
            storeValueToSession("message", $user);
            routeUser("logout");
        }

    /* обработка введенных значений полей */
    checkEditField($user, "name", $name, $name_error, $validate_name);
    checkEditField($user, "phone", $phone, $phone_error, $validate_phone);
    checkEditField($user, "email", $email, $email_error, $validate_email);
    checkEditPassword($password, $password_error, $validate_password);
    checkPasswordConfirmation($password_conf_error, $validate_password_conf);

    // если есть ошибки, то вернуться в профиль
    if (($name_error != "") || ($phone_error != "") || ($email_error != "") 
        || ($password_error != "") || ($password_conf_error != "")) {
        saveValuesToSession(compact("name_error", "phone_error", "email_error", 
                                    "password_error", "password_conf_error"));
        routeUser("profileBack");
    }

    // выполнить обновление данных профиля
    $update_result = updateUser($user, $name, $email, $phone, $password);
    if ($update_result == false)
        storeValueToSession("message", "Не удалось обновить профиль");
    else
        storeValueToSession("message", "Профиль успешно обновлен");

    routeUser("profileBack");
}

// действия перед загрузкой страницы
function loadPage(&$name_error, &$phone_error, &$email_error, &$password_error, &$password_conf_error) {
    routeUser("profile");

    // идентификатор текущего пользователя
    $id = User::isLoggedIn();
    $user = getUserData($id);

    if ($user == "Не удалось получить пользователя")
        redirectToMainPage();

    // ошибки
    $name_error = getValueFromSession("name_error");
    $phone_error = getValueFromSession("phone_error");
    $email_error = getValueFromSession("email_error");
    $password_error = getValueFromSession("password_error");
    $password_conf_error = getValueFromSession("password_conf_error");

    // очистить ошибки в сессии
    removeValuesFromSession(compact("name_error", "phone_error", "email_error", "password_error", "password_conf_error"));

    return $user;
}

?>