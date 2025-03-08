<?php
require_once 'core/init.php';

if(Input::exists()){
    if(!Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            "username" => array('required' => true ),
            "password" => array('required' => true)
        ));

        if($validation->passed()){
            $user = new User();
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'),Input::get('password'), $remember);
            if($login){
                
                Redirect::to('video1.php');
            }else{
                echo'login failed';
            }

        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>'; 
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <div class = "field">
            <label for="username">username</label>
            <input type="text" name='username' id='username' autocomplete="off">   
        </div><br>
        <div class = "field">
            <label for="password">password</label>
            <input type="password" name='password' id='password' autocomplete="off">    
        </div><br>
        <div class = "field">
            <label for="remember"> 
                <input type="checkbox" name='remember' id='remember'>Remember me
            </label>
               
        </div><br>

        <input type="hidden",name="token" value="<?Php  echo Token::generate(); ?>">
        <input type="submit" name="" id="" value="login">



    </form>
</body>
</html>