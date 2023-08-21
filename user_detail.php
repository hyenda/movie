<?php
session_start();
require 'koneksi.php';

require './lib/cookie.php';

$id_user = $_GET['id_user'];

$resultDetailUser = mysqli_query($conn, "SELECT * FROM users WHERE id_user = id_user");
$resultDetailUserVideo = mysqli_query($conn, "SELECT * FROM videos WHERE id_user = id_user");
$rowDetailUser = mysqli_fetch_assoc($resultDetailUser);

// pagination configuration
$jumlahDataPerHalaman = 3;
$resultDetailUserVideo = mysqli_query($conn, "SELECT * FROM videos  WHERE videos.id_user = $id_user");
$jumlahData = mysqli_num_rows($resultDetailUserVideo);
$jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
$halamanAktif = isset($_GET['p']) ? $_GET['p'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$resultDetailUserVideo = mysqli_query($conn, "SELECT * FROM videos  WHERE videos.id_user = $id_user LIMIT $awalData, $jumlahDataPerHalaman");



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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Account</title>

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="assets/css/user_detail.css">
    <link rel="stylesheet" href="assets/css/components/header.css">
    <link rel="stylesheet" href="assets/css/components/pagination.css">
    
</head>
<body>
    <?php require 'components/header.php';?>
    
    <div class="container">
        
        <div class="profile">
            <div class="image-container">
                <img src="<?= $rowDetailUser['image']?>" alt="">
            </div>
            <h2><?= $rowDetailUser['name']?></h2>
            <i><?= $rowDetailUser['tagline']?></i>
            <div class="btn-follow">
                <span>Follow</span>
                <!-- <span> -->
                <!-- </span> -->
            </div>
        </div>
        
        <div class="border-list-video">
            <div class="container-video">
                <h2 class="heading-user">List video from <?= $rowDetailUser['name']?></h2>
                <div class="list-video">
                <?php while($row = mysqli_fetch_assoc($resultDetailUserVideo)):?>
                <div class="card">
                    <a href="detail_video.php?video=<?= $row['id_video']?>">
                        <div class="card-poster">
                            <img src="assets/uploads/thumbs/<?= $row['thumbnail']?>" alt="">
                        </div>
                        <div class="btn-play btn-play-invisible">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24" viewBox="0 0 24 24"><path d="M3 22v-20l18 10-18 10z"/></svg>
                        </div>
                    </a>
                    
                    <div class="desc">
                        <div class="desc-1">
                            <a href="detail_video.php?video=<?= $row['id_video']?>">
                                <h3><?= limitText($row['title'], 'title')?></h3>
                            </a>
                            <a href="user_detail.php?id_user=<?= $row['id_user']?>">
                                <div class="profile-user">
                                    <img src="<?= $rowDetailUser['image']?>" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="desc-video">
                            <?= $row['description']?>
                        </div>
                        <div class="view-count">
                            <span><?= $row['view']?> x views</span> 
                            <span>&middot;</span>
                            <span><?= convertDate($row['timestamp'])?></span>
                        </div>
                    </div>
                </div>
                <?php endwhile?>
                </div>
            </div>
            
            <!-- pagination -->
            <div class="pagination">
                <?php for ($i=1; $i <= $jumlahHalaman; $i++):?>
                <!-- <div> -->
                    <a href="user_detail.php?id_user=<?=$id_user?>&p=<?=$i?>">
                        <div class="
                        <?php if($i == $halamanAktif){
                            echo 'pagination-selected';
                            }else{
                                echo '';
                            }; ?>
                        ">
                            <?= $i?>
                        </div>
                    </a>
                <!-- </div> -->
                <?php endfor?>
            </div>
            <!-- /pagination -->

        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pell"></script>
    <script src="./assets/js/navbar/menu_setting.js"></script>
    <!-- <script src="./assets/js/navbar/pop_up_add.js"></script> -->
    <script>
        let mode_user = document.querySelector('.mode-user')
        let cards = document.querySelectorAll('.card')

        cards.forEach(function(card){
            let img = card.querySelector('.card-poster img')
            let btnPlay = card.querySelector('.btn-play')
            img.addEventListener('mouseover', function(e){
                img.classList.remove('card-blur-out')
                img.classList.add('card-blur-in')
                
                btnPlay.classList.remove('btn-play-invisible')
                btnPlay.classList.add('btn-play-visible')
            })
            img.addEventListener('mouseout', function(e){
                img.classList.remove('card-blur-in')
                img.classList.add('card-blur-out')

                btnPlay.classList.remove('btn-play-visible')
                btnPlay.classList.add('btn-play-invisible')
            })

            btnPlay.addEventListener('mouseover', function(e){
                img.classList.remove('card-blur-out')
                img.classList.add('card-blur-in')
                
                btnPlay.classList.remove('btn-play-invisible')
                btnPlay.classList.add('btn-play-visible')
            })
            btnPlay.addEventListener('mouseout', function(e){
                img.classList.remove('card-blur-in')
                img.classList.add('card-blur-out')

                btnPlay.classList.remove('btn-play-visible')
                btnPlay.classList.add('btn-play-invisible')
            })
        });
    </script>
    <script src="./assets/js/navbar/logout.js"></script>
</body>
</html>