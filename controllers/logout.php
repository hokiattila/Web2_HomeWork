<?php
class Logout_Controller
{
    public $baseName = 'logout';
    public function main(array $vars) {
        if(isset($_SESSION['token'])) unset($_SESSION['token']);
        $_SESSION['username'] = "unknown";
        $_SESSION['userfirstname'] = "";
        $_SESSION['userlastname'] = "";
        $_SESSION['userlevel'] = "1__";
        $_SESSION['logged-out'] = true;
        header("Location: /ottakocsid/home");
    }
}
