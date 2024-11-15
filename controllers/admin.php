<?php

class Admin_Controller {
    public string $baseName;
    public function __construct() {
        $this->baseName = "admin";
    }

    public function main(array $vars) {
        $view = new View_Loader($this->baseName."_main");
    }

}