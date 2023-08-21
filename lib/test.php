<?php

require '../koneksi.php';

// mysqli_query($conn, "INSERT INTO tags VALUES(NULL, 'OSI')");
// mysqli_query($conn, "INSERT INTO `video_tag` (`id_video_tag`, `id_tag`, `id_video`) VALUES (NULL, '5', '1')");

// $res = mysqli_query($conn, 'SELECT LAST_INSERT_ID()');
// $row = mysqli_fetch_array($res);
// $lastInsertId = $row[0];


$dataTags = [];
    
function getDataTags(){
    global $conn, $dataTags;
    $query = mysqli_query($conn, "SELECT * FROM tags");
    $dataLocalTag = [];
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($dataLocalTag, $row);
    }

    $dataTags = $dataLocalTag;
    
    return true;
}

getDataTags();

function insertTags($tags){
    global $dataTags, $conn;
    $i = 0;
    $fore = 0;
    $dataTagsLocal = [];
    foreach ($dataTags as $dataTag) {
        array_push($dataTagsLocal, $dataTag['name_tag']);
    }
    foreach ($tags as $tag) {   
        if (!in_array($tag, $dataTagsLocal)) {
            $query = mysqli_query($conn, "INSERT INTO tags VALUES (NULL, '$tag')");
            if (!$query) {
                    header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'Something wrong, try again!', 'code' => 500)));
            }
            echo "$tag gak ada \n";
        }
    }
    // var_dump($dataTagsLocal);
}

insertTags(['the blues', 'dua', 'tiga']);
var_dump($dataTags);
getDataTags();

echo "setelah di insert =============";
var_dump($dataTags);

?>