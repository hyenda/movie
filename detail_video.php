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
    <link rel="stylesheet" href="assets/css/detail_video.css">
    <link rel="stylesheet" href="assets/css/components/sidebar2.css">
</head>

<body>

    <main>
        <!-- sidebar left -->
        <?php require './components/sidebar2.php'?>
        <div class="container">
            <div class="video-container">
                <video  src="assets/uploads/video/<?= $rowVideoDetail['link']?>" poster="<?= $rowVideoDetail['thumbnail']?>" controls></video>
                <div class="video-title">
                    <h3><?= limitText($rowVideoDetail['title'], 'title')?></h3>
                </div>
                <div class="view-detail">
                    <div class="view-left">
                        <div id="view-count">
                            <span><?= $rowVideoDetail['view']?></span>
                            <span>
                                    x views
                            </span>
                        </div> 
                        <span>&middot;</span>
                        <span><?= convertDate($rowVideoDetail['timestamp'])?></span>
                    </div>

                    <div class="view-right">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944z"/></svg> -->
                        <!-- <button class="btn-follow" type="button">follow</button> -->
                        <a href="user_detail.php?id_user=<?=$rowVideoDetail['id_user']?>" class="user-profile">
                            <img src="<?= $rowVideoDetail['image']?>" alt="">
                        </a>
                    </div>
                </div>
                <hr>
                <div class="desc">
                    <?= $rowVideoDetail['description']?>
                </div>
            </div>
            <div class="list-video">
                <?php 
                    while($rowVideoList = mysqli_fetch_assoc($resultVideoList)):?> 
                        <a href="detail_video.php?video=<?= $rowVideoList['id_video']?>">
                            <div class="cardVideo">
                                <video  src="assets/uploads/video/<?= $rowVideoList['link']?>" poster="<?= $rowVideoList['thumbnail']?>" muted></video>
                                
                                <div class="desc" style="width: 8rem;">
                                    <h4 class="title"><?= $rowVideoList['title']?></h4>
                                    <div class="view-count">
                                        <span><?= $rowVideoList['view']?> x view</span> 
                                        <span>&middot;</span>
                                        <span><?= convertDate($rowVideoList['timestamp'])?></span>
                                    </div> 
                                </div>
                            </div>
                        </a>
                        <hr>
                <?php endwhile?>
                
            </div>
        </div>
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