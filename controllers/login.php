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
    private array $error = array(
        "tokenmissmatch" => "Sikertelen token validálás",
        "empty_username" => "Hiányzó felhasználónév vagy jelszó",
        "empty_password" => "Hiányzó felhasználónév vagy jelszó",
        "invalid_credentials" => "Hibás felhasználónév vagy jelszó",
        "invalid_email" => "Nem megfelelő email formátum",
        "psw_missmatch" => "A jelszavak nem egyeznek",
        "forbidden_credentials" => "Nem engedélyezett karakterek",
        "invalid_phone" => "Nem megfelelő telefonszám formátum",
        "nouserlogin" => "A folytatáshoz jelenkezzen be"
    );


    public function main(array $vars): void
    {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $token = $vars['token'];
            $username_input = $vars['username'];
            $password_input = $vars['password'];

            if($token != $_SESSION['token']) Raise_Error::raiseError($this,"Sikertelen token validálás");
            else if(empty($username_input) || empty($password_input)) Raise_Error::raiseError($this,"Hiányzó felhasználónév vagy jelszó");
            else {
                $res = $this->model->fetchUserData($username_input, $password_input);
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
            $view = new View_Loader($this->baseName .'_main');
            $view->assign("token", Token::generateToken());
        }
    }
}