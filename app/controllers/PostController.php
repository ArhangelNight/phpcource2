<?php


namespace App\controllers;


use Delight\Auth\Auth;
use League\Plates\Engine;
use App\models\Category;
use App\models\Post;

class PostController
{
    public $templates;
    public $category;
    public $post;
    public $auth;

    public function __construct(Category $category, Engine $engine, Post $post, Auth $auth)
    {
        $this->templates = $engine;
        $this->category = $category;
        $this->post = $post;
        $this->auth = $auth;
    }


    public function add()
    {
        $categories = $this->category->getCategories();
        echo $this->templates->render('post/create', ['categories' => $categories]);
    }

    public function create()
    {
        $this->post->create($_POST, $_FILES ['image']);
    }

    public function edit(int $id)
    {
        $post = $this->post->getPost($id);
        if ($this->auth->getUserId() == $post['user_id'] || $this->auth->hasRole(\Delight\Auth\Role::ADMIN)){
            $categories = $this->category->getCategories();
            echo $this->templates->render('post/edit', ['post' => $post, 'categories' => $categories]);
        }
        header('Location: /');
        die;
    }

    public function update($id)
    {
        $this->post->update($_POST, $_FILES ['image'], $id);
    }

    public function delete($id)
    {
        $post = $this->post->getPost($id);
        if ($this->auth->getUserId() == $post['user_id'] || $this->auth->hasRole(\Delight\Auth\Role::ADMIN)){
            $this->post->delete($id);
        }
        header('Location: /');
        die;
    }

}