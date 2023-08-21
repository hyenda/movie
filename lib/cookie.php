<?php

$mode;

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $google_id = $_COOKIE['id'];
    $key  = $_COOKIE['key'];
    $check_cookie = mysqli_query($conn, "SELECT * FROM users WHERE google_id = '$google_id'");
    $user_info = mysqli_fetch_assoc($check_cookie);
    $mode = 'user';
    // var_dump($user_info);
    // die();
    if (hash('sha256', $user_info['google_id']) != $key) {
        $mode = 'guest';
    }
    
} else {
    $mode = 'guest';
}

?>