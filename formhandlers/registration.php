<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/session.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/db_connector.php";
/* Скрипты для обработки формы регистрации */
    
// переменные, соответствующие полям формы
$name = $phone = $email = $password = $password_confirmation = "";
// переменные с ошибками
$name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

// проверки полей на пустоту, валидация, проверка на уникальность

// имя пользователя
if (!empty($_POST["name"])) {
    $name = htmlspecialchars($_POST["name"]);
    // валидация
    validate($validate_name, $name, $name_error);
    // проверка уникальности
    if ($name_error == "")
        validate($validate_name_unique, $name, $name_error);
}
else
    $name_error = "Введите имя";

// номер телефона
if (!empty($_POST["phone"])) {
    $phone = htmlspecialchars($_POST["phone"]);
    validate($validate_phone, $phone, $phone_error);
    if ($phone_error == "") 
        validate($validate_phone_unique, $phone, $phone_error);
}
else
    $phone_error = "Введите номер телефона";

// адрес почты
if (!empty($_POST["email"])) {
    $email = htmlspecialchars($_POST["email"]);
    validate($validate_email, $email, $email_error);
    if ($email_error == "")
        validate($validate_email_unique, $email, $email_error);
}
else 
    $email_error = "Введите адрес почты";

// пароль
if (!empty($_POST["password"])) {
    $password = htmlspecialchars($_POST["password"]);
    validate($validate_password, $password, $password_error);
}
else
    $password_error = "Введите пароль";

// подтверждение пароля
if (!empty($_POST["password_confirmation"])) 
{
    $password_confirmation = htmlspecialchars($_POST["password_confirmation"]);
    // проверить совпадение паролей
    if (!empty($_POST["password"])) {
        $val_result = $validate_password_conf($password, $password_confirmation);
        if ($val_result != "ok")
            $password_conf_error = $val_result;
    }
}
else
    $password_conf_error = "Повторите пароль";

// проверить, что все ошибки пустые (поля заполнены корректно)
if (($name_error == "") && ($phone_error == "") && ($email_error == "") 
&& ($password_error == "") && ($password_conf_error == "")) {
    // создать нового пользователя
    signUp($name, $phone, $email, $password);

    // сохранить факт успешно произведенной регистрации в сессиию
    storeValueToSession("message", "Вы успешно зарегистрировались!");

    // редирект на главную страницу после успешной регистрации
    header("Location: " . "../index.php");
    die();
}
else {
    /* сохранить введенные значения и ошибки в сессию, 
    чтобы показать их пользователю */

    // упаковать переменные в массив
    $values_to_store = compact("name", "phone", "email", "name_error", "phone_error", "email_error", "password_error", "password_conf_error");
    // записать в сессию
    saveValuesToSession($values_to_store);

    // редирект обратно на страницу регистрации
    header("Location: " . "../signup.php");
    die();
}

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