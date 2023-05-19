<?php
include_once "helpers/session.php";
/* Скрипты для вывода повторяющихся HTML-элементов страниц */

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

function createHeader() {
    echo "<header><p>Тестовое задание для стажировки в Only</p></header>";
}

function createFooter() {
    echo "<hr>";
    echo "<footer><p>Шкулов Никита - 2023</p></footer>";
}

// показать информационное сообщение, если есть
function showMessage() {
    $message = getValueFromSession("message");
    if ($message != "") {
        echo '<div id="message">' . "\n";
        echo '<p>' . $message . '</p>' . "\n";
        echo '</div>' . "\n";
        unset($_SESSION["message"]);
    }
}

?>