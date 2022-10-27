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

$errorMessage= Validator::empty_validation($clean_data);
if(empty($errorMessage)){
    if ($_FILES['image']['name']) {
        $imageMeneger = new ImageManager();
        $filename = $imageMeneger->uploadImage($_FILES['image']);

        $imageMeneger->deleteImage($_POST['oldImage']);
    }
    else{
        $filename = $_POST['oldImage'];
    }
    $db->update('posts', $data = [
        'title' => $clean_data['title'],
        'description' => $clean_data['description'],
        'image' => $filename
    ],
        $_GET['id']);
    header('Location: /');
}

else{
    require 'errors.php';
    exit;
}
