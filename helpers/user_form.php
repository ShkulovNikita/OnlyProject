<?php
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/validator.php";
/* Скрипты, связанные с формами и их полями на страницах
регистрации и редактирования профиля */

// вывести форму регистрации или профиля в зависимости от указанного типа
function createForm($type, $name, $phone, $email, $name_error, $phone_error, $email_error, $password_error, $password_conf_error) {
    // заголовок формы со скриптом-обработчиком
    if ($type == "signup") 
        echo '<form action="formhandlers/registration.php" method="POST">' . "\n";
    elseif ($type == "profile")
        echo '<form action="formhandlers/edit_profile.php" method="POST">' . "\n";
    
    // поле для имени пользователя
    echo '<p>Имя: <input type="text" name="name" value="' . $name . '" /><span class="error">* ' . $name_error . '</p>' . "\n";
    
    // поле для телефона
    echo '<p>Телефон: <input type="tel" placeholder="+7XXXXXXXXXX" name="phone" value="' . $phone . '" /><span class="error">* ' . $phone_error . '</p>' . "\n";
    
    // почта
    echo '<p>Почта: <input type="email" placeholder="user@yandex.ru" name="email" value="' . $email . '" /><span class="error">* ' . $email_error . "</p>" . "\n";
    
    // пароль и подтверждение пароля
    echo '<p>Пароль: <input type="password" name="password" /><span class="error">* ' . $password_error . '</p>' . "\n";
    echo '<p>Подтвердите пароль: <input type="password" name="password_confirmation" /><span class="error">* ' . $password_conf_error . '</p>' . "\n";
    
    // кнопка для отправки формы
    if ($type == "signup")
        echo '<input type="submit" value="Зарегистрироваться">' . "\n";
    elseif ($type == "profile")
        echo '<input type="submit" value="Сохранить изменения">' . "\n";
    
    echo '</form>' . "\n";
}

// проверить корректность поля имени пользователя
function checkName(&$name_value, &$name_error) {
    if (!empty($_POST["name"])) 
        validate_field("name", $name_value, $name_error, $validate_name, true, $validate_name_unique);
    else
        $field_error = "Введите имя";
}

// проверить корректность поля телефона
function checkPhone(&$phone_value, &$phone_error) {
    if (!empty($_POST["phone"]))
        validate_field("phone", $phone_value, $phone_error, $validate_phone, true, $validate_phone_unique);
    else
        $phone_error = "Введите номер телефона";
}

// проверить корректность адреса почты
function checkEmail(&$email_value, &$email_error) {
    if (!empty($_POST["email"])) 
        validate_field("email", $email, $email_error, $validate_email, true, $validate_email_unique);
    else 
        $email_error = "Введите адрес почты";
}

// проверить корректность введенного пароля
function checkPassword(&$password_value, &$password_error) {
    if (!empty($_POST["password"])) 
        validate_field("password", &$password_value, $password_error, $validate_password, false);
    else
        $password_error = "Введите пароль";
}

// проверка подтверждения пароля
function checkPasswordConfirmation(&$password_conf_error) {
    if (empty($_POST["password_confirmation"])) 
        $password_conf_error = "Повторите пароль";
    else {
        $password_confirmation = htmlspecialchars($_POST["password_confirmation"]);
        // проверить совпадение паролей
        if (!empty($_POST["password"])) {
            $val_result = $validate_password_conf($password, $password_confirmation);
            if ($val_result != "ok")
                $password_conf_error = $val_result;
        }
    }
}
?>