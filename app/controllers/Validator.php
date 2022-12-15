<?php

namespace App\controllers;

class Validator {

    public static function validation ($data){
        $errorMessage=array();
        foreach($data as $key => $value){
            if(empty($value)){
                $errorMessage[]="поле $key не заполнено\n";
            }
        }
        return $errorMessage;
    }

    public static function clean($data)
    {
        $cleanData= array();

        foreach ($data as $key => $value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $cleanData[$key]= $value;
        }
        return $cleanData;
    }

    public static function imgEmpty($imgName)
    {
        if(empty($imgName)) {
            $errorMessage='Добавте картинку';
            return $errorMessage;
        }
        return false;
    }
}