<?php
require_once 'core/init.php';

// echo config::get('mysql/host');

// $user = DB::getInstance()->query('SELECT * FROM users');


// if(!$user->count()){
//     echo 'no user';
// }else {
//     // foreach($user->results() as $user){
//     //     echo $user->username,'<br>';
//     // }
//     echo $user->first()->username;
// }

$user = DB::getInstance() ->insert('users', array(
    'username'=>'bolexy',
    'password'=> 'password',
    'salt' => 'salt'

)
);