<?php 
/* Валидация пароля */

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

// проверка пароля при редактировании профиля
function checkEditPassword(&$password, &$password_error, $validation_function) {
    if (empty($_POST["password"]))
        // если пустое значение, то пароль останется прежним
        $password = "";
    else
        validate_field("password", $password, $password_error, $validation_function, false);
}

// функция проверки пароля
$validate_password = function ($password) {
    // количество символов в пароле
    if (strlen($password) < 6) 
        return "Пароль должен состоять минимум из 6 символов"; 
    return "ok";
};

// функция для проверки идентичности введенных паролей
$validate_password_conf = function ($password, $password_confirm) {
    // совпадение паролей
    if ($password != $password_confirm) 
        return "Пароли не совпадают";
    return "ok";
};
?>