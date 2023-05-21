<?php
include_once "session.php";
/* Скрипты для вывода повторяющихся HTML-элементов страниц */

// вывести форму регистрации или профиля в зависимости от указанного типа
function createForm($type, $name, $phone, $email, $name_error, $phone_error, $email_error, $password_error, $password_conf_error) {
    // заголовок формы со скриптом-обработчиком
    if ($type == "signup") 
        echo '<form action="controllers/signup_controller.php" method="POST">' . "\n";
    elseif ($type == "profile")
        echo '<form action="controllers/profile_controller.php" method="POST">' . "\n";
    
    // поля формы
    createField("Имя", "text", "name", $name, $name_error);
    createField("Телефон", "tel", "phone", $phone, $phone_error, "+7XXXXXXXXXX");
    createField("Почта", "email", "email", $email, $email_error, "user@yandex.ru");
    if ($type == "profile")
        createField("Пароль (изменить)", "password", "password", null, $password_error);
    else
        createField("Пароль", "password", "password", null, $password_error);
    createField("Подтвердите пароль", "password", "password_confirmation", null, $password_conf_error);
    
    // кнопка для отправки формы
    if ($type == "signup")
        echo '<input class="button" type="submit" value="Зарегистрироваться">' . "\n";
    elseif ($type == "profile")
        echo '<input class="button" type="submit" value="Сохранить изменения">' . "\n";
    
    echo '</form>' . "\n";
}

// вывод одного поля формы
function createField($text, $input_type, $name, $value, $error, $placeholder = null) {
    echo '<div class="flex-container">' . "\n" . '<div class="left-side">' . "\n";
    echo "<p>" . $text . ":</p>" . "\n";
    echo '</div>' . "\n" . '<div class="right-side">' . "\n";
    echo '<input type="' . $input_type . '" ';
    if (!is_null($placeholder))
        echo 'placeholder="' . $placeholder . '" ';
    echo 'name="' . $name . '" ';
    if (!is_null($value))
        echo 'value="' . $value . '" '; 
    echo '/><span class="error">*</span>' . "\n";
    echo '</div>' . "\n" . "</div>" . "\n";
    echo '<div class="error-line">' . "\n";
    echo showError($error);
    echo '</div>' . "\n";
}

function createHeader() {
    echo '<a class="header-link" href="index.php"><header><p>Тестовое задание для стажировки в Only</p></header></a>';
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

// вывести ошибку для поля формы
function showError($error) {
    if ($error != "")
        echo '<p class="error">' . $error . '</p>' . "\n";
}

?>