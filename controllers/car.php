<?php
use models\Car_Model;
require_once(SERVER_ROOT . 'models/view_loader.php');
include(SERVER_ROOT.'models/Car_Model.php');
class Car_Controller
{
    public string $baseName;
    public Car_Model $model;
    public array|bool $car;
    public array|bool $carIMG;
    public string|false $VIN;
    public array $favorite_cars;


    public function __construct()
    {
        $this->baseName = "car";
        $this->model = new Car_Model();
        $this->car = false;
        $this->carIMG = false;
        $this->VIN = false;
        $this->favorite_cars = $this->model->fetchFavoriteCarData($_SESSION['username']);
    }

    public function searchVIN(array $array, string $VIN): bool {
        foreach ($array as $item)
            if (isset($item["car_VIN"]) && $item["car_VIN"] === $VIN)  return true;
        return false;
    }

    public function main(array $vars): void
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $allowed_requests = array("fav", "delete");
            if (!in_array($vars[0], $allowed_requests) || empty($vars[1]) || !($this->model->checkVIN($vars[1]))) {
                $view = new View_Loader("error_main");
                return;
            }
            $redirect = "/ottakocsid/car/" . $vars[1];
            if ($vars[0] == "fav" && key_exists("favorite-btn", $vars) && $_SESSION['username'] != "unknown" && $_SESSION['userlevel'] == "_1_") {
                $this->model->insertFavorite($_SESSION['username'], $vars[1]);
                header("Location: " . $redirect);
            } else if ($vars[0] == "fav" && key_exists("delete-favorite-btn", $vars) && $_SESSION['username'] != "unknown" && $_SESSION['userlevel'] == "_1_") {
                $this->model->removeFavoriteRecord($_SESSION['username'], $vars[1]);
                header("Location: " . $redirect);
            } else if ($vars[0] == "delete" && $_SESSION['username'] != "unknown" && $_SESSION['userlevel'] == "__1") {
                $this->model->deleteCar($vars[1]);
                header("Location: /ottakocsid/home");
            }

        } else {
            // GET REQUEST - Favorite control
            if ($vars[0] == "fav") {
                if(empty($vars[1]) ||  !($this->model->checkVIN($vars[1])) || $_SESSION['userlevel'] === "__1" || $_SESSION['userlevel'] === "1__" ||$_SESSION["username"] == "unknown") {
                    $view = new View_Loader("error_main");
                    return;
                }
                $favorites = $this->model->fetchFavoritesByUser($_SESSION["username"]);
                (!$this->searchVIN($favorites, $vars[1])) ?
                    $this->model->insertFavorite($_SESSION['username'], $vars[1]) :  $this->model->removeFavoriteRecord($_SESSION['username'], $vars[1]);
                ($vars[2] != "fromfav") ? header("Location: /ottakocsid/home") : header("Location: /ottakocsid/favorites");
            } else {   // GET REQUEST - Simple listing
                if (empty($vars) || empty($vars[0]) || !($this->model->checkVIN($vars[0]))) {
                    $view = new View_Loader('error_main');
                    return;
                }
                $this->car = $this->model->fetchIndividualCar($vars[0]);
                $this->carIMG = $this->model->fetchImages($vars[0]);
                $this->VIN = $vars[0];

                $view = new View_Loader($this->baseName . "_main");
                $view->assign("car", $this->car);
                $view->assign("carIMG", $this->carIMG);
                $view->assign("VIN", $this->VIN);
                $view->assign("favoritecars", $this->favorite_cars);
            }
        }
    }
}
