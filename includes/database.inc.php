<?php
define('HOST', 'localhost');
define('DATABASE', 'ottakocsid');
define('USER', 'root');
define('PORT', '3306');
define('PASSWORD', '');
class Database {
    private static bool|PDO $connection = FALSE;
    public static function getConnection(bool $nodb = false): PDO {
        if (!self::$connection) {
            $dsn = 'mysql:host=' . HOST . ';port=' . PORT . ';charset=utf8';
            if (!$nodb) $dsn .= ';dbname=' . DATABASE;
            self::$connection = new PDO($dsn, USER, PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            self::$connection->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        }
        return self::$connection;
    }

    public static function dbInit(): void {
        try {
            $conn = self::getConnection(nodb:true);
            $stmt = $conn->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
            $stmt->execute([DATABASE]);
            if ($stmt->rowCount() == 0) {
                $conn->exec("CREATE DATABASE IF NOT EXISTS " . DATABASE);
                $conn->exec("USE " . DATABASE);
                $conn = self::getConnection();
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $tables = [
                    "CREATE TABLE IF NOT EXISTS users(
                username VARCHAR(50) PRIMARY KEY,
                hashed_psw VARCHAR(256) NOT NULL,
                permission varchar(3) NOT NULL default '_1_',                
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                birth_date DATE NOT NULL,
                gender ENUM('Férfi', 'Nő') NOT NULL,
                join_date DATE NOT NULL,
                phone_number VARCHAR(30) NOT NULL DEFAULT 'unknown',
                email VARCHAR(50) NOT NULL
            )",
                    "CREATE TABLE IF NOT EXISTS cars(
                id INT AUTO_INCREMENT PRIMARY KEY,
                brand VARCHAR(50) NOT NULL,
                modell VARCHAR(30) NOT NULL,
                build_year SMALLINT NOT NULL,
                door_count SMALLINT NOT NULL,
                color VARCHAR(12) NOT NULL,
                weight SMALLINT NULL,
                power SMALLINT NULL,
                con ENUM('Totálkár', 'Újszerű', 'Új', 'Viseltes') NOT NULL,
                fuel_type ENUM('Benzin', 'Diesel', 'Elektromos', 'Gázüzem', 'Hidrogén') NOT NULL,
                price INT NOT NULL, 
                VIN VARCHAR(50),
                UNIQUE(VIN)
            )",
                    "CREATE TABLE IF NOT EXISTS favorites(
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL, 
                car_VIN VARCHAR(50) NOT NULL,
                fav_date DATETIME NOT NULL,
                FOREIGN KEY(username) REFERENCES users(username) ON DELETE CASCADE,
                FOREIGN KEY(car_VIN) REFERENCES cars(VIN) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS reservations(
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                car_VIN VARCHAR(50) NOT NULL,
                start_time DATETIME NOT NULL, 
                end_time DATETIME NOT NULL,
                approved ENUM('igen', 'nem'),
                FOREIGN KEY(username) REFERENCES users(username) ON DELETE CASCADE,
                FOREIGN KEY(car_VIN) REFERENCES cars(VIN) ON DELETE CASCADE
            )",
                    "CREATE TABLE IF NOT EXISTS pages(
                url VARCHAR(15) NOT NULL PRIMARY KEY,
                page VARCHAR(15) NOT NULL,
                permission VARCHAR(4) NOT NULL,
                sortingorder TINYINT(4) NOT NULL
            )"
                ];

                foreach ($tables as $sql) {
                    $conn->exec($sql);
                }

                $stmt = $conn->prepare("INSERT INTO users VALUES (?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([
                    "admin", password_hash("admin", PASSWORD_DEFAULT), "__1",
                    "Admin", "Admin", date('Y-m-d'), "Férfi", date('Y-m-d'),
                    "2", "admin@carsales.com"
                ]);

                $stmt->execute([
                    "test", password_hash("test", PASSWORD_DEFAULT), "_1_",
                    "Teszt", "Felhasználó", date('Y-m-d'), "Férfi", date('Y-m-d'),
                    "1", "test@carsales.com"
                ]);


                $stmt = $conn->prepare("INSERT INTO cars(brand, modell, build_year, door_count, color, weight, power, con, fuel_type, price, VIN) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute(["Peugeot", "206", date('Y-m-d', strtotime('2004-05-22')), 5, "fehér", 1, 110, "Újszerű", "Benzin", 400000, "SADJN3331JNCDS"]);
                $stmt->execute(["BMW", "M3", date('Y-m-d', strtotime('2011-05-22')), 5, "fekete", 2, 220, "Viseltes", "Diesel", 1200000, "ASDFASD23232323"]);
                $stmt->execute(["Mercedes-Benz", "CLA", date('Y-m-d', strtotime('2017-02-12')), 5, "fekete", 3, 180, "Új", "Benzin", 13000000, "FKNGMDFJKGNDJF232"]);
                $stmt->execute(["Audi", "R8", date('Y-m-d', strtotime('2002-05-22')), 5, "szürke", 1, 110, "Totálkár", "Benzin", 120000, "SDGFDFSGSFDG33"]);
                $stmt->execute(["Mazda", "RX7", date('Y-m-d', strtotime('1992-05-22')), 5, "fehér", 1, 110, "Újszerű", "Benzin", 500000, "SGFSDGDFSG"]);

                $stmt = $conn->prepare("INSERT INTO pages(url, page, permission, sortingorder) VALUES (?,?,?,?)");
                $stmt->execute(["home","Főoldal", "111", 10]);
                $stmt->execute(["favorites", "Kedvencek", "010", 15]);
                $stmt->execute(["question", "Írj nekünk!", "100", 21]);
                $stmt->execute(["contact","Kapcsolat", "111", 20]);
                $stmt->execute(["advert", "Új hirdetés", "001", 25]);
                $stmt->execute(["admin","Admin","001", 30]);
                $stmt->execute(["login","Bejelentkezés", "100", 40]);
                $stmt->execute(["logout","Kilépés", "011", 50]);
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }



}

