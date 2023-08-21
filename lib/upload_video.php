<?php

    require '../koneksi.php';
    $dataTags = [];

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


    if (isset($_FILES['video'])) {
        // $thumbnail = 'thumbnail.jpg';
        // $thumbnail_size = 1;
        // $thumbnail_type = 'image/jpg';
        // if (isset($_FILES['thumbnail'])) {
        //     $thumbnail = $_FILES['thumbnail']['name'];
        //     $tmpThumbnail = $_FILES['thumbnail']['tmp_name'];
        //     $thumbnail_size = $_FILES['thumbnail']['size'];
        //     $thumbnail_type = $_FILES['thumbnail']['type'];
        // }

        $arrayTypeVideo = ['video/mp4' ,'video/x-matroska'];
        // $arrayTypeThumbnail = ['image/jpg' ,'image/jpeg', 'image/png'];
        
        // kita ambil data form input
        $id_user = $_POST['id_user'];
        $id_tmdb = $_POST['id_tmdb'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $tags = $_POST['tags'];
        $rating = $_POST['rating'];
        $thumbnail = $_POST['thumbnail'];
        $poster = $_POST['poster'];
        $nameVideo = $_FILES['video']['name'];
        $tmpVideo = $_FILES['video']['tmp_name'];

        $maxSizeVideo = 1024 * 1000000; // max size video 1gb
        // $maxSizeThumbnail = 1024 * 10000; // max size thumbnail 10mb
        $size = $_FILES['video']['size'];
        $type = $_FILES['video']['type'];
        $destinationVideo = "../assets/uploads/video/";
        // $destinationThumbnail = "../assets/uploads/thumbs/";

        // var_dump($nameVideo, $type, $size, $maxSizeVideo, $thumbnail_type, $thumbnail_size);
        
        // check type file video and thumbnail
        
        if (!in_array($type, $arrayTypeVideo)) {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'Make sure you choose the video file', 'code' => 400)));
        }
        
        if ($size > $maxSizeVideo) {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'Maxsimum file video is 1 Gb', 'code' => 400)));
        }

        // genrate name file
        $nameVideo = genrateName($nameVideo, 'video');
        // $thumbnail = genrateName($thumbnail, 'thumbnail');
        
        // insert tags
        
        insertTags($tags);
        
         try {
            // insert videos
            $escapedTitle = mysqli_real_escape_string($conn, $title);
            $escapedDescription = mysqli_real_escape_string($conn, $description);
            $escapedThumbnail = mysqli_real_escape_string($conn, $thumbnail);
            $escapedPoster = mysqli_real_escape_string($conn, $poster);
            $escapedNameVideo = mysqli_real_escape_string($conn, $nameVideo);
            
            // kita melakukan save data ke database sesuai dengan data2 di form input
            $sqlQuerInsertVideo = mysqli_query($conn, "INSERT INTO videos VALUES(NULL, '$id_user', '$id_tmdb', '$escapedTitle', '$escapedDescription', '$escapedThumbnail', '$escapedPoster', '$rating', '$escapedNameVideo', 0, 0, NULL)");
            
         } catch (\Throwable $th) {
            
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'Something wrong, try again!', 'code' => 500)));
         }
        $id_video = getLastIdInsert();
        
        if (mysqli_affected_rows($conn) < 0) {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'Something wrong, try again!', 'code' => 500)));
        }

        getDataTags();

        $dataIdTagVideos = getIdTagVideos($tags);

        // insert video tags
        foreach ($dataIdTagVideos as $id_tag) {
            $sqlQuerInsertVideoTag = mysqli_query($conn, "INSERT INTO video_tag VALUES ('', '$id_tag', '$id_video')");
        }

        move_uploaded_file($tmpVideo, $destinationVideo . $nameVideo);

        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Your video has been saved', 'code' => 200)));
        
        // var_dump($_FILES);
        // echo 'okeh';
    }else{
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Please choose your video, before save', 'code' => 400)));
    }
    // var_dump($_FILES);
    

?>