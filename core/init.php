<?php
session_start();

$GLOBALS['config']=array(
    'mysql'=> array (
        'host'=> '127.0.0.1',
        'username'=>'root',
        'password'=>'',
        'db'=>'tutorial'
    ),
    'remember'=>array(
        'cookie_name'=>'hash',
        'cookie_expiry'=>604800


    ),
    'session'=>array(
        'session_name'=>'user',
        'token_name' => 'token'

    )
    );
spl_autoload_register(function($class){
    require_once'classes/'.$class.'.php';
});

require_once 'functions/sanitize.php';

if (Cookie::exists(Config::get('remember/cookie_name'))&& !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck =DB::getInstance()->get('users_sessions', array('hash','=',$hash));

    if($hashCheck->count()){
        // echo $hashCheck->first()->user_id;
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }


}