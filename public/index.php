<?php

require '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;

$queryFactory = new QueryFactory('mysql');

$select = $queryFactory->newSelect();

$select->cols(['*'])
    ->from('posts');

// a PDO connection
$pdo = new PDO("mysql:host=localhost;dbname=phpcourse2;charset=utf8;","root","");

// prepare the statement
$sth = $pdo->prepare($select->getStatement());

// bind the values and execute
$sth->execute($select->getBindValues());

// get the results back as an associative array
$result = $sth->fetch(PDO::FETCH_ASSOC);

var_dump($result);

/*$routes = [
    "/" => 'controllers/homepage.php',
    "/about" => 'controllers/aboutus.php',
    "/add" => 'controllers/create.php',

    "/delete" => 'controllers/delete.php',
    "/edit" => 'controllers/edit.php',
    "/show" => 'controllers/show.php',
    "/store" => 'controllers/store.php',
    "/update" => 'controllers/update.php'
];
$route = $_SERVER['REQUEST_URI'];

$get_param = stripos($route, '?');
if($get_param !== false){
    $route = substr($route, 0, $get_param);
}

if (array_key_exists($route, $routes)){
    include __DIR__ . '/../' . $routes[$route]; exit;
} else {
    include __DIR__ . '/../controllers/functions.php';
    dd(404);
}*/






