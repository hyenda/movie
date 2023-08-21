<?php 
// Mengambil URL yang sedang diakses saat ini
$currentURL = $_SERVER['REQUEST_URI'];

// Mengambil nama file terakhir dari URL
$namaFile = basename(parse_url($currentURL, PHP_URL_PATH));

?> 
 
<aside class="menu">
      <!-- logo -->
      <a href="#" class="logo">
        <img src="./assets/image/logo.png" width="180px" alt="logo">
      </a>

      <!-- menu -->
      <div class="list-menu">
        <span>Menu</span>
        <a href="index.php" class="menu-item <?= $namaFile == 'index.php' ? 'active' : ''?>">
          <div>
            <img src="./assets/icons/home.svg" alt="">
            <span>Home</span>
          </div>
          <span class="pin"></span>
        </a>
        <a href="#" class="menu-item <?= $namaFile == 'discover.php' ? 'active' : ''?>">
          <div>
            <img src="./assets/icons/discovery.svg" alt="">
            <span>Discovery</span>
          </div>
        </a>
        <a href="#" class="menu-item <?= $namaFile == 'watch_latter.php' ? 'active' : ''?>">
          <div>
            <img src="./assets/icons/watch.svg" alt="">
            <span>Watch Later</span>
          </div>
        </a>
      </div>

      <!-- general -->
      <div class="list-menu">
        <span>General</span>
        <a href="dashboard.php" class="menu-item <?= $namaFile == 'dashboard.php' ? 'active' : ''?>">
          <div>
            <img src="./assets/icons/dashboard.svg" alt="">
            <span>Dashboard</span>
          </div>
        </a>
        <a href="list_video.php" class="menu-item <?= $namaFile == 'list_video.php' ? 'active' : ''?>">
          <div>
          <img src="./assets/icons/playlist.svg" alt="">
            <span>List Video</span>
          </div>
        </a>
        <a href="settings.php" class="menu-item <?= $namaFile == 'settings.php' ? 'active' : ''?>">
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

    