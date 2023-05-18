<?php 
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/session.php";
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/db_connector.php";

/* Скрипты для обработки формы авторизации */

// переменные, соответствующие полям формы
$login = $password = "";
// переменные с ошибками
$login_error = $email_message = $phone_message = $password_error = "";
// тип введенного логина: телефон или почта
$login_type = "";

// проверка поля логина на пустоту и валидация
if (empty($_POST["login"]))
    $login_error = "Введите телефон или адрес почты";
else {
    $login = htmlspecialchars($_POST["login"]);
    
    // проверка, является ли введенный логин телефоном или почтой
    validate($validate_phone, $login, $phone_message);
    validate($validate_email, $login, $email_message);
    // не прошло валидацию ни на номер телефона, ни на адрес почты
    if (($phone_message != "") && ($email_message != ""))
        $login_error = "Неверный формат логина";
    // был введен номер телефона
    elseif ($phone_message == "") {
        validate($validate_phone_unique, $login, $phone_message);
        // совпадение найдено
        if ($phone_message == "Телефон уже используется")
            $login_type = "phone";
        // не найдено
        else
            $login_error = "Данного пользователя не существует";
    }
    // был введен адрес почты
    elseif ($email_message == "") {
        validate($validate_email_unique, $login, $email_message);
        if ($email_message == "Адрес почты уже используется")
            $login_type = "email";
        else
            $login_error = "Данного пользователя не существует";
    }
}

// проверка пароля
if (empty($_POST["password"])) 
    $password_error = "Введите пароль";
else {
    $password = htmlspecialchars($_POST["password"]);
    validate($validate_password, $password, $password_error);
}

// если была найдена какая-либо ошибка, то вернуться к форме для исправления
if (($login_type == "") || ($login_error != "") || ($password_error != "")) {
    returnToLogin($login, $login_error, $password_error);
}
    
// если был успешно определен тип логина и введен корректный пароль,
// то попытка залогиниться
$user = tryLogin($login, $login_type, $password);

if (is_null($user)) {
    $login_error = "Не удалось получить пользователя";
    returnToLogin($login, $login_error, $password_error);
}
elseif (($user == "Пользователь не найден") || ($user == "Введен неверный пароль")) {
    $password_error = $user;
    returnToLogin($login, $login_error, $password_error);
}
else {
    // вход успешно выполнен, сохранить ID текущего пользователя в сессию
    storeValueToSession("user_id", $user["id"]);
    header("Location: " . "../profile.php");
    die();
}

// авторизация пользователя
function tryLogin ($login, $login_type, $password) {
    // оставить последние 10 цифр номера телефона, если вход по телефону
    if ($login_type == "phone")
        truncatePhone($login);

    // установить соединение с БД
    $connection = connect();

    // получить пользователя
    $user = getUser($connection, $login_type, $login);

    // если ошибка, то вернуть результат как есть
    if ((is_null($user)) || ($user == "Пользователь не найден"))
        return $user;

    // иначе проверить пароль
    $result = password_verify($password, $user["password"]);
    if ($result == true)
        return $user;
    else
        return "Введен неверный пароль";
}

// возвращение к форме авторизации
function returnToLogin($login, $login_error, $password_error) {
    // записать сообщения и введенный логин в массив
    $values_to_store = compact("login", "login_error", "password_error");
    // сохранить в сессию
    saveValuesToSession($values_to_store);
    // редирект обратно на страницу авторизации
    header("Location: " . "../signin.php");
    die();
}
?>