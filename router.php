<?php
include_once "classes/user.php";
include_once "helpers/session.php";
/* Скрипты, отвечающие за перенаправление пользователя при необходимости */

// проверка, может ли пользователь обратиться к желаемой странице
function routeUser($destination, $message = "") {
    // проверка, вошел ли пользователь в систему
    $loggedIn = User::isLoggedIn();
    if ($loggedIn != false)
        $loggedIn = true;
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
            logout();
            break;
        case "signupIndex":
            routeToIndex();
            break;
        default:
            routeBack($loggedIn, $destination);
            break;
    }
}

// если пользователь залогинен, то перенаправление в профиль
function routeIndex($loggedIn) {
    if($loggedIn)     
        routeToProfile(); 
}

function routeToIndex() {
    header("Location: " . "../index.php");
    die();
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
    {
        storeValueToSession("message", "Войдите в аккаунт");
        routeToIndex();
    }
}

function routeToProfile() {
    header("Location: " . "../profile.php");
    die();
}

function logout() {
    sessionClear();
    storeValueToSession("message", "Вы вышли из профиля");
    header("Location: " . "../index.php");
    die();
}

// перенаправление обратно на страницу с формой 
// при её неправильном заполнении
function routeBack($loggedIn, $destination) {
    switch($destination) {
        case "profileBack":
            routeToProfile();
            break;
        case "signinBack":
            header("Location: " . "../signin.php");
            die();
            break;
        case "signupBack":
            header("Location: " . "../signup.php");
            die();
            break;
        default:
            routeIndex($loggedIn);
            die();
            break;
    }
}
?>