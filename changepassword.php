<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedin()){
    Redirect::to('video1.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST,array(            
            'password_current' => array(
                'required' => true,
                'min' => 6,
                
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )

        ));

        if($validation->passed()){

            if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
                echo 'wrong password';
            }else{
                $salt= Hash::salt(32);
                $user->update(array(
                    'password'=> Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt

                ));

                Session::flash('home','Password updated successfuly');
                Redirect::to('video1.php');
            }

        }else{
            foreach($validation->errors() as $error){
                echo $error, "<br>";
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
    <title>Change password</title>
</head>
<body>

<form action="" method ="POST">
    <div>
        <label for="current_password">Current password</label>
        <input type="password" name="password_current" id='password_current'>
    </div><br>
    <div>
        <label for="new_password">New password</label>
        <input type="password" name="password_new" id='password_new'>
    </div><br>
    <div>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="password_new_again" id='password_new_again'>
    </div><br>

    <input type="submit" value ='change'>
    <input type="hidden" name="token" value ='<?php echo Token::generate(); ?>'>
</form>
    
</body>
</html>