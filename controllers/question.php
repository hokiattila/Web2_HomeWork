<?php

use models\Question_Model;
include(SERVER_ROOT . 'models/Question_Model.php');

class Question_Controller
{
    public string $baseName;
    private Question_Model $model;

    public function __construct()
    {
        $this->baseName = "question";
        $this->model = new Question_Model();
    }

    public function main(array $vars = null): void
    {
        // Üzenetek
        $errors = [];
        $successMessage = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Űrlap adatainak kezelése
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $message = trim($_POST['message'] ?? '');

            // Validáció
            if (empty($name)) {
                $errors[] = "A név megadása kötelező.";
            }

            else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Érvényes email cím megadása kötelező.";
            }

            else if (empty($message) || strlen($message) < 10) {
                $errors[] = "Az üzenetnek legalább 10 karakter hosszúnak kell lennie.";
            }

            // Adatok mentése, ha nincs hiba
            else  {
                $this->model->saveQuestion($name, $email, $phone, $message);
                $successMessage = "Az üzenet sikeresen elküldve!";

            }

        }

        // Nézet betöltése
        $view = new View_Loader($this->baseName . "_main");
        $view->assign("errors", $errors);
        $view->assign("successMessage", $successMessage);
    }
}
