<?php

namespace MyProject\Controllers;

use Myproject\Exception\ActivationException;
use Myproject\Exception\InvalidArgumentException;
use Myproject\Exception\NotFoundUserException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use Myproject\Models\Users\UsersAuthService;
use Myproject\Services\EmailSender;
use Myproject\View\View;

class UsersController extends AbstractController
{
    public function login()
    {
        if (!empty($_POST))
        {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /www/');
                exit();
            } catch (InvalidArgumentException $invalidArgumentException)
            {
                $this->view->renderHtml('users/login.php', ['error' => $invalidArgumentException->getMessage()]);
                return;
            }
        }
        else{
            $this->view->renderHtml('users/login.php');
        }
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
       try {

           $user = User::getById($userId);
           if ($user === null) {
               throw new ActivationException('Пользователь не найден');
           }
           if ($user->isActivated()) {
               throw new ActivationException('Пользователь уже активирован');
           }
           $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
           if ($user !== null && $isCodeValid === true) {
               $user->activate();
               UserActivationService::deleteActivationCode($user, $activationCode);
               $this->view->renderHtml('users/AccountActivated.php');
           }
       }catch (ActivationException $e)
       {
           $this->view->renderHtml('errors/activationError.php', ['error' => $e->getMessage()], 422);
       }
    }



}