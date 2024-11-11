<?php


class Login_Controller
{
    public string $baseName = 'login';

    public function main(array $vars): void
    {
        $view = new View_Loader($this->baseName . '_main');
    }
}