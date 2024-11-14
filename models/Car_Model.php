<?php

namespace models;
use Database;
use DateTime;
use PDO;
class Car_Model {
    public function fetchCarData($offset, $limit) : array {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM cars LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getCarRowCount() : int {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM cars");
        $rowCount = $stmt->fetchColumn();
        return (int) $rowCount;
    }

    public function fetchBrandNames() : array|bool {
        $pdo = Database::getConnection();
        $sql = "SELECT DISTINCT brand FROM cars";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkVIN(string $vin) : bool {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM cars WHERE vin=:vin";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() == 0) return false;
        return true;
    }

    public function fetchIndividualCar($vin) : array|bool {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM cars WHERE vin = :vin";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function insertFavorite($user, $vin) : void {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO favorites(username, car_VIN, fav_date) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user, $vin, date('Y-m-d')]);
    }

    public function fetchFavoritesByUser($username): array|bool {
        $pdo = Database::getConnection();
        $sql = "SELECT car_VIN FROM favorites WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeFavoriteRecord($username, $vin) : void{
        $pdo = Database::getConnection();
        $sql = "DELETE FROM favorites WHERE username=:username and car_VIN=:vin";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function fetchFavoriteCarData($username) : array|bool {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM cars INNER JOIN favorites ON car_VIN = VIN WHERE username=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertCar($vin, $brand, $modell, $build_year, $door_count, $color, $weight, $power, $con, $fuel_type, $price) : void {
        $pdo = Database::getConnection();
        $date = new DateTime($build_year);
        $year = $date->format('Y');
        $yearInt = (int)$year;
        $sql = "INSERT INTO cars(brand, modell, build_year, door_count, color, weight, power, con, fuel_type, price, VIN) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$brand, $modell, $yearInt, $door_count, $color, $weight, $power, $con, $fuel_type, $price, $vin]);
    }

    public function deleteCar($vin) : void {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM cars WHERE VIN = :vin";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':vin', $vin, PDO::PARAM_STR);
        $stmt->execute();
    }

}