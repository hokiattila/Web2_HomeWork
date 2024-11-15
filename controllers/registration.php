<?php

require_once(SERVER_ROOT . 'models/view_loader.php');
use models\Register_Model;
use models\Login_Model;
include(SERVER_ROOT.'models/Register_Model.php');
include(SERVER_ROOT.'includes/token.inc.php');
include(SERVER_ROOT.'includes/error.inc.php');
include(SERVER_ROOT.'models/Login_Model.php');

class Registration_Controller
{
    public string $baseName;
    public Register_Model $model;
    public Login_Model $lmodel;

    public function __construct() {
        $this->baseName = "registration";
        $this->model = new Register_Model();
        $this->lmodel = new Login_Model();
    }

    public function main(array $vars): void {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if($_SESSION['username'] != "unknown" || $_SESSION['userlevel'] != '1__') {
                $view = new View_Loader("error_main");
            }

            if(!empty($this->lmodel->fetchUserData($vars['username'])[0]['username'])) {
                Raise_Error::raiseError($this, "Már létezik a felhasználó!");
                return;
            }

            if($_SESSION['token'] != $vars['token']) {
                Raise_Error::raiseError($this, "Token nem validálható");
                return;
            }

            if(empty($vars['username']) || empty($vars['password']) ||empty($vars['password_conf']) ||empty($vars['email'])
                ||empty($vars['firstname']) ||empty($vars['lastname']) ||empty($vars['szuldatum']) ||empty($vars['nem'])
                ||empty($vars['telefonszam'])) {
                Raise_Error::raiseError($this, "Minden mező kitöltése kötelező!");
                return;
            }

            if($vars['password'] != $vars['password_conf']) {
                Raise_Error::raiseError($this, "Nem egyező jelszavak!");
                return;
            }

            $this->model->insertUserData($vars['username'], password_hash($vars['password'], PASSWORD_DEFAULT),$vars['email'],$vars['lastname'],
                                        $vars['firstname'],$vars['szuldatum'],$vars['nem'],$vars['telefonszam']);

            $_SESSION['reg-try'] = "success";
            header("Location: /ottakocsid/login");
        } else {
            if($_SESSION['username'] != "unknown" || $_SESSION['userlevel'] != '1__') {
                $view = new View_Loader("error_main");
                return;
            }
            $view = new View_Loader($this->baseName . "_main");
            $view->assign("token", Token::generateToken());
        }
    }
}
