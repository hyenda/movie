<!-- header -->
<header>
        <nav>
            <div class="navLeft">
                <a href="index.php">
                    <div class="logo">
                        <img src="assets/image/logo.png" alt="logo" width="75%">
                    </div>
                </a>
            </div>
            
            <div class="navRight">
                <!-- <div class="add"> -->
                <?php if($mode == 'user'):?>
                    <svg class="add" xmlns="http://www.w3.org/2000/svg" width="45" viewBox="0 0 71 45"><g transform="translate(-1556 -46)"><g transform="translate(1556 46)" fill="#f3f9fe" stroke="#313b77" stroke-width="1"><rect width="71" height="45" rx="10" stroke="none"/><rect x="0.5" y="0.5" width="70" height="44" rx="9.5" fill="none"/></g><g transform="translate(1590 54)" fill="#313b77" stroke="#313b77" stroke-width="1"><circle cx="14.5" cy="14.5" r="14.5" stroke="none"/><circle cx="14.5" cy="14.5" r="14" fill="none"/></g><g transform="translate(1563.9 52.144)"><g transform="translate(0.1 -0.144)" fill="#313b77" stroke="#313b77" stroke-width="1"><rect width="8" height="33" rx="4" stroke="none"/><rect x="0.5" y="0.5" width="7" height="32" rx="3.5" fill="none"/></g><g transform="translate(31.477 7.9)"><rect width="5" height="18" rx="2.5" transform="translate(6.623 -0.044)" fill="#f3f9fe"/><rect width="4" height="18" rx="2" transform="translate(18.623 6.956) rotate(90)" fill="#f3f9fe"/></g></g></g></svg>
                <?php endif?>
                <!-- </div> -->
                <?php if($mode == 'user'):?>
                <img src="<?= $user_info['image']?>" alt="">
                <?php else:?>
                <a href="login.php">
                <span class="login" style="
                          border: 2px solid white;
                          padding: 3px 20px;
                          border-radius: 10px;
                          color: whitesmoke;
                      ">
                      Login
                  </span>
                </a>
                <?php endif?>
            </div>
            

            <!-- menu-user -->
            <input type="hidden" class="mode-user" value="<?= $mode?>">
            <div class="menu-user">
                <a href="dashboard.php">
                    <div>
                        Dashboard
                    </div>
                </a>
                <a href="settings.php">
                <div>
                        Settings
                    </div>
                </a>
                <hr>
                <div onclick="logout()">Logout</div>
            </div>
        </nav>
    </header>
<!-- /header -->