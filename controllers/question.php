<?php

require_once(SERVER_ROOT . 'models/view_loader.php');

class Question_Controller {
    public string $baseName;

    public function __construct() {
        $this->baseName = "question";
    }

    public function main(array $vars): void
    {
        $view = new View_Loader($this->baseName . "_main");
    }
}
