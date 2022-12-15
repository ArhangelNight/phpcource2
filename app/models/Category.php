<?php

namespace App\models;

use App\controllers\MyQueryBuilder;
use PDO;
use App\controllers\ImageManager;
use App\controllers\Validator;


class Category
{
    public $db;

    public function __construct(MyQueryBuilder $db)
    {
        $this->db = $db;
    }

    public function getCategories()
    {
        return $this->db->getAll('categories');
    }

    public function getCategory($id)
    {
        return $this->db->getOne('categories', $id);
    }

    public function getCategoryPosts($id)
    {
        return $this->db->getAllPostsByCategory($id);
    }

    public function create($data, $img)
    {
        $cleanData = Validator::clean($data);

        $errorMessage = Validator::validation($cleanData);

        $errorImage = Validator::imgEmpty($img['name']);
        if($errorImage === false && empty($errorMessage)){

            $imageManager = new ImageManager();
            $filename = $imageManager->uploadImage($img, 'category-imgs');

            $this->db->insert('categories', [
                'name' => $cleanData['title'],
                'img_path' => $filename
            ]);
            flash()->success('Запись успешно добавлена');
            header('Location: /admin/category-control');
            exit;
        }
        if($errorMessage || $errorImage) {
            if($errorMessage){
                flash()->error($errorMessage);
            }
            if($errorImage){
                flash()->error($errorImage);}
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
                $filename = $imageManager->uploadImage($img, 'category-imgs');
                $imageManager->deleteImage($_POST['oldImage']);
            }else{$filename = $_POST['oldImage'];
            }
            $isImg=Validator::imgEmpty($filename);
            if ($isImg === false) {
                $this->db->update('categories', [
                    'name' => $cleanData['title'],
                    'img_path' => $filename
                    ], $id);

                flash()->success('Запись успешно изменена');
                header('Location: /admin/category-control');
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
        $category = $this->db->getOne('categories', $id);
        $imageManager = new ImageManager();
        $imageManager->deleteImage($category['img_path']);

        $this->db->delete('categories', $id);

        flash()->success('Запись успешно удалена');
        header('Location: /admin/category-control');
        exit;
    }

}