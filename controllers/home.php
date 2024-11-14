<?php
use models\Car_Model;
include(SERVER_ROOT.'models/Car_Model.php');
class Home_Controller {
    public string $baseName = 'home';
    public Car_Model $model;
    public int $pages;
    public int $limit;
    public array $cars;
    public array $brands;
    public array $favorite_cars;

    public function __construct() {
        $this->model = new Car_Model();
        $this->cars = array();
        $this->favorite_cars = $this->model->fetchFavoriteCarData($_SESSION['username']);
        $this->limit = 3;
        $this->pages = $this->model->getCarRowCount();
        $this->brands = $this->model-> fetchBrandNames();
    }

    public function main(array $vars): void {
            if(!empty($vars) && is_numeric($vars[0]) && (int) $vars[0] > 0 && (int) $vars[0] <= $this->pages) {
                $current = (int) $vars[0];
                $page = $current - 1;
                $start = $page * $this->limit;
            } else {
                $current = 1;
                $start = 0;
                $page = 0;
            }

        $this->cars = ($start != 0) ? $this->model->fetchCarData($start, $this->limit) : $this->model->fetchCarData(0, $this->limit);

        $view = new View_Loader($this->baseName.'_main');
        $view->assign("current", $current);
        $view->assign("page", $page);
        $view->assign("start", $start);
        $view->assign("cars", $this->cars);
        $view->assign("brands", $this->brands);
        $view->assign("favorite_cars", $this->favorite_cars);
    }
}