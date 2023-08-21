
<div>
    <aside>
        <div>
            <div class="profile">
                <img src="<?= $user_info['image']?>" alt="">
                <span><?= $user_info['name']?></span>
                <a href="settings.php">View Profile</a>
            </div>
            <div class="menu-dashboard">
                <a id="menu-link" href="dashboard.php">
                    <div class="dashboard selected-menu">
                        <img src="./assets/icons/dash-a.svg" alt="">
                            Dashboard
                    </div>
                </a>
                <a id="menu-link" href="list_video.php">
                    <div class="list-video">
                        <img src="./assets/icons/playlist-b.svg" alt="">
                        List video
                    </div>
                </a>
            </div>
        </div>
        <div onclick="logout()" class="logout">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#1e4267" width="24" height="24" viewBox="0 0 24 24"><path d="M16 9v-4l8 7-8 7v-4h-8v-6h8zm-2 10v-.083c-1.178.685-2.542 1.083-4 1.083-4.411 0-8-3.589-8-8s3.589-8 8-8c1.458 0 2.822.398 4 1.083v-2.245c-1.226-.536-2.577-.838-4-.838-5.522 0-10 4.477-10 10s4.478 10 10 10c1.423 0 2.774-.302 4-.838v-2.162z"/></svg>
            Logout
        </div>
    </aside>
</div>