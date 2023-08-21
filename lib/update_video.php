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

    // get the tag
    $dataTags = [];
    // var_dump($_FILES, $_POST);
    // die();
    
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

    if (!getDataTags()) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Something wrong, try again!', 'code' => 500)));
    }

    function randomAlphaNum() {
        $character = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $string = '';

        for ($i=0; $i < 8; $i++) { 
            $pos = rand(0, strlen($character)-1);
            $string .= $character[$pos];
        }
        return $string;
    }

    function insertTags($tags){
        global $dataTags, $conn;
        // $i = 0;
        // $fore = 0;
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
            }
        }
        // var_dump($dataTagsLocal);
    }

    function genrateName($dataName, $type){
        global $conn;
        if ($type == 'video') {
            while (true) {
                $randomAlphaNum = randomAlphaNum();
                $name = $randomAlphaNum.$dataName;
                // check the name in db
                $query = mysqli_query($conn, "SELECT * FROM videos WHERE link = '$name'");
                if (mysqli_num_rows($query) < 1) {
                    return $name;
                }
            }
        } else {
            while (true) {
                $randomAlphaNum = randomAlphaNum();
                $name = $randomAlphaNum.$dataName;
                // check the name in db
                $query = mysqli_query($conn, "SELECT * FROM videos WHERE thumbnail = '$name'");
                if (mysqli_num_rows($query) < 1) {
                    return $name;
                }
            }
        }
        
    }

    function getLastIdInsert() {
        global $conn;
        $res = mysqli_query($conn, 'SELECT LAST_INSERT_ID()');
        $row = mysqli_fetch_array($res);
        $lastInsertId = $row[0];
        return intval( $lastInsertId);
    }
    
    function getIdTagVideos($tags){
        global $conn;
        $arrayIdTags = [];
        foreach ($tags as $tag) {
            $query = mysqli_query($conn, "SELECT id_tag FROM tags WHERE name_tag = '$tag' LIMIT 1");
            $row = mysqli_fetch_array($query);
            array_push($arrayIdTags, $row['id_tag']);
        }

        return $arrayIdTags;
    }

    function updateVideoHaveTag($tagNew, $tagOld, $id_video){
        global $conn;
        
        $tagMustRemove = [];
        $tagMustAdd = [];
        
        foreach ($tagOld as $tag) {
            if (!in_array($tag, $tagNew)) {
                array_push($tagMustRemove, $tag);   
            }
        }
        
        foreach ($tagNew as $tag) {
            if (!in_array($tag, $tagOld)) {
                array_push($tagMustAdd, $tag);   
            }
        }

        if (!empty($tagMustRemove)) {
            $dataIdTagVideos = getIdTagVideos($tagMustRemove);
            foreach ($dataIdTagVideos as $id_tag) {
                try {
                    $resultRemove = mysqli_query($conn, "DELETE FROM video_tag WHERE id_tag = $id_tag AND id_video = $id_video");   
                } catch (\Throwable $th) {
                    fair('Something wrong', 'Internal server error', 500);
                }
            }
        }

        if (!empty($tagMustAdd)) {
            $dataIdTagVideos = getIdTagVideos($tagMustAdd);
            foreach ($dataIdTagVideos as $id_tag) {
                try {
                    mysqli_query($conn, "INSERT INTO video_tag VALUES (
                        NULL, $id_tag, $id_video
                    )");
                } catch (\Throwable $th) {
                    fair('Something wrong', 'Internal server error', 500);
                }
            }
        }

    }

    function getDataTagOldVideo($id_video){
        global $conn;

        try {   
            $result = mysqli_query($conn, "SELECT name_tag FROM video_tag 
            INNER JOIN tags ON video_tag.id_tag = tags.id_tag WHERE id_video = $id_video");
        } catch (\Throwable $th) {
            fair('Something wrong', 'Internal server error', 500);
        }

        $resultEnd = [];
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($resultEnd, $row['name_tag']);
        }
        return $resultEnd;
    }

    $maxSizeVideo = 1024 * 1000000; // max size video 1gb
    // $maxSizeThumbnail = 1024 * 10000; // max size thumbnail 10mb
    $destinationVideo = "../assets/uploads/video/";
    // $destinationThumbnail = "../assets/uploads/thumbs/";
    $arrayTypeVideo = ['video/mp4' ,'video/x-matroska'];
    // $arrayTypeThumbnail = ['image/jpg' ,'image/jpeg', 'image/png'];
    $id_video = $_POST['id_video'];
    $id_tmdb = $_POST['id_tmdb'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $rating = $_POST['rating'];
    $poster = $_POST['poster'];
    $thumbnail = $_POST['thumbnail'];

    if (strlen($_FILES['video']['name']) == 0) {
        $nameVideo = $_POST['video'];
    }else{
        $nameVideo = $_FILES['video']['name'];
        $tmpVideo = $_FILES['video']['tmp_name'];
        $size = $_FILES['video']['size'];
        $type = $_FILES['video']['type'];
        // genrate name file
        $nameVideo = genrateName($nameVideo, 'video');
        if (!in_array($type, $arrayTypeVideo)) {
            fair('Make sure you choose the video file', 'Bad Request', 400);
        }

        if ($size > $maxSizeVideo) {
            fair('Maxsimum file video is 1 Gb', 'Bad Request', 400);
        }

        move_uploaded_file($tmpVideo, $destinationVideo . $nameVideo);
    }
    

    // if (strlen($_FILES['thumbnail']['name']) == 0) {
    //     $thumbnail = $_POST['thumbnail'];
    // }else{
    //     $thumbnail = $_FILES['thumbnail']['name'];
    //     $thumbnail = genrateName($thumbnail, 'thumbnail');
    //     $tmpThumbnail = $_FILES['thumbnail']['tmp_name'];
    //     $thumbnail_size = $_FILES['thumbnail']['size'];
    //     $thumbnail_type = $_FILES['thumbnail']['type'];
    //     if (!in_array($thumbnail_type, $arrayTypeThumbnail)) {
    //         fair('Make sure you choose the thumbnail file is image exstansion', 'Bad Request', 400);
    //     }
    //     if ($thumbnail_size > $maxSizeThumbnail) {
    //         fair('Maxsimum file thumbnail is 10 mb', 'Bad Request', 400);
    //     }

    //     move_uploaded_file($tmpThumbnail, $destinationThumbnail . $thumbnail);

    // }

    
    // insert tags if there are new ones
    insertTags($tags);

    $escapedTitle = mysqli_real_escape_string($conn, $title);
    $escapedDescription = mysqli_real_escape_string($conn, $description);
    $escapedThumbnail = mysqli_real_escape_string($conn, $thumbnail);
    $escapedPoster = mysqli_real_escape_string($conn, $poster);
    $escapedNameVideo = mysqli_real_escape_string($conn, $nameVideo);

    // insert videos
    $sqlQuerInsertVideo = mysqli_query($conn, "UPDATE videos SET title = '$escapedTitle', description = '$escapedDescription', thumbnail = '$escapedThumbnail', link = '$escapedNameVideo', poster = '$escapedPoster', rating = '$rating' WHERE id_video = '$id_video'");
    
    if (mysqli_affected_rows($conn) < 0) {
        fair('Something wrong, try again!', 'Internal Server Error', 500);
    }

    getDataTags();
    $tagOld = getDataTagOldVideo($id_video);

    updateVideoHaveTag($tags, $tagOld, $id_video);

    fair('Your video has been updated', null, 200);
    // var_dump($_FILES);
?>