<?php

namespace App\controllers;

use App\models\User;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;
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
            $per_page = 10;
            $page = $_GET['page'] ? $_GET['page'] : 1;
            $urlPattern = '?page=(:num)';
            $totalPosts = count($this->post->getPosts());

            $posts = $this->post->getPostsPerPage($per_page, $page);

            $paginator = new Paginator($totalPosts, $per_page, $page, $urlPattern);

            echo $this->templates->render('admin/admin-posts', ['posts' => $posts, 'paginator' => $paginator]);
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
            $per_page = 3;
            $page = $_GET['page'] ? $_GET['page'] : 1;
            $urlPattern = '?page=(:num)';
            $totalPosts = count($this->post->userPosts($id));

            $userPosts = $this->post->userPostsPerPage($id, $per_page, $page);
            $paginator = new Paginator($totalPosts, $per_page, $page, $urlPattern);

            echo $this->templates->render('user/user-posts', ['posts' => $userPosts, 'paginator' => $paginator]);
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