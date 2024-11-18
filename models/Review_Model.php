<?php
namespace models;

use PDO;
use Database;

class Review_Model {
    // Értékelés hozzáadása
    public function addReview($stars, $title, $name, $message) {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO reviews (stars, title, name, message) VALUES (:stars, :title, :name, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':stars', $stars, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Válasz hozzáadása
    public function addResponse($review_id, $name, $message) {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO reviews_responses (review_id, name, message) VALUES (:review_id, :name, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Értékelések lekérése
    public function getReviews() {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getResponses() {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM `reviews_responses` ORDER BY created_at ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Válaszok lekérése

}
