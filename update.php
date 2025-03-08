<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedin()){
    Redirect::to('video1.php');

}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
       
        $validate= new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50

            )

        ));

        if($validation->passed()){


            try {
                $user->update(array(
                    'name' => Input::get('name')

                ));

                Session::flash('home','Your details has been updated');
                Redirect::to('video1.php');
            } catch (Exception $e) {
                die($e->getMessage());
                
            }

        }else{
            foreach($validation->errors() as $error ){
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
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <div class="field">
            <label for="name">Name</label>
            <input type="text" name='name' id='name' value ='<?php echo escape($user->data()->name);?>'>

            <input type="submit" value="update">
            <input type="hidden" name="token" value="<?php echo Token::generate();  ?>">

        </div>


    </form>
</body>
</html>