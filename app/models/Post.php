<?php

namespace App\models;

use App\controllers\MyQueryBuilder;
use PDO;
use App\controllers\ImageManager;
use App\controllers\Validator;


class Post
{
    public $db;

    public function __construct(MyQueryBuilder $db)
    {
        $this->db = $db;
    }

    public function getPosts()
    {
        return $this->db->getAllPosts();
    }

    public function getPostsPerPage($per_page, $page)
    {
        return $this->db->getPostsByPage($per_page, $page);
    }

    public function getPost($id)
    {
        return $this->db->getOnePost($id);
    }

    public function create($data, $img)
    {
        $cleanData = Validator::clean($data);

        $errorMessage = Validator::validation($cleanData);

        $errorImage = Validator::imgEmpty($img['name']);
        if ($errorImage === false && empty($errorMessage)) {

            $imageManager = new ImageManager();
            $filename = $imageManager->uploadImage($img, 'post-imgs');

            $this->db->insert('posts', [
                'title' => $cleanData['title'],
                'description' => $cleanData['description'],
                'text' => $cleanData['text'],
                'category_id' => $cleanData['category'],
                'image' => $filename,

            ]);
            flash()->success('Пост успешно добавле');
            header('Location: /admin/post-control');
            exit;
        }
        if ($errorMessage || $errorImage) {
            if ($errorMessage) {
                flash()->error($errorMessage);
            }
            if ($errorImage) {
                flash()->error($errorImage);
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    public function update($data, $img, $id)
    {
        $cleanData = Validator::clean($data);
        $errorMessage=Validator::validation($cleanData);

        if(empty($errorMessage)){
            if(!empty($img['tmp_name'])){
                $imageManager = new ImageManager();
                $filename = $imageManager->uploadImage($img, 'post-imgs');
                $imageManager->deleteImage($_POST['oldImage']);
            }else{$filename = $_POST['oldImage'];
            }
            $isImg=Validator::imgEmpty($filename);
            if ($isImg === false) {
                $this->db->update('posts', [
                    'title' => $cleanData['title'],
                    'description' => $cleanData['description'],
                    'text' => $cleanData['text'],
                    'category_id' => $cleanData['category'],
                    'image' => $filename,
                ], $id);

                flash()->success('Запись успешно изменена');
                header('Location: /admin/post-control');
                exit;
            }
        }
        if($errorMessage || $isImg) {
            if($errorMessage){
                flash()->error($errorMessage);
            }
            if($isImg){
                flash()->error($isImg);}

            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }

    }

    public function delete($id)
    {
        $post = $this->db->getOne('posts', $id);
        $imageManager = new ImageManager();
        $imageManager->deleteImage($post['image']);

        $this->db->delete('posts', $id);

        flash()->success('Запись успешно удалена');
        header('Location: /admin/post-control');
        exit;
    }

    public function userPosts($userId)
    {
        return $this->db->getAllPostsByUser($userId);
    }

    public function userPostsPerPage($id, $per_page, $page)
    {
        return $this->db->getAllPostsByUserByPage($id, $per_page, $page);
    }

}