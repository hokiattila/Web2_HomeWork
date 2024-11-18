<?php

namespace models;

use Database;
use PDO;

class Question_Model
{
    private PDO $db;

    public function __construct()
    {
        // Adatbáziskapcsolat inicializálása a Database osztály segítségével
        $this->db = Database::getConnection();
    }

    public function saveQuestion(string $name, string $email, ?string $phone, string $message): void
    {
        $sql = "INSERT INTO questions (name, email, phone, message, created_at) 
                VALUES (:name, :email, :phone, :message, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':message' => $message,
        ]);
    }

    public function fetchAllQuestions(): array
    {
        $sql = "SELECT * FROM questions ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
