<?php


include 'functions.php';

$db = include __DIR__ . '/../database/start.php';
$posts = $db->getAll('posts');

include __DIR__ . '/../views/index.view.php';
?>;
