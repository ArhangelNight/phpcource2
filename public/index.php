<?php
if( !session_id() ) @session_start();

require '../vendor/autoload.php';
use DI\ContainerBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;

$templates = new League\Plates\Engine('../app/views');

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
Engine::class => function () {
        return new Engine('../app/views');
    },
    PDO::class => function () {
        $driver = "mysql";
        $host = "localhost";
        $db_name = "phpcourse2";
        $user = "root";
        $password = "";
        return new PDO("$driver:host=$host;dbname=$db_name", $user, $password);
    },
    Auth::class => function ($container) {
        return new Auth($container->get('PDO'));
    },
    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    }
]);


$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '/register', ['App\controllers\RegisterController' , 'index']);
    $r->addRoute('POST', '/register', ['App\controllers\RegisterController' , 'register']);
    $r->addRoute('GET', '/login', ['App\controllers\LoginController' , 'index']);
    $r->addRoute('POST', '/login', ['App\controllers\LoginController' , 'login']);
    $r->addRoute('GET', '/logout', ['App\controllers\LoginController' , 'logout']);



    $r->addRoute('GET', '/', ['App\controllers\HomeController' , 'index']);
    $r->addRoute('GET', '/about', ['App\controllers\HomeController' , 'about']);
    $r->addRoute('GET', '/show-post/{id:\d+}', ['App\controllers\HomeController' , 'showPost']);
    $r->addRoute('GET', '/category-posts/{id:\d+}', ['App\controllers\HomeController' , 'categoryPosts']);
    $r->addRoute('GET', '/my-posts', ['App\controllers\UserController' , 'userPosts']);
    $r->addRoute('GET', '/my-profile', ['App\controllers\UserController' , 'userProfile']);
    $r->addRoute('POST', '/change-profile/{id:\d+}', ['App\controllers\UserController' , 'updateUserProfile']);
    $r->addRoute('GET', '/edit-password/{id:\d+}', ['App\controllers\UserController' , 'editPassword']);
    $r->addRoute('POST', '/update-password/{id:\d+}', ['App\controllers\UserController' , 'updatePassword']);
    $r->addRoute('POST', '/edit-avatar/{id:\d+}', ['App\controllers\UserController' , 'editAvatar']);



    $r->addRoute('GET', '/admin', ['App\controllers\AdminController', 'index']);
    $r->addRoute('GET', '/admin/post-control', ['App\controllers\AdminController', 'postControl']);
    $r->addRoute('GET', '/admin/category-control', ['App\controllers\AdminController', 'categoryControl']);
    $r->addRoute('GET', '/admin/user-control', ['App\controllers\AdminController', 'userControl']);
    $r->addRoute('GET', '/admin/user-posts/{id:\d+}', ['App\controllers\AdminController' , 'userPosts']);
    $r->addRoute('GET', '/admin/user-profile/{id:\d+}', ['App\controllers\AdminController', 'userProfile']);
    $r->addRoute('GET', '/admin/delete-user/{id:\d+}', ['App\controllers\AdminController', 'deleteUser']);

    $r->addRoute('GET', '/admin/add-category', ['App\controllers\CategoryController', 'add']);
    $r->addRoute('POST', '/admin/store-category', ['App\controllers\CategoryController', 'create']);
    $r->addRoute('GET', '/admin/edit-category/{id:\d+}', ['App\controllers\CategoryController', 'edit']);
    $r->addRoute('POST', '/admin/update-category/{id:\d+}', ['App\controllers\CategoryController', 'update']);
    $r->addRoute('GET', '/admin/delete-category/{id:\d+}', ['App\controllers\CategoryController', 'delete']);



    $r->addRoute('GET', '/add-post', ['App\controllers\PostController', 'add']);
    $r->addRoute('POST', '/store-post', ['App\controllers\PostController', 'create']);
    $r->addRoute('GET', '/edit-post/{id:\d+}', ['App\controllers\PostController', 'edit']);
    $r->addRoute('POST', '/update-post/{id:\d+}', ['App\controllers\PostController', 'update']);
    $r->addRoute('GET', '/delete-post/{id:\d+}', ['App\controllers\PostController', 'delete']);



});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo $templates->render('404');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1],$routeInfo[2]);

        // ... call $handler with $vars
        break;
}
