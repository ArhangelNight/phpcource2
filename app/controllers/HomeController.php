<?php

namespace App\controllers;

use App\models\Category;
use Delight\Auth\Auth;
use League\Plates\Engine;
use App\models\Post;


class HomeController {

    private $templates;
    public $post;
    public $category;
    public $auth;

    public function __construct(Category $category, Post $post, Auth  $auth)
    {

        $this->templates =  new Engine('../app/views');
        $this->post = $post;
        $this->category = $category;
        $this->auth = $auth;
    }

    public function index()
    {
        //var_dump($this->auth->getEmail());die;
        $posts = $this->post->getPosts();
        $categories = $this->category->getCategories();

        echo $this->templates->render('home-page', ['posts' => $posts, 'categories' => $categories, 'postsPage' => 'All Posts']);

    }

    public function showPost($id)
    {
        $post = $this->post->getPost($id);
        $categories = $this->category->getCategories();
        echo $this->templates->render('post-page', ['post' => $post, 'categories' => $categories]);
    }

    public function about()
    {
        echo $this->templates->render('about');
    }

    public function categoryPosts($id)
    {
        $posts = $this->category->getCategoryPosts($id);
        $categories = $this->category->getCategories();
        echo $this->templates->render('home-page', ['posts' => $posts, 'postsPage' => 'Posts By Category', 'categories' => $categories]);
    }

}
