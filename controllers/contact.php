<?php
require_once(SERVER_ROOT . 'models/view_loader.php');
class Contact_Controller {
    public string $baseName = 'contact';
    public function main(array $vars) : void {
        $view = new View_Loader($this->baseName."_main");
    }
}
?>