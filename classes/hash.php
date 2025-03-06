<?php
Class Hash {
    public $_hash;


    public static function make($string, $salt=''){
        return hash('sha256',$string.$salt);

    }

    public static function salt($length){
        return md5($length);

    }

    

    // public static function pass($password){
    //     return password_hash($password, PASSWORD_DEFAULT);

    // }

    // public static function verifyPassword($password, $hashedPassword) {
    //     return password_verify($password, $hashedPassword);
    // }

    public static function unique(){
        return self::make(unique());

    }
}