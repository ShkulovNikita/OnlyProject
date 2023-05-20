<?php
include_once "classes/user.php";
include_once "helpers/session.php";
/* Скрипты, отвечающие за перенаправление пользователя при необходимости */

// проверка, может ли пользователь обратиться к желаемой странице
function routeUser($destination, $message = "") {
    // проверка, вошел ли пользователь в систему
    $loggedIn = User::isLoggedIn();
    // сохранить сообщение, если такое есть
    if ($message != "")
        storeValueToSession("message", $message);
    // в зависимости от результата определить его маршрут
    switch($destination) {
        case "index":
            routeIndex($loggedIn);
            break;
        case "signup":
            routeSignUp($loggedIn);
            break;
        case "signin":
            routeSignIn($loggedIn);
            break;
        case "profile":
            routeProfile($loggedIn);
            break;
        case "logout":
            logout($message);
            break;
    }
}

// если пользователь залогинен, то перенаправление в профиль
function routeIndex($loggedIn) {
    if($loggedIn)     
        routeToProfile();   
}

// если пользователь залогинен, то разлогинить его
function routeSignUp($loggedIn) {
    if ($loggedIn)
        logout();
}

// аналогично routeIndex
function routeSignIn($loggedIn) {
    if($loggedIn)     
        routeToProfile();  
}

// если не залогинен, то перенаправить на главную страницу
function routeProfile($loggedIn) {
    if($loggedIn == false)
        routeIndex();
}

function routeToProfile() {
    header("Location: " . "../profile.php");
    die();
}

function logout() {
    header("Location: " . "../index.php");
    session_destroy();
    storeValueToSession("message", "Вы вышли из профиля");
    die();
}

?>