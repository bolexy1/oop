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

// $user = DB::getInstance() ->update('users',4, array(
//     'password'=> 'Password',
//     'name'  => 'ojumaribi',
      

// ));

// if($user){
//     echo "successful!!";
// }

if(Session::exists('home')){
    echo '<p>'.Session::flash('home').'</p>';
}
// }else{
//     echo $_SESSION['success'];
// }