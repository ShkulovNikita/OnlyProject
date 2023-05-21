<?php 
/* Валидация имени пользователя */

// проверить корректность поля имени пользователя
function checkName(&$name_value, &$name_error, $validation_function, $unique_function) {
    if (!empty($_POST["name"])) 
        validate_field("name", $name_value, $name_error, $validation_function, true, $unique_function);
    else
        $name_error = "Введите имя";
}

// функция для валидации имени
$validate_name = function ($name) {
    // имя должно содержать только буквы, пробелы и дефисы
    //if (!preg_match("/^(([a-zA-Z-' ])|([а-яА-ЯЁё])|([0-9]))*$/", $name)) 
    if (!preg_match("/^(([a-zA-Z-' ])|([0-9]))*$/", $name)) 
        return "Некорректные символы в имени";
    // проверка количества символов
    if (strlen($name) > 150) 
        return "Слишком длинное имя";
    if (strlen($name) < 4) 
        return "Слишком короткое имя";
    return "ok";
};

// функция для проверки уникальности имени
$validate_name_unique = function($name) {
    $connection = connect();
    if (is_string($connection))
        return $connection;

    if (sameUserExists($connection, "name", $name))
        return "Имя уже используется";
    return "ok";
}; 
?>