<?php
/* Функции, отвечающие за работу с базой данных */

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
        // создание БД, если её нет
        createDatabase($connection);
        // новое соединение, теперь к конкретной БД
        $connection = new PDO("mysql:host=localhost;dbname=" . DATABASE, DB_USER, DB_PASSWORD);
        // создание таблицы с пользователями, если её нет
        createUsersTable($connection);
        
        return $connection;
    }
    catch (PDOException $ex) {
        return "Ошибка подключения: " . $ex->getMessage();
    }
}

// создание БД
function createDatabase($connection) {
    try {
        $sql = "CREATE DATABASE IF NOT EXISTS onlydb";
        // выполнение запроса
        $connection->exec($sql);
    }
    catch (PDOException $ex) {
        return "Ошибка создания БД: " . $ex->getMessage();
    }
}

// создание таблицы с пользователями
function createUsersTable($connection) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS users (id INTEGER AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150) NOT NULL UNIQUE, phone CHAR(10) NOT NULL UNIQUE, email VARCHAR(100) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL);";
        // выполнение запроса
        $connection->exec($sql);
    }
    catch (PDOException $ex) {
        return "Ошибка создания таблицы: " . $ex->getMessage();
    }
}

// создание нового пользователя
function createUser($connection, $name, $phone, $email, $password) {
    try {
        $sql = "INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)";
        $statement = $connection->prepare($sql);

        // привязки параметров
        $statement->bindValue(":name", $name);
        $statement->bindValue(":phone", $phone);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);

        // вернуть число добавленных строк (1 или 0)
        return $statement->execute();
    }
    catch (PDOException $ex) {
        return "Ошибка добавления пользователя: " . $ex->getMessage();
    }
}

// получение пользователя по одному из уникальных значений (type - id, name, email, phone)
function getUser($connection, $type, $value) {
    try {
        $sql = "SELECT * FROM users WHERE $type = :login";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":login", $value);

        $statement->execute();

        if ($statement->rowCount() > 0)
            foreach ($statement as $row) 
                return ($row);
        else
            echo "Пользователь не найден";
    }
    catch (PDOException $ex) {
        return "Ошибка получения пользователя: " . $ex->getMessage();
    }
}

// редактирование данных пользователя
function editUser($connection, $id, $name, $phone, $email, $password) {
    try {
        // подготовка запроса
        $sql = "UPDATE users SET name = :name, phone = :phone, email = :email, password = :password WHERE id = :id";
        // привязка параметров
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":phone", $phone);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", $password);

        $statement->execute();

        return true;
    }
    catch (PDOException $ex) {
        echo "Ошибка редактирования пользователя: " . $ex->getMessage();
        return false;
    }
}

// проверить существование пользователя с таким же именем/телефоном/почтой
function sameUserExists($connection, $type, $value) {
    $user = getUser($connection, $type, $value);
    if (is_null($user))
        return false;
    else
        return $user;
}
?>