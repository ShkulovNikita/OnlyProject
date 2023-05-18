<?php
/* Функционал, связанный с сессиями */

// запись набора переменных в виде массива в сессию
function saveValuesToSession($values) {
    try {
        if(!isset($_SESSION)) 
            session_start(); 
        foreach($values as $key => $value)
            $_SESSION[$key] = $value;
    }
    catch (Exception $ex) {
        echo "Ошибка сессии: " . $ex->getMessage();
    }
}

// сохранить значение в сессию по ключу
function storeValueToSession($key, $value) {
    if(!isset($_SESSION)) 
        session_start(); 
    $_SESSION[$key] = $value;
}

// получить значение из сессии по ключу
function getValueFromSession($key) {
    if(!isset($_SESSION)) 
        session_start(); 

    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return "";
}

?>