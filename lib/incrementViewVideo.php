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
    $id_video = $_GET['id'];
    mysqli_query($conn, "UPDATE videos SET view = view + 1 WHERE id_video = $id_video");
} catch (\Throwable $th) {
    fair('Something went wrong', 'Bad Request', 400);
}

?>