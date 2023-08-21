<?php 




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
</head>

<body>

    <main>
        <!-- sidebar left -->
        <aside class="menu">
            <!-- logo -->
            <a href="#" class="logo">
                <img src="./assets/image/logo.png" width="180px" alt="logo">
            </a>

            <!-- menu -->
            <div class="list-menu">
                <span>Menu</span>
                <a href="#" class="menu-item active">
                    <div>
                        <img src="./assets/icons/home.svg" alt="">
                        <span>Home</span>
                    </div>
                    <span class="pin"></span>
                </a>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/discovery.svg" alt="">
                        <span>Discovery</span>
                    </div>
                </a>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/watch.svg" alt="">
                        <span>Watch Later</span>
                    </div>
                </a>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/playlist.svg" alt="">
                        <span>Playlist</span>
                    </div>
                </a>
            </div>

            <!-- general -->
            <div class="list-menu">
                <span>General</span>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/dashboard.svg" alt="">
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/setting.svg" alt="">
                        <span>Setting</span>
                    </div>
                </a>
                <a href="#" class="menu-item">
                    <div>
                        <img src="./assets/icons/logout.svg" alt="">
                        <span>Log Out</span>
                    </div>
                </a>
            </div>

        </aside>
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

            <!-- recently add -->
            <section class="recently-add">
                <!-- list tranding movie -->
                <div class="list-movie">
                    <div class="movie-item"></div>
                    <div class="movie-item"></div>
                    <div class="movie-item"></div>
                    <div class="movie-item"></div>
                </div>
            </section>

        </section>
        <!-- sidebar right -->
        <aside class="sidebar-right">
            <div class="sub-menu">
                <!-- profile -->
                <button class="notif">
                    <img src="./assets/icons/add.svg" alt="add icons" width="31px">
                </button>

                <!-- profile -->
                <button class="profile">
                    <!-- <img src="https://picsum.photos/400" alt="avatar user"> -->
                </button>
            </div>

            <!-- people also like -->
            <div class="people-like">
                <h4 class="sub-heading">People also like</h4>

                <!-- list card movie -->
                <div class="list-movie-sm">
                    <!-- card movie -->
                    <div class="movie-item-sm">
                        <!-- movie-image -->
                        <a href="#" class="movie-image-sm">
                        </a>

                        <!-- movie desc -->
                        <div class="movie-desc-sm">
                            <span>
                                <h5>Jhon Wick</h5>
                                <span class="subtitle">
                                    <span>Action,</span>
                                    <span>Horor</span>
                                </span>
                            </span>

                            <!-- imdb rating -->
                            <span class="imdb-rating">
                                <span class="imdb-badge">
                                    IMDb
                                </span>
                                <span class="rating">4.7</span>
                            </span>
                        </div>
                    </div>
                    <div class="movie-item-sm">
                        <!-- movie-image -->
                        <a href="#" class="movie-image-sm">
                        </a>

                        <!-- movie desc -->
                        <div class="movie-desc-sm">
                            <span>
                                <h5>Jhon Wick</h5>
                                <span class="subtitle">
                                    <span>Action,</span>
                                    <span>Horor</span>
                                </span>
                            </span>

                            <!-- imdb rating -->
                            <span class="imdb-rating">
                                <span class="imdb-badge">
                                    IMDb
                                </span>
                                <span class="rating">4.7</span>
                            </span>
                        </div>
                    </div>
                    <div class="movie-item-sm">
                        <!-- movie-image -->
                        <a href="#" class="movie-image-sm">
                        </a>

                        <!-- movie desc -->
                        <div class="movie-desc-sm">
                            <span>
                                <h5>Jhon Wick</h5>
                                <span class="subtitle">
                                    <span>Action,</span>
                                    <span>Horor</span>
                                </span>
                            </span>

                            <!-- imdb rating -->
                            <span class="imdb-rating">
                                <span class="imdb-badge">
                                    IMDb
                                </span>
                                <span class="rating">4.7</span>
                            </span>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn-primary mt-2">See more</a>
            </div>
        </aside>
    </main>

</body>

</html>