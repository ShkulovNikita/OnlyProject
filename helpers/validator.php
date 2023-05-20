<?php
include_once "db_connector.php";
include_once "session.php";

include_once "validators/validator_name.php";
include_once "validators/validator_phone.php";
include_once "validators/validator_email.php";
include_once "validators/validator_password.php";
include_once "validators/validator_login.php";

/* Общие функции валидации */

// провести валидацию значения одного поля
// $field_name - имя поля ввода
// $field_value - введенное пользователем значение
// $validate_function - соответствующая функция валидации
// $isUnique - требуется ли проверка поля на уникальность значения
// $unique_val_function - соответствующая функция проверки уникальности
function validate_field($field_name, &$field_value, &$field_error, 
                        $validate_function, $isUnique, $unique_val_function = null) {
    $field_value = htmlspecialchars($_POST[$field_name]);

    // валидация
    validate($validate_function, $field_value, $field_error);

    // если нужна проверка на уникальность
    if (($isUnique) && ($field_error == ""))
        validate($unique_val_function, $field_value, $field_error);
}

// валидация значения (value) выбранной функцией (validation_function)
// с записью ошибки (если есть) в error
function validate($validation_function, $value, &$error) {
    $validation_result = $validation_function($value);
    if ($validation_result != "ok") 
        $error = $validation_result;
}
?>