<?php 
class User {
    public $name, $phone, $email;

    function __construct($name, $phone, $email) {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
    }
}
?>