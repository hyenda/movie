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

$id_video = $_GET['id_video'];
// var_dump($id_video);
// die();
// $id_video = 34;

$result = [];

$resultGetTags = mysqli_query(
    $conn, 
    "SELECT tags.name_tag FROM `video_tag` 
INNER JOIN tags ON video_tag.id_tag = tags.id_tag
WHERE video_tag.id_video = $id_video");
// $i = 0;
while ($row = mysqli_fetch_assoc($resultGetTags)) {
    $name_tag = $row['name_tag'];
    // $h = json_encode(["id" => $i, "text" => $name_tag]);
    array_push($result, $name_tag);
    // $i++;
}

header('Content-Type: application/json; charset=UTF-8');
die(json_encode(array('message' => 'Success get data tag', 'data' => $result , 'code' => 200)));
?>