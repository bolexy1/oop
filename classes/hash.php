<?php
Class Hash {
    public static function make($string, $salt=''){
        return hash('md5',$salt);

    }

    public static function salt($lenght){
        return md5($lenght);

    }

    public static function unique(){
        return self::make(unique());

    }
}