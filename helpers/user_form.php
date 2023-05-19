<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";

/* Скрипты, связанные с формами и их полями на страницах
регистрации и редактирования профиля */

// проверить корректность поля имени пользователя
function checkName(&$name_value, &$name_error, $validation_function, $unique_function) {
    if (!empty($_POST["name"])) 
        validate_field("name", $name_value, $name_error, $validation_function, true, $unique_function);
    else
        $name_error = "Введите имя";
}

// проверить корректность поля телефона
function checkPhone(&$phone_value, &$phone_error, $validation_function, $unique_function) {
    if (!empty($_POST["phone"]))
        validate_field("phone", $phone_value, $phone_error, $validation_function, true, $unique_function);
    else
        $phone_error = "Введите номер телефона";
}

// проверить корректность адреса почты
function checkEmail(&$email_value, &$email_error, $validation_function, $unique_function) {
    if (!empty($_POST["email"])) 
        validate_field("email", $email_value, $email_error, $validation_function, true, $unique_function);
    else 
        $email_error = "Введите адрес почты";
}

// проверить корректность введенного пароля
function checkPassword(&$password_value, &$password_error, $validation_function) {
    if (!empty($_POST["password"])) 
        validate_field("password", $password_value, $password_error, $validation_function, false);
    else
        $password_error = "Введите пароль";
}

// проверка подтверждения пароля
function checkPasswordConfirmation(&$password_conf_error, $validation_function) {
    if ((empty($_POST["password_confirmation"])) && (!empty($_POST["password"]))) 
        $password_conf_error = "Повторите пароль";
    else {
        $password = htmlspecialchars($_POST["password"]);
        $password_confirmation = htmlspecialchars($_POST["password_confirmation"]);
        // проверить совпадение паролей
        if (!empty($_POST["password"])) {
            $val_result = $validation_function($password, $password_confirmation);
            if ($val_result != "ok")
                $password_conf_error = $val_result;
        }
    }
}

// проверка значения поля редактирования профиля
function checkEditField($user, $type, &$value, &$value_error, $validation_function) {
    if (empty($_POST[$type]))
        // если пустое значение, то оно останется как есть    
        $value = "";
    else {
        // проверить поле на ошибки
        validate_field($type, $value, $value_error, $validation_function, false);
            // если нет ошибок, то проверить дублирование имени с другим пользователем
            if ($value_error == "")
                if ($user->isTheSameUser($type, $value))
                    $value_error = "Имя уже используется";
            // отобразить в сообщении об ошибке введенное значение
            if ($value_error != "")
                $value_error = $value_error . " (" . $value . ")";
    }
}

// проверка пароля при редактировании профиля
function checkEditPassword(&$password, &$password_error, $validation_function) {
    if (empty($_POST["password"]))
        // если пустое значение, то пароль останется прежним
        $password = "";
    else
        validate_field("password", $password, $password_error, $validation_function, false);
}
?>