<?php 
include_once "$_SERVER[DOCUMENT_ROOT]/helpers/db_connector.php";

class User {
    public $id, $name, $phone, $email, $password;

    function __construct($id, $name, $phone, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    // проверка принадлежности уникального поля (телефона, логина, почты) данному или другому пользователю
    function isTheSameUser($type, $value) {
        // получить пользователя с такими же данными
        $connection = connect();
        $same_user = sameUserExists($connection, $type, $value);
    
        // такого пользователя нет, поле уникально
        if ($same_user == false)
            return false;
        // сравнить идентификаторы
        if (!isset($same_user["id"]))
            return false;
        else {
            if ($same_user["id"] == $this->id)
                return false;
            else
                return true;
        }
    }
}
?>