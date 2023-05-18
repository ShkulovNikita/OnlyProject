<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/session.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/db_connector.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/user_helper.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/user_form.php";

/* Скрипты, связанные с редактированием профиля пользователя */

// переменные для полей формы 
$name = $phone = $email = $password = $password_confirmation = "";
// переменные с ошибками
$name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

// получить текущего пользователя
$id = checkLogin();
if ($id == false)
    redirectToMainPage();
$user = getUserData($id);

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
    redirectToProfile();
}

// выполнить обновление данных профиля
$update_result = updateUser($user, $name, $email, $phone, $password);
if ($update_result == false)
    storeValueToSession("message", "Не удалось обновить профиль");
else
    storeValueToSession("message", "Профиль успешно обновлен");

redirectToProfile();

// возврат на страницу профиля
function redirectToProfile() {
    header("Location: " . "../profile.php");
    die();
}

?>