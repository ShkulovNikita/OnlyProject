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
        echo "Ошибка подключения: " . $ex->getMessage();
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
        echo "Ошибка создания БД: " . $ex->getMessage();
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
        echo "Ошибка создания таблицы: " . $ex->getMessage();
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
        echo "Ошибка добавления пользователя: " . $ex->getMessage();
    }
}

// получение пользователя по ID
function getUserById($connection, $id) {
    try {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id);

        $statement->execute();

        if ($statement->rowCount() > 0)
            foreach ($statement as $row) 
                return ($row);
        else
            echo "Пользователь не найден";
    }
    catch (PDOException $ex) {
        echo "Ошибка получения пользователя: " . $ex->getMessage();
    }
}

// получение пользователя по телефону или почте
function getUser($connection, $login, $type) {
    try {
        // построить запрос в зависимости от введенного логина
        $sql;
        if (($type == "phone") || ($type == "email"))   
            $sql = "SELECT * FROM users WHERE $type = :login";
        else
            return null;

        $statement = $connection->prepare($sql);
        $statement->bindValue(":login", $login);
        $statement->execute();

        // если найден некоторый пользователь, то вернуть его
        if ($statement->rowCount() > 0)
            foreach ($statement as $row) 
                return ($row);
        else
            echo "Пользователь не найден";
    }
    catch (PDOException $ex) {
        echo "Ошибка получения пользователя: " . $ex->getMessage();
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
    }
}

// проверить существование пользователя с таким же именем
function nameExists($connection, $name) {
    try {
        $sql = "SELECT * FROM users WHERE name = :name";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":name", $name);
        $statement->execute();

        return sameExists($statement);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения данных: " . $ex->getMessage();
    }
}

// проверить существование пользователя с таким же телефоном
function phoneExists($connection, $phone) {
    try {
        $sql = "SELECT * FROM users WHERE phone = :phone";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":phone", $phone);
        $statement->execute();

        return sameExists($statement);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения данных: " . $ex->getMessage();
    }
}

// проверить существование пользователя с такой же почтой
function emailExists($connection, $email) {
    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindValue(":email", $email);
        $statement->execute();

        return sameExists($statement);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения данных: " . $ex->getMessage();
    }
}

// проверка, были ли получены какие-либо строки по запросу
function sameExists($sql_result) {
    if ($sql_result->rowCount() > 0)
        return true;
    return false;
}
?>