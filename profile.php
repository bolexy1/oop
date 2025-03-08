<?php
require_once 'core/init.php';



if(!$username = Input::get('user')){
    Redirect::to('video1.php');
}else{
    $user = new User($username);

    if(!$user->exists()){
        Redirect::to(404);

    }else {
        $data = $user->data();
    }

    ?>
    <h3><?php echo escape($data->username);?></h3>
    <p>Full name: <?php echo escape($data->name);?> </p>

<?php


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    
</body>
</html>