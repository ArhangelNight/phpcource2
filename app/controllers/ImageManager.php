<?php

namespace App\controllers;

class ImageManager{
    public $image;
    private $new_file_name;
    private $extension;

    public function uploadImage($image, $directory)
    {
        $testImg=$this->file_size($image['size']);
        if( $testImg === true){
            $testImg=$this->get_image_format($image['name']);}
        if( $testImg === true){
            $this->new_file_name();
            $this->uploading ($image['tmp_name'], $directory);
        }elseif( $testImg !== true){
            $errorMessage = $testImg;
            flash()->error($errorMessage);
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
        return $directory . '/' . $this->new_file_name;
    }

    public function file_size($file_size)
    {
        if($file_size >(1024000)){
            $errorMessage = 'Ошибка! Недопустимый размер файла.';
            return $errorMessage;
        }
        return true;
    }

    public function get_image_format($file_name)
    {
        $this->extension = pathinfo($file_name,PATHINFO_EXTENSION);
        $types = array('png','jpeg','jpg');
        if(!in_array($this->extension, $types)){
            $errorMessage = 'Ошибка!Недопустимый формат файла.';
            return $errorMessage;
        }
        return true;
    }

    public function new_file_name()
    {
        return $this->new_file_name = md5 (microtime()) . "." . $this->extension;
    }

    public function uploading($tmp_name, $directory = 'post-imgs')
    {
        move_uploaded_file( $tmp_name, __DIR__ . '/../../public/uploads/'. $directory . '/' . $this->new_file_name);
    }

    public function deleteImage($delete_img)
    {
        if (!empty($delete_img)) {
            unlink('uploads/' . $delete_img);
        }
    }
}