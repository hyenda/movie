<?php
session_start();
require 'koneksi.php';

require './lib/cookie.php';

$tranding_movie = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
INNER JOIN users ON videos.id_user = users.id_user ORDER BY videos.rating DESC LIMIT 4");

$recently_add = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
INNER JOIN users ON videos.id_user = users.id_user ORDER BY videos.timestamp DESC");

$banner = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` INNER JOIN users ON videos.id_user = users.id_user ORDER BY videos.timestamp DESC LIMIT 4");


// $resultVideo = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
// INNER JOIN users ON videos.id_user = users.id_user");

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
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/home2.css">
    <link rel="stylesheet" href="assets/css/components/sidebar2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.2.0/css/glide.core.css" integrity="sha512-ShLuspGzRsTiMlQ2Rg0e+atjy/gVQr3oYKnKmQkHQ6sxcnDAEOtOaPz2rRmeygV2CtnwUawDyHkGgH4zUbP3Hw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.2.0/css/glide.theme.css" integrity="sha512-Cn5/xnOLSKjVpNCsJZCtgQhxp00FcFnlRwgbSG7WGFq1BVvyG+LoOarjXAq//8Vstyu0Na9wvEKLWR67/wAy3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <main>
        <!-- sidebar left -->
        <?php require './components/sidebar2.php'?>
        <section class="content">

            <!-- head-content -->
            <div class="head-content">
                <div class="sub-head">
                    <a href="#">
                        <h4>TV Series</h4>
                    </a>
                    <a href="#">
                        <h4 class="active">Movies</h4>
                    </a>
                    <a href="#">
                        <h4>Animes</h4>
                    </a>
                </div>
                <!-- search -->
                <form action="">
                    <div class="form-input">
                        <div class="icon-search">
                            <img src="./assets/icons/search-2.svg" alt="search icons">
                        </div>
                        <input type="text" class="search" id="search" name="search" placeholder="search">
                    </div>
                </form>
            </div>

            <!-- banner  -->
            <div class="glide hero banner">
                <div class="glide__track" style="height: 100%; overflow: hidden;" data-glide-el="track">
                <ul class="glide__slides" style="height: 100%; margin-top: 0;">
                    <?php while($row = mysqli_fetch_assoc($banner)):?>
                        <li class="glide__slide" style="overflow: hidden;">
                            <a href="preview.php?video=<?= $row['id_video']?>">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="<?= $row['thumbnail']?>" alt="">
                            </a>
                        </li>
                    <?php endwhile?>
                </ul>
                </div>
            </div>
            <!-- <section class="banner">
            </section> -->

            <!-- Populer movie -->
            <section class="tranding">
                <div class="head">
                    <h2 class="sub-heading">Tranding Movie 🔥</h2>
                    <div class="arrows">
                        <button class="left">
                            <img src="./assets/icons/arrow-left.svg" alt="">
                        </button>
                        <button class="right">
                            <img src="./assets/icons/arrow-right.svg" alt="">
                        </button>
                    </div>
                </div>

                <!-- list tranding movie -->
                <div class="list-tranding">
                    <?php while($row = mysqli_fetch_assoc($tranding_movie)):?>
                        <a href="preview.php?video=<?= $row['id_video']?>" class="tranding-item">
                            <!-- image -->
                            <div class="poster">
                                <img src="<?= $row['poster']?>" alt="poster">
                            </div>
                            <div class="btn-play btn-play-invisible">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24" viewBox="0 0 24 24"><path d="M3 22v-20l18 10-18 10z"/></svg>
                            </div>
                            
                            <div class="desc-section">
                                <h4><?= $row['title']?></h4>
                                <?php
                                    $ratingCount = $row['rating']; // Jumlah rating yang diberikan
                                    echo "<span>❤ $ratingCount</span>";
                                ?>
                            </div>
                        </a>
                    <?php endwhile?>
                </div>
            </section>

            <!-- recently add -->
            <section class="tranding">
                <div class="head">
                    <h2 class="sub-heading">Recently Add</h2>
                </div>

                <!-- list tranding movie -->
                <div class="list-tranding">
                    <?php while($row = mysqli_fetch_assoc($recently_add)):?>
                        <a href="preview.php?video=<?= $row['id_video']?>" class="tranding-item">
                            <!-- image -->
                            <div class="poster">
                                <img src="<?= $row['poster']?>" alt="poster">
                            </div>
                            <div class="btn-play btn-play-invisible">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="24" height="24" viewBox="0 0 24 24"><path d="M3 22v-20l18 10-18 10z"/></svg>
                            </div>
                            
                            <div class="desc-section">
                                <h4><?= $row['title']?></h4>
                                <?php
                                    $ratingCount = $row['rating']; // Jumlah rating yang diberikan
                                    echo "<span>❤ $ratingCount</span>";
                                ?>
                            </div>
                        </a>
                    <?php endwhile?>
                </div>
            </section>

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
    <script>

//home menggunakkan autoply
    var glideHero = new Glide('.hero', {
    type: 'carousel',
    animationDuration: 2000,
    autoplay: 4500,
    focusAt: '1',
    startAt: 1,
    perView: 1, 
    });

    glideHero.mount();
        
        let cards = document.querySelectorAll('.list-tranding .tranding-item')

        cards.forEach(function(card){
            let img = card.querySelector('.poster img')
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
</body>

</html>