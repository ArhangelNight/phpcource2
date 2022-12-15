<?php


namespace App\controllers;

use League\Plates\Engine;
use App\controllers\MyQueryBuilder;
use PDO;


class RegisterController
{

    public $templates;
    private $auth;
    private $qb;

    public function __construct(Engine $engine, MyQueryBuilder $qb)
    {
        $this->templates = $engine;
        $this->qb = $qb;
        $db = new PDO("mysql:host=localhost;dbname=phpcourse2;charset=utf8;","root","");
        $this->auth = new  \Delight\Auth\Auth($db);
    }


    public function index()
    {
        echo $this->templates->render('auth/register');
    }

    public function register()
    {

        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
             //   echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                $this->email_verification($selector, $token);
            });

            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Invalid email address');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Invalid password');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error('User already exists');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            header('Location: /login');
            die;
        }
    }

    public function email_verification($selector, $token)
    {
        try {
            $this->auth->confirmEmail($selector, $token);

            //echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error('Invalid token');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error('Token expired');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error('Email address already exists');
            header('Location: /login');
            die;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            header('Location: /login');
            die;
        }

    }

}