<?php
use models\Car_Model;
include(SERVER_ROOT.'models/Car_Model.php');
require_once(SERVER_ROOT . 'models/view_loader.php');
class Favorites_Controller {
    public string $baseName;
    public Car_Model $model;
    public array|bool $favorite_cars;
    public function __construct() {
        $this->baseName = 'favorites';
        $this->model = new Car_Model();
        $this->favorite_cars = false;
    }
    public function main(array $vars): void
    {
        if(empty($_SESSION['username']) ||$_SESSION['username'] == "unknown" || $_SESSION['userlevel'] != '_1_') {
            $view = new View_Loader("error_main");
            return;
        }
        $this->favorite_cars = $this->model->fetchFavoriteCarData($_SESSION['username']);
        $view = new View_Loader($this->baseName . "_main");
        $view->assign("favoritecars", $this->favorite_cars);
    }
}
