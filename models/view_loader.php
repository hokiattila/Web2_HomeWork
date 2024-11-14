<?php

class View_Loader
{
    private array $data = [];
    private ?string $render = null;
    private ?array $selectedItems = null;
    private ?string $layout_style = null;
    private ?string $toastr_style = null;
    private ?string $style = null;
    private ?string $script = null;

    public function __construct(string $viewName)
    {
        // Nézetfájl ellenőrzése
        $viewFile = SERVER_ROOT . 'views/' . strtolower($viewName) . '.php';
        if (file_exists($viewFile)) {
            $this->render = $viewFile;
            $this->selectedItems = explode("_", $viewName);
        } else {
            die("Hiba: A nézetfájl nem található: " . $viewFile);
        }

        // Alap név meghatározása
        $baseName = explode("_", strtolower($viewName))[0];

        $defaultLayout = CSS . 'style.css';
        if(file_exists(SERVER_ROOT . $defaultLayout)) {
            $this->layout_style = $defaultLayout;
        }

        $defaultLayout = CSS . 'toastr.css';
        if(file_exists(SERVER_ROOT . $defaultLayout)) {
            $this->toastr_style = $defaultLayout;
        }

        // CSS fájl ellenőrzése relatív útvonallal
        $cssFilePath = CSS . $baseName . '.css';
        if (file_exists(SERVER_ROOT . $cssFilePath)) {
            $this->style = $cssFilePath;
        }

        // JavaScript fájl ellenőrzése relatív útvonallal
        $jsFilePath = JS . $baseName . '.js';
        if (file_exists(SERVER_ROOT . $jsFilePath)) {
            $this->script = $jsFilePath;
        }
    }

    public function assign(string $variable, mixed $value): void
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        $this->data['render'] = $this->render;
        $this->data['selectedItems'] = $this->selectedItems;
        $this->data['layout_style'] = $this->layout_style;
        $this->data['toastr_style'] = $this->toastr_style;
        $this->data['style'] = $this->style;
        $this->data['script'] = $this->script;

        $viewData = $this->data;

        if ($this->render !== null) {
            include($this->render);
        } else {
            die("Hiba: A nézetfájl nem lett betöltve.");
        }
    }
}
