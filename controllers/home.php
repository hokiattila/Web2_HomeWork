<?php

class Home_Controller {
    public string $baseName = 'home';
    public function main(array $vars): void {
        $view = new View_Loader($this->baseName.'_main');
    }
}