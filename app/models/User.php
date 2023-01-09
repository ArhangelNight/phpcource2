<?php

namespace App\models;

use App\controllers\MyQueryBuilder;
use PDO;
use App\controllers\ImageManager;
use App\controllers\Validator;

class User
{
    public $db;

    public function __construct(MyQueryBuilder $db)
    {
        $this->db = $db;
    }

    public function getUsers()
    {
        return $this->db->getAll('users');
    }

    public function getUser($id)
    {
        return $this->db->getOne('users', $id);
    }

    public function updateUser($data, $id)
    {
        $cleanData = Validator::clean($data);
        $errorMessage=Validator::validation($cleanData);

        if(empty($errorMessage)){
            $this->db->update('users', [
                'username' => $cleanData['Name'],
                'email' => $cleanData['Email'],
            ], $id);
            flash()->success('Профиль успешно изменен');
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        else {
            flash()->error($errorMessage);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    public function getUserAvatar($id)
    {
        return $this->db->getUserAvatar($id);
    }

    public function updateAvatar($oldAvatar, $avatarFile, $id)
    {
        if(!empty($avatarFile['tmp_name']))
        {
            $imageManager = new ImageManager();
            $filename = $imageManager->uploadImage($avatarFile, 'avatar-imgs');
            $imageManager->deleteImage($oldAvatar);

            $isImg=Validator::imgEmpty($filename);
            if ($isImg === false) {
                $this->db->update('users', [
                    'avatar' => $filename
                ], $id);

                flash()->success('Аватар успешно сохранен');
            }else{
                flash()->error($isImg);
            }
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

}