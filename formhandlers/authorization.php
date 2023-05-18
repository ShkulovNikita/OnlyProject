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

// проверка полей на пустоту и валидация
if (!empty($_POST["login"])) {
    $login = htmlspecialchars($_POST["login"]);
    // валидация
    
    // проверка, является ли введенный логин телефоном или почтой
    validate($validate_phone, $login, $phone_message);
    validate($validate_email, $login, $email_message);

    // если было получено сообщение, что телефон/почта уже используется,
    // то это означает корректный ввод логина
    if ($phone_message == "Телефон уже используется")
        $login_type = "phone";
    elseif ($email_message == "Адрес почты уже используется")
        $login_type = "email";
    else
        $login_error = "Неверный формат логина либо данный пользователь не существует";
}
else
    $login_error = "Введите телефон или адрес почты";

if (!empty($_POST["password"])) {
    $password = htmlspecialchars($_POST["password"]);
    validate($validate_password, $password, $password_error);
}
else
    $password_error = "Введите пароль";

// если был определен тип логина и введен корректный пароль,
// то попытка залогиниться
if (($login_type != "") && ($login_error == "") && ($password_error == "")) {
    $user = tryLogin($login, $login_type, $password);

    if (is_null($user)) {
        $login_error = "Не удалось получить пользователя";
        echo $login_error;
        returnToLogin($login, $login_error, $password_error);
    }
    elseif (($user == "Пользователь не найден") || ($user == "Введен неверный пароль")) {
        $password_error = $user;
        echo $login_error;
        returnToLogin($login, $login_error, $password_error);
    }
    else {
        // вход успешно выполнен, сохранить ID пользователя в сессию
        storeValueToSession("user_id", $user["id"]);
        header("Location: " . "../profile.php");
    }
}
else
    returnToLogin($login, $login_error, $password_error);

// авторизация пользователя
function tryLogin ($login, $login_type, $password) {
    // оставить последние 10 цифр номера телефона, если вход по телефону
    if ($login_type == "phone")
        truncatePhone($login);

    // установить соединение с БД
    $connection = connect();

    // получить пользователя
    $user = getUser($connection, $login, $login_type);

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
}


?>