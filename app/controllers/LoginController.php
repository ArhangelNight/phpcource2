<?php


namespace App\controllers;

use League\Plates\Engine;
use PDO;

class LoginController
{
    public $templates;
    private $auth;

    public function __construct(Engine $engine)
    {
        $this->templates = $engine;
        $db = new PDO("mysql:host=localhost;dbname=phpcourse2;charset=utf8;","root","");
        $this->auth = new  \Delight\Auth\Auth($db);
    }

    public function index()
    {
        echo $this->templates->render('auth/authorization');

    }


    public function login()
    {
        try {
             $this->auth->login($_POST['email'], $_POST['password']);

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
        flash()->success('До встречи!');
        header('Location: /');
        die;
    }

}