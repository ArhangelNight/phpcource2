<?php


namespace App\controllers;

use App\models\User;
use League\Plates\Engine;
use PDO;

class LoginController
{
    public $templates;
    public $user;
    private $auth;

    public function __construct(Engine $engine, User $user)
    {
        $this->templates = $engine;
        $db = new PDO("mysql:host=localhost;dbname=phpcourse2;charset=utf8;","root","");
        $this->auth = new  \Delight\Auth\Auth($db);
        $this->user = $user;
    }

    public function index()
    {
        echo $this->templates->render('auth/authorization');

    }


    public function login()
    {
        $this->clearOldUserData();
        try {
             $this->auth->login($_POST['email'], $_POST['password']);
             $this->setUserInfo();

            flash()->success('Добро пожаловать!');

            header('Location: /');
            die;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Wrong email address');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Wrong password');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error('Email not verified');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            header('Location: /login');
            die;
        }
    }

    public function logout()
    {
        $this->auth->logOut();
        $_SESSION['_internal_user_info'] = null;
        flash()->success('До встречи!');
        header('Location: /');
        die;
    }


    public function setUserInfo() {
        if (!$this->auth->isLoggedIn()) {
            $_SESSION['_internal_user_info'] = null;
        }

        if (!isset($_SESSION['_internal_user_info'])) {
            $user_id = $this->auth->getUserId();
            $avatar_path = $this->user->getUserAvatar($user_id);
            $_SESSION['_internal_user_info'] = [
                'user_id' => $user_id,
                'user_name' => $this->auth->getUsername(),
                'user_role' => $this->auth->hasRole(\Delight\Auth\Role::ADMIN) ? 1 : 0,
                'user_avatar' => ($avatar_path["avatar"] != null) ? "/../uploads/".$avatar_path["avatar"] : "/../img/default_user_photo.jpg"
            ];
        }
    }

    public function clearOldUserData()
    {
        $this->auth->logOut();
        $_SESSION['_internal_user_info'] = null;
    }

}