<?php

require_once(SERVER_ROOT . 'models/view_loader.php');

class Error_Controller
{
    public string $baseName = 'error';

    public function main(array $vars): void
    {
        $view = new View_Loader($this->baseName . "_main");
    }
}
