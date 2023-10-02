<?php

namespace MyProject\Controllers;

use Myproject\Exception\ActivationException;
use Myproject\Exception\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use Myproject\Models\Users\UsersAuthService;
use MyProject\Models\Users\UsersRegistrationService;
use Myproject\Services\EmailSender;


class UsersController extends AbstractController
{
    public function login()
    {
        if (!empty($_POST))
        {
            try {
                $user = UsersAuthService::login($_POST);
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

    public function account()
    {
        if (!empty($_FILES))
        {
            $uploaded_file = $_FILES['userfile']['tmp_name'];
            $destination_path = __DIR__ . '../../../../src/img/';
            $fileName = $_FILES['userfile']['name'];
            $error = $_FILES['userfile']['error'];
            User::updatePhoto($this->user, $fileName,$uploaded_file, $destination_path);
        }
        $this->view->renderHtml('users/account.php');
    }

    public function logOut(): void
    {
       UsersAuthService::deleteToken();
       header('Location: /www/');
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = UsersRegistrationService::signUp($_POST);
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
               UsersRegistrationService::activate($user);
               UserActivationService::deleteActivationCode($user, $activationCode);
               $this->view->renderHtml('users/AccountActivated.php');
           }
       }catch (ActivationException $e)
       {
           $this->view->renderHtml('errors/activationError.php', ['error' => $e->getMessage()], 422);
       }
    }



}