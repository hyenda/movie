<?php
session_start();
// Include file gpconfig
include('gpconfig.php');
include('koneksi.php');

$login_button = '';

if(isset($_GET["code"])){

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
 
 if(!isset($token['error'])){ // setalah kita mendapatkan token, kita cek apakah token itu error atau enggak
  $google_client->setAccessToken($token['access_token']);
  $_SESSION['access_token'] = $token['access_token'];
  $google_service = new Google_Service_Oauth2($google_client);
  $data = $google_service->userinfo->get();
//   var_dump($data);
//   die();
  $google_id = $data["id"];
  $name = $data["givenName"];
  $email = $data["email"];
  $picture = $data["picture"];
  $locale = $data["locale"];
    $check = mysqli_query($conn, "SELECT * FROM users WHERE google_id = '$google_id'"); // kita cek dulu user apakah sudah login atau tidak
    $row = mysqli_fetch_assoc($check);
    
    if (!$check || $row == null) {
        // jika false maka register data user ke database
        $mysql = mysqli_query($conn, "INSERT INTO users VALUES ('', '$name', '$email', '$picture', '$google_id', '$locale', '', '', 'Im the best')");
        if ($mysql) {
            setcookie('id', $google_id, time() + 60 * 60 *24);
            setcookie('key', hash('sha256', $google_id), time() + 60 * 60 *24);
            header("location: index.php");
        } else {
            var_dump("Error Mysql");
        }
    } else {
        setcookie('id', $google_id, time()  + ((60 * 60) * 24) * 3);
        setcookie('key', hash('sha256', $google_id), time() + 60 * 60 *24);
        header("location: index.php");
    }

  
 }
}
?>