<?php
include_once "classes/user.php";
include_once "helpers/user_helper.php";
/* Скрипты, отвечающие за перенаправление пользователя при необходимости */

// проверка, может ли пользователь обратиться к желаемой странице
function routeUser($destination) {
    // проверка, вошел ли пользователь в систему
    $loggedIn = User::isLoggedIn();
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
    }
}

// если пользователь залогинен, то перенаправление в профиль
function routeIndex($loggedIn) {
    if($loggedIn)     
        redirectToProfile();   
}

// если пользователь залогинен, то разлогинить его
function routeSignUp($loggedIn) {
    if ($loggedIn)
        logout();
}

// аналогично routeIndex
function routeSignIn($loggedIn) {
    if($loggedIn)     
        redirectToProfile();  
}

// если не залогинен, то перенаправить на главную страницу
function routeProfile($loggedIn) {
    if($loggedIn == false)
        redirectToMainPage();
}

function redirectToProfile() {
    header("Location: " . "../profile.php");
    die();
}

?>