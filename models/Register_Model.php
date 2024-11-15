<?php

namespace models;
use Database;
use PDO;

class Register_Model {
    public function insertUserData($username, $hashed_psw, $email, $lastname, $firstname, $szuldatum, $nem, $telefonszam) : void {
        $conn = Database::getConnection();
        $stmt  = $conn->prepare("INSERT INTO users VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$username, $hashed_psw,"_1_", $firstname,$lastname, $szuldatum, $nem, date('Y-m-d'), $telefonszam, $email]);
    }

}