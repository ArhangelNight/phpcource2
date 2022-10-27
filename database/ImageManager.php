<?php

class ImageManager{
    public $image;
    private $new_file_name;
    private $extension;

    public function uploadImage ($image){
        $this->image=$image;
        $size = $this->checkFileSize($image['size']);
        if($size === true){
            $format = $this->getImageFormat($image['name']);
        }
        if ($format === true) {
            $this->setNewFileName();
            return $this->uploading($image['tmp_name']);
        }
        return false;
    }

    public function checkFileSize($file_size)
    {
        if ($file_size > (10240000)) {
            $errorMessage = 'Ошибка!Недопустимый размер файла.';
            include __DIR__ . '/../controllers/errors.php';
            exit();
        }
        return true;
    }

    public function getImageFormat($file_name)
    {
        $this->extension = pathinfo($file_name, PATHINFO_EXTENSION);
       // dd($this->file_name);
        $types = array('png','jpeg','jpg',);
        if (!in_array($this->extension, $types)) {
            $errorMessage = 'Ошибка!Недопустимый формат файла.';
            include __DIR__ . '/../controllers/errors.php';
            exit();
        }
        return true;
    }

    public function setNewFileName()
    {
        return $this->new_file_name = md5(microtime()) . "." . $this->extension;
    }

    public function uploading($tmp_name)
    {
        move_uploaded_file($tmp_name, __DIR__ . '/../public/images/' . $this->new_file_name);
        return $this->new_file_name;
    }

    public function deleteImage($delete_img){
        if(!empty($delete_img)) {
            unlink('images/' . $delete_img);
        }
    }
}