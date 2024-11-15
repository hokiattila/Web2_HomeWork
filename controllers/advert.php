<?php
use models\Car_Model;

require_once(SERVER_ROOT . 'models/view_loader.php');
include(SERVER_ROOT.'includes/error.inc.php');
include(SERVER_ROOT.'models/Car_Model.php');

class Advert_Controller
{
    public string $baseName;
    public Car_Model $model;

    public function __construct() {
        $this->baseName = 'advert';
        $this->model = new Car_Model();
    }

    public function main(array $vars): void {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_SESSION['userlevel']) || $_SESSION['userlevel'] != "__1") {
                $view = new View_Loader("error_main");
                return;
            }
            if(empty($vars['VIN']) ||empty($vars['brand']) ||empty($vars['modell']) ||empty($vars['build_year'])
                ||empty($vars['door_count']) ||empty($vars['color']) ||empty($vars['weight']) ||empty($vars['power'])
                ||empty($vars['con']) ||empty($vars['fuel_type']) || empty($vars['price'])) {
                Raise_Error::raiseError($this, "Minden mező kitöltése kötelező!");
            }
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/ottakocsid/public/img/cars/" . $vars['VIN'];
            if (!file_exists($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    die("Hiba a mappa létrehozásakor: $target_dir");
                }
            }
            $file_count = 1;
            if (is_array($_FILES['image']['name'])) {
                foreach ($_FILES['image']['name'] as $key => $name) {
                    if ($_FILES['image']['error'][$key] == 0) {
                        $tmp_name = $_FILES['image']['tmp_name'][$key];
                        $file_extension = pathinfo($name, PATHINFO_EXTENSION);
                        $new_filename = sprintf("%02d.%s", $file_count++, $file_extension);
                        $target_file = $target_dir . '/' . $new_filename;

                        if (!move_uploaded_file($tmp_name, $target_file)) {
                            echo "Hiba történt a fájl áthelyezésekor: $new_filename";
                        } else {
                            echo "A fájl sikeresen át lett helyezve: $new_filename<br>";
                        }
                    }
                }
            } else {
                echo "Nincs fájl feltöltve, vagy a feltöltött fájl nem megfelelően van kezelve.";
            }
            $this->model->insertCar($vars['VIN'], $vars['brand'], $vars['modell'], $vars['build_year'], $vars['door_count'], $vars['color'], $vars['weight'],
                $vars['power'], $vars['con'], $vars['fuel_type'], $vars['price']);
            $_SESSION['car-insert'] = "successful";
            header("Location: /ottakocsid/home");

            } else {
            $view = new View_Loader($this->baseName . "_main");
        }
    }
}
