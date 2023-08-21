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

$id_video = $_GET['id'];

try {
    mysqli_query($conn, "DELETE FROM video_tag WHERE id_video = $id_video");
    mysqli_query($conn, "DELETE FROM videos WHERE id_video = $id_video");
    fair('Your video has been deleted', null, 200);
} catch (\Throwable $th) {
    fair('Something wrong', 'Internal server error', 500);
}



?>