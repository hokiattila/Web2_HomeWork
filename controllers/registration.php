<?php

require_once(SERVER_ROOT . 'models/view_loader.php');
include(SERVER_ROOT.'includes/token.inc.php');

class Registration_Controller
{
    public string $baseName = 'registration';


    public function main(array $vars): void
    {
        $view = new View_Loader($this->baseName . "_main");
        $view->assign("token", Token::generateToken());
    }
}
