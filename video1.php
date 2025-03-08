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


$user = new User();


if($user->isLoggedin()){
    echo'<br>'.'Logged in !!';
    ?>
    
   <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a>!</p>
    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">update</a></li>
        <li><a href="changepassword.php">Change password</a></li>
    </ul>
    <?php
    
    if($user->hasPermission('moderator')){
        echo '<p> You are a moderator</p>';

    } 

}else{
    echo '<p> You need to <a href="login.php">Login</a> or <a href="register.php">register </a></p>';
}
// $another = new User(7);
