<?php

include __DIR__ . '/../database/Validator.php';
include 'functions.php';
require_once __DIR__ . '/../database/ImageManager.php';
$db = include __DIR__ . '/../database/start.php';

$data = [
    'title' => ($_POST['title']),
    'description' => ($_POST['description']),
    ];

$clean_data = Validator::clean($data);

$clean_data['image'] = $_FILES['image']['name'];

$errorMessage= Validator::empty_validation($clean_data);

if (empty($errorMessage)) {

    $image=$_FILES['image'];

    $imageMeneger = new ImageManager();
    $filename = $imageMeneger->uploadImage($image);

    $db->create('posts', ['title' => $clean_data['title'],
        'description' => $clean_data['description'],
        'image' => $filename
    ]);

    header('Location: /');
}
else {
    require 'errors.php';
    exit();
}


