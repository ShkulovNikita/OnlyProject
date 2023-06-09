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

// удалить набор значений из сессии
function removeValuesFromSession($values) {
    try {
        if(!isset($_SESSION)) 
            session_start(); 
        foreach($values as $key => $value)
            unset($_SESSION[$key]);
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

    if(isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return "";
}

// очистить сессию 
function sessionClear() {
    foreach ($_SESSION as $key=>$val) 
        if ($key != "message") 
            unset($_SESSION[$key]);
}

?>