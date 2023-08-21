<?php

require '../koneksi.php';

function fair($msg, $msgH = null, $code){
    if ($code > 300 || $code <= 200) {
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => $msg, 'code' => $code)));
    }elseif($code <= 300){
        header("HTTP/1.1 400 $msgH");
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => $msg, 'code' => $code)));
    }
}

try {
    // var_dump($_POST, $_FILES);
    // die();
    $id_user = $_POST['id_user'];
    $name = $_POST['name'];
    $image = $_POST['image-hidden'];
    $locale = $_POST['locale'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $tagline = $_POST['tagline'];

    $result = mysqli_query($conn, "UPDATE `users` SET `name` = '$name', users.image = '$image', locale = '$locale', instagram = '$instagram', facebook = '$facebook', tagline = '$tagline'  WHERE `users`.`id_user` = $id_user");
    
    // var_dump($result, $id_user);
    // die();

    fair('Your profile has been updated', null, 200);
} catch (\Throwable $th) {
    fair('Something wrong', 'Internal server error', 500);
}

?>