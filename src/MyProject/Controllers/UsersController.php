<?php

namespace MyProject\Controllers;

use Myproject\Exception\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use Myproject\Services\EmailSender;
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
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php',[
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
            }
        }
        else{
            $this->view->renderHtml('users/signUp.php');
        }


    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid)
        {
            $user->activate();
            echo 'Ok';
        }

    }

}