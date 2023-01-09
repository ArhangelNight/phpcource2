<?php

namespace App\controllers;

use App\models\Category;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;
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
        $per_page = 3;
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $urlPattern = '?page=(:num)';
        $totalPosts = count($this->post->getPosts());

        $posts = $this->post->getPostsPerPage($per_page, $page);
        $categories = $this->category->getCategories();

        $paginator = new Paginator($totalPosts, $per_page, $page, $urlPattern);

        echo $this->templates->render('home-page', ['posts' => $posts, 'categories' => $categories, 'postsPage' => 'All Posts', 'paginator' => $paginator]);

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
        $per_page = 3;
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $urlPattern = '?page=(:num)';
        $totalPosts = count($this->category->getCategoryPosts($id));

        $posts = $this->category->getCategoryPostsPerPage($id, $per_page, $page);
        $categories = $this->category->getCategories();

        $paginator = new Paginator($totalPosts, $per_page, $page, $urlPattern);

        echo $this->templates->render('home-page', ['posts' => $posts, 'postsPage' => 'Posts By Category', 'categories' => $categories, 'paginator' => $paginator]);
    }

}
