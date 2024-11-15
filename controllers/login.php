<?php

use models\Login_Model;
include(SERVER_ROOT.'models/Login_Model.php');
include(SERVER_ROOT.'includes/token.inc.php');
include(SERVER_ROOT.'includes/error.inc.php');

class Login_Controller
{
    public string $baseName = 'login';
    public Login_Model $model;
    public function __construct() {
        $this->model = new Login_Model();
    }

    public function main(array $vars): void
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $token = $vars['token'];
            $username_input = $vars['username'];
            $password_input = $vars['password'];

            if($token != $_SESSION['token']) Raise_Error::raiseError($this,"Sikertelen token validálás");
            else if(empty($username_input) || empty($password_input)) Raise_Error::raiseError($this,"Hiányzó felhasználónév vagy jelszó");
            else {
                $res = $this->model->fetchUserData($username_input);
                if(!empty($res) && $res[0]['username'] == $username_input && password_verify($password_input, $res[0]['hashed_psw'])) {
                $_SESSION['username'] = $res[0]['username'];
                $_SESSION['userfirstname'] = $res[0]['first_name'];
                $_SESSION['userlastname'] = $res[0]['last_name'];
                $_SESSION['userlevel'] = $res[0]['permission'];
                $_SESSION['login-try'] = "success";
                header("Location: /ottakocsid/home");
                exit;
                } else {
                    Raise_Error::raiseError($this,"Hibás felhasználónév vagy jelszó");
                }
            }
        } else {
            if($_SESSION['username'] != "unknown" || $_SESSION['userlevel'] != '1__') {
                $view = new View_Loader("error_main");
                return;
            }
            $view = new View_Loader($this->baseName .'_main');
            $view->assign("token", Token::generateToken());
        }
    }
}