<?php

class Post_Controller {
    public string $baseName = 'post';
    public function main(array $vars): void {
        $view = new View_Loader('home_main');
        $view->assign("error", "valami");
    }


}