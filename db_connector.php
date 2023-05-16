<?php

/* Скрипты, отвечающие за работу с базой данных */

// название БД
const DATABASE = "onlydb";
// логин пользователя
const DB_USER = "onlydbuser";
// пароль
const DB_PASSWORD = "Imn6&4$%yGbU";

// соединение с сервером
function connect() {
    try {
        // подключение через созданного пользователя
        $connection = new PDO("mysql:host=localhost", DB_USER, DB_PASSWORD);
        echo "Соединение установлено <br>";
        // создание БД, если её нет
        createDatabase($connection);
        // новое соединение, теперь к конкретной БД
        $connection = new PDO("mysql:host=localhost;dbname=" . DATABASE, DB_USER, DB_PASSWORD);
        // создание таблицы с пользователями, если её нет
        createUsersTable($connection);
    }
    catch (PDOException $ex) {
        echo "Ошибка подключения: " . $ex->getMessage();
    }
}

// создание БД
function createDatabase($connection) {
    try {
        // SQL-запрос для создания БД
        $sql_db_creation = "CREATE DATABASE IF NOT EXISTS onlydb";
        // выполнение запроса
        $connection->exec($sql_db_creation);
        echo "Создана база данных <br>";
    }
    catch (PDOException $ex) {
        echo "Ошибка создания БД: " . $ex->getMessage();
    }
}

// создание таблицы с пользователями
function createUsersTable($connection) {
    try {
        // SQL-запрос для создания таблицы
        $sql_table_creation = "CREATE TABLE IF NOT EXISTS users (id INTEGER AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150) NOT NULL, phonenumber CHAR(11) NOT NULL UNIQUE, email VARCHAR(100) NOT NULL UNIQUE, password VARCHAR(100) NOT NULL);";
        // выполнение запроса
        $connection->exec($sql_table_creation);
        echo "Создана таблица с пользователями <br>";
    }
    catch (PDOException $ex) {
        echo "Ошибка создания таблицы: " . $ex->getMessage();
    }
}

?>