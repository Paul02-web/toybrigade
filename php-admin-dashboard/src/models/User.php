<?php

class User {
    private $id;
    private $name;
    private $email;
    private $status;

    public function __construct($id, $name, $email, $status) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public static function fetchAllUsers($dbConnection) {
        // Logic to fetch all users from the database
    }

    public static function updateUser($dbConnection, $id, $name, $email, $status) {
        // Logic to update user information in the database
    }

    public static function deleteUser($dbConnection, $id) {
        // Logic to delete a user from the database
    }
}