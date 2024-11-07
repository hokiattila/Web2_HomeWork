<?php
class View_Loader {
    private array $data = array();
    private string|bool $render = false;
    private array|bool $selectedItems = false;
    private string|bool $style = false;
    private string|bool $script = false;

    public function __construct($viewName) {
        $file = SERVER_ROOT . 'views/' . strtolower($viewName) . '.php';
        if (file_exists($file))
        {
            $this->render = $file;
            $this->selectedItems = explode(separator: "_", string: $viewName);
        }
        $file = SERVER_ROOT . 'public/css/' . strtolower($viewName) . '.css';
        $filejs = SERVER_ROOT . 'public/js/' . strtolower($viewName) . '.js';
        if (file_exists($file))
        {
            $this->style = SITE_ROOT . 'public/css/' . strtolower($viewName) . '.css';
        }
        if (file_exists($filejs))
        {
            $this->script = SERVER_ROOT . 'public/js/' . strtolower($viewName) . '.js';
        }
    }

    public function assign($variable , $value): void {
        $this->data[$variable] = $value;
    }

    public function __destruct() {
        $this->data['render'] = $this->render;
        $this->data['selectedItems'] = $this->selectedItems;
        $this->data['style'] = $this->style;
        $this->data['script'] =  $this->script;
        $viewData = $this->data;
        include($this->render);
    }
}