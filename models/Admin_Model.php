<?php

namespace models;

use PDO;
use Database;

class Admin_Model {
    public function fetchAllUsers(): array {
        $pdo = Database::getConnection();
        $sql = "SELECT username, first_name, last_name, birth_date, gender, join_date, email FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
