<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/session.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/db_connector.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
include_once "$_SERVER[DOCUMENT_ROOT]/router.php";

/* Скрипты для обработки формы регистрации */
    
// обработка отправленной формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // переменные, соответствующие полям формы
    $name = $phone = $email = $password = $password_confirmation = "";
    // переменные с ошибками
    $name_error = $phone_error = $email_error = $password_error = $password_conf_error = "";

    // проверки полей на пустоту, валидация, проверка на уникальность

    // имя пользователя
    checkName($name, $name_error, $validate_name, $validate_name_unique);
    // номер телефона
    checkPhone($phone, $phone_error, $validate_phone, $validate_phone_unique);
    // адрес почты
    checkEmail($email, $email_error, $validate_email, $validate_email_unique);
    // пароль
    checkPassword($password, $password_error, $validate_password);
    // подтверждение пароля
    checkPasswordConfirmation($password_conf_error, $validate_password_conf);

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

// действия до загрузки страницы
function loadPage(&$name, &$phone, &$email, &$name_error, &$phone_error, 
                            &$email_error, &$password_error, &$password_conf_error) {
    // перенаправить пользователя, если требуется
    routeUser("signup");

    // задать значения полей, если они были введены ранее
    $name = getValueFromSession("name");
    $phone = getValueFromSession("phone");
    $email = getValueFromSession("email");

    // ошибки
    $name_error = getValueFromSession("name_error");
    $phone_error = getValueFromSession("phone_error");
    $email_error = getValueFromSession("email_error");
    $password_error = getValueFromSession("password_error");
    $password_conf_error = getValueFromSession("password_conf_error");     
    
    // удалить их из сессии
    removeValuesFromSession(compact("name", "phone", "email", "name_error", "phone_error", "email_error", "password_error", "password_conf_error"));
}
?>