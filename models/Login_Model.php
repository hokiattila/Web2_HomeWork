<?php

namespace models;
use Database;
use PDO;

class Login_Model {
    public function fetchUserData($username) : array {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users WHERE username = :username ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}