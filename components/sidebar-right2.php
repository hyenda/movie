<aside class="sidebar-right">
      <div class="sub-menu">
        <!-- profile -->
        <button class="add">
          <img src="./assets/icons/add.svg" alt="add icons" width="31px">
        </button>

        <!-- profile -->
        <?php if($mode == 'user'):?>
            <button class="profile" style="overflow: hidden;">
              <img style="width: 100%; height: 100%; object-fit: cover;" src="<?= $user_info['image']?>" alt="">
            </button>
          <?php else:?>
            <a href="login.php">
                  <span class="login" style="
                          border: 2px solid white;
                          padding: 3px 20px;
                          border-radius: 10px;
                      ">
                      Login
                  </span>
            </a>
          <?php endif?>
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
      </div>

      <!-- people also like -->
      <div class="people-like d-none">
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