<?php
session_start();
require 'koneksi.php';

require './lib/cookie.php';

$errorVideo = false;

if (isset($_GET['video'])) {
    $id_video = $_GET['video'];
    $resultVideoDetail = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
    INNER JOIN users ON videos.id_user = users.id_user WHERE videos.id_video = $id_video");
    $rowVideoDetail = mysqli_fetch_assoc($resultVideoDetail);

    $resultTags = mysqli_query($conn, "SELECT name_tag FROM video_tag 
    INNER JOIN tags ON video_tag.id_tag = tags.id_tag");

    $id_tmdb = $rowVideoDetail['id_tmdb'];
    
    // ambil data casts
    require_once('vendor/autoload.php');

    $client = new \GuzzleHttp\Client();

    $response = $client->request('GET', "https://api.themoviedb.org/3/movie/$id_tmdb/credits", [
    'headers' => [
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5OGI5NTY0ZjAxOGQzMTczNGVmNjYwZmQ3NWVmNGMxMCIsInN1YiI6IjVlYzI2MTI2Y2RmMmU2MDAyMjUwODQ5MCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zxY2_YSK_ngsYZXLawaltLEHO3Pgi4k1KnblEGFmEHc',
        'accept' => 'application/json',
    ],
    ]);

    $response = json_decode($response->getBody(), true);
} else {
    $errorVideo = true;
}

$resultVideoList = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
INNER JOIN users ON videos.id_user = users.id_user");

function convertDate($timestamp){
    return date('d:M:Y', strtotime($timestamp));
}

function limitText($string, $type){
    $limit = 20;
    if ($type == 'title') {
        $limit = 20;
    } 
    if (strlen($string) > $limit) {

        // truncate string
        $stringCut = substr($string, 0, $limit);
        $endPoint = strrpos($stringCut, ' ');
    
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '...';
    }
    // echo $string;
    return $string;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/home2.css">
    <link rel="stylesheet" href="./assets/css/preview.css">
    <link rel="stylesheet" href="assets/css/components/sidebar2.css">
</head>

<body>

    <main>
        <!-- sidebar left -->
        <?php require './components/sidebar2.php'?>
        <section class="content">

            <!-- banner  -->
            <section class="banner">
                <img src="<?= $rowVideoDetail['thumbnail']?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                <!-- metadata -->
                <div class="metadata">
                    <a href="detail_video.php?video=<?= $rowVideoDetail['id_video']?>" class="left">
                        <img src="./assets/icons/play.svg" alt="play icons">
                        <span>TRAILER</span>
                    </a>
                </div>
            </section>

            <div class="description">
                <div class="head-movie">
                    <!-- left -->
                    <div class="thumbnail">
                        <img src="<?= $rowVideoDetail['poster']?>" alt="poster" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <!-- right -->
                    <div class="right">
                        <div>
                            <h3><?= limitText($rowVideoDetail['title'], 'title')?></h3>

                            <!-- categories -->
                            <div class="list-cetegory">
                                <span class="badge">Action</span>
                            </div>
                        </div>

                        <div>
                            <a href="detail_video.php?video=<?= $rowVideoDetail['id_video']?>" class="btn-watch">
                                <img src="./assets/icons/play-white.svg" alt="play icons">
                                <span>Watch</span>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- storyline and cast -->
                <div class="movie-content">
                    <div class="storyline">
                        <h4>Storyline</h4>
                        <div class="storyline-content">
                            <?= $rowVideoDetail['description']?>
                        </div>
                    </div>

                    <div class="casts">
                        <h4>Casts</h4>
                        <?php for($r = 0; $r <= count($response['cast']); $r++):?>
                            <?php 
                                if ($r >= 3) {
                                    break;
                                }
                            ?>
                        <div class="card-cast">
                            <div class="avatar" style="overflow: hidden; border: 1px solid white;">
                                <img src="http://image.tmdb.org/t/p/w45<?= $response['cast'][$r]['profile_path']?>" alt="profile" style="width: 100; height: 100; object-fit: cover;">
                            </div>
                            <div class="as">
                                <span class="text-blue"><?= $response['cast'][$r]['name']?></span>
                                <span class="text-blue"><?= $response['cast'][$r]['character']?></span>
                            </div>
                        </div>
                        <?php endfor;?>
                    </div>
                </div>
            </div>

        </section>
        <!-- sidebar right -->
        <?php require './components/sidebar-right.php'?>
    </main>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pell"></script>
    <script src="./assets/js/navbar/menu_setting.js"></script>
    <script src="./assets/js/navbar/logout.js"></script>

</body>

</html>