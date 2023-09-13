<?php

namespace MyProject\Controllers;

use Myproject\Exception\InvalidArgumentException;
use MyProject\Models\Users\User;
use Myproject\View\View;

class UsersController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function signUp()
    {

        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $invalidArgumentException) {
                $this->view->renderHtml('users/signUp.php', ['error' => $invalidArgumentException->getMessage()]);
                return;
            }

            if ($user instanceof User)
            {
                $this->view->renderHtml('users/signUpSuccessful.php');
            }
        }
        else{
            $this->view->renderHtml('users/signUp.php');
        }


    }

}