<?php


require_once(SERVER_ROOT . 'models/view_loader.php');
include(SERVER_ROOT.'models/Review_Model.php');
use models\Review_Model;

class Review_Controller {
    public string $baseName = 'review';
    private Review_Model $model;

    public function __construct() {
        $this->baseName = "review";
        $this->model = new Review_Model();
    }

    public function main(array $vars = null): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Törlés kezelése
            if (isset($vars[0]) && $vars[0] == 'submitReview') {
                $this->submitReview($vars);
            }
            if (isset($vars[0]) && $vars[0] == 'submitResponse') {
                $this->submitResponse($vars);
            }
        }

        $view = new View_Loader($this->baseName . "_main");
        // Vélemények betöltése
        $reviews = $this->model->getReviews();
        $responses = $this->model->getResponses();
        $view->assign("reviews", $reviews);
        $view->assign("responses", $responses);
    }
    // Vélemény beküldése
    public function submitReview(array $vars): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Értékelés adatai
            $stars = $_POST['stars'];
            $title = $_POST['title'];
            $name = $_SESSION['username'];
            $message = $_POST['message'];

            // Model használata
            $this->model->addReview($stars, $title, $name, $message);
        }

        // Vissza a vélemények listájához
        $reviews = $this->model->getReviews();
        // Post/Redirect/Get minta alkalmazása
        header('Location: /ottakocsid/review'); // Itt átirányítjuk a felhasználót a GET kérésre
        exit;
    }

    // Válasz beküldése
    // Vélemény válaszának hozzáadása
    public function submitResponse(array $vars): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = $_POST['review_id'];
            $name = $_SESSION['username'];
            $message = $_POST['message'];

            // Hozzáadjuk a választ a megfelelő véleményhez
            $this->model->addResponse($review_id, $name, $message);
        }

        // Vissza a vélemények listájához
        $reviews = $this->model->getReviews();
        // Post/Redirect/Get minta alkalmazása
        header('Location: /ottakocsid/review'); // Itt átirányítjuk a felhasználót a GET kérésre
        exit;

    }

}
