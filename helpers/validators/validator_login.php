<?php 
/* Валидация логина (авторизация) */

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
?>