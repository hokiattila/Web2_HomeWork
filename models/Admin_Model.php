<?php

namespace models;

use PDO;
use Database;

class Admin_Model {

    private $db;

    public function __construct()
    {
        // A kapcsolat létrehozása az adatbázissal
        $this->db = Database::getConnection();  // Database::getConnection() függvényt hívunk
    }

    public function fetchAllUsers(): array {
        $sql = "SELECT username, first_name, last_name, birth_date, gender, join_date, email FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMessage(int $messageId): void
    {
        // Üzenet törlésének SQL lekérdezése
        $query = "DELETE FROM questions WHERE id = :messageId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllMessages(): array
    {
        // Ha a dátum oszlop neve például "created_at", akkor itt módosítjuk
        $query = "SELECT id, name, email, message, created_at FROM questions ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Üzenetek visszaadása
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

