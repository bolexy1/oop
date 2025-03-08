<?php
require_once "core/init.php";

// var_dump(Hash::make("123456", "6364d3f0f495b6ab9dcf8d3b5c6e0b01"));


if(Input::exists()){
    if(Token::check(Input::get('token'))){
        // echo"please work";
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' =>2,
                    'max' =>20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6
                
                ),
                'cpassword' => array(
                    'required' => true,
                    'matches' => 'password',
                ),
                'name' => array(
                    'required' => true,
                    'min'   =>2,
                    'max'  => 50
                ),
            ));
        

        if($validation ->passed()){
            // Session::flash('success','you registered successfully!');
            // header('Location: video1.php');
            
            $user = new User();
            try {

               $salt = Hash::salt(32);
               

                $user->create(array(
                    'username' => Input::get('username'),
                    // 'password' => Hash::make(Input::get('password'),$salt),
                    'password' => Hash::make(Input::get('password'),$salt),  
                    'salt' => $salt,
                    'name' => Input::get('name'),
                    'joined' => date('y-m-d H:i:s'),
                    'group' => 1 
                ));
            //     echo "why na";
            //    die();
                Session::flash('home','You have registered successfully and can now login!!');
                Redirect::to('video1.php');
                
                
            } catch (Exception  $e) {
                die($e->getMessage());
            }
        }
        else{
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
    <title>Register page</title>
</head>
<body>
    <form action="" method ="POST">
        <div class="field" >
            <label for="username">username</label><br>
            <input type="text" placeholder ="username" name="username" id="username" value="<?php echo escape(Input::get('username'))?>" autocomplete="off"><br><br>
            <label for="password">Password</label><br>
            <input type="password" placeholder ="enter password" name="password" id="password"><br><br>
            <label for="password"> confirm Password</label><br>
            <input type="password" placeholder ="re-enter password" name="cpassword" id="cpassword"><br><br>
            <label for="username">Full name</label><br>
            <input type="text" placeholder ="Full name" name="name"  id="name" value="<?php echo escape(Input::get('fullname'))?>" autocomplete="off"><br><br>
            <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        </div>
        <button type="submit" value ="Register">Submit</button>
        
    </form>
</body>
</html>