<?php
class Raise_Error {

    public static function raiseError(object $obj, string $error) : void {
        $view = new View_Loader($obj->baseName.'_main');
        $view->assign("error", $error);
        $view->assign("token", Token::generateToken());
    }

}