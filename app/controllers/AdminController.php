<?php

namespace App\controllers;

use App\models\User;
use Delight\Auth\Auth;
use League\Plates\Engine;
use App\models\Category;
use App\models\Post;

class AdminController
{
    public $templates;
    public $category;
    public $post;
    public $user;
    public $auth;

    public function __construct( Auth $auth, Category $category, Post $post, User $user)
    {
        $this->auth = $auth;
        $this->category = $category;
        $this->templates =  new Engine('../app/views');
        $this->post = $post;
        $this->user = $user;
    }

    public function index()
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            echo $this->templates->render('admin/admin-panel');
        }else{
            header('Location: /');
            die;
        }
    }

    public function postControl()
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $posts = $this->post->getPosts();

            echo $this->templates->render('admin/admin-posts', ['posts' => $posts]);
        }else{
            header('Location: /');
            die;
        }
    }

    public function categoryControl()
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $categories = $this->category->getCategories();

            echo $this->templates->render('admin/admin-categories', ['categories' => $categories] );
        }else{
            header('Location: /');
            die;
        }
    }

    public function userControl()
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $users = $this->user->getUsers();

            echo $this->templates->render('admin/admin-users', ['users' => $users] );
        }else{
            header('Location: /');
            die;
        }
    }

    public function userPosts($id)
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $userPosts = $this->post->userPosts($id);
            echo $this->templates->render('user/user-posts', ['posts' => $userPosts]);
        }else{
            header('Location: /');
            die;
        }
    }

    public function userProfile($id)
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $userProfile = $this->user->getUser($id);
            echo $this->templates->render('user/profile', ['user' => $userProfile]);
        }else{
            header('Location: /');
            die;
        }
    }

    public function deleteUser($id)
    {
        if ( $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            try {
                $this->auth->admin()->deleteUserById($id);
                flash()->success('Пользователь успешно удален!');
                header("Location: {$_SERVER['HTTP_REFERER']}");
                die;
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                flash()->error('Unknown ID');
                header("Location: {$_SERVER['HTTP_REFERER']}");
                die;
            }
        }else {
            header('Location: /');
            die;
        }
    }
}