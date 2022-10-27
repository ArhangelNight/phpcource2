<?php
include 'functions.php';
$db = include __DIR__ . '/../database/start.php';
include __DIR__ . '/../database/ImageManager.php';

$imageManager = new ImageManager();

$id = $_GET['id'];
$db->delete('posts', $id);
$imageManager->deleteImage($_GET['image']);


header('Location: /');