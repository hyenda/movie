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

    $resultDataVideo = mysqli_query($conn, "SELECT * FROM videos WHERE id_video = $id_video LIMIT 1");

    $rowDataVideo = mysqli_fetch_assoc($resultDataVideo);
    
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode([
        'message' => 'Something wrong, try again!',
        'data' => $rowDataVideo,
        'code' => 200
    ]));
?>