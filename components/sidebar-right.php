<?php 

$people_also_like = mysqli_query($conn, "SELECT videos.*, users.name AS author, users.id_user AS id_user, users.image AS image FROM `videos` 
INNER JOIN users ON videos.id_user = users.id_user ORDER BY videos.view DESC LIMIT 3");
?>

<aside class="sidebar-right">
      <div class="sub-menu">
        <!-- profile -->

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
          <!-- <img src="https://picsum.photos/400" alt="avatar user"> -->
        <!-- menu-user -->
            <input type="hidden" class="mode-user" value="<?= $mode?>">
            <div class="menu-user">
                <a href="dashboard.php">
                    <div>
                        Dashboards
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
      <div class="people-like">
        <h4 class="sub-heading">People also like</h4>

        <!-- list card movie -->
        <div class="list-movie-sm">
          <!-- card movie -->
          <?php while($row = mysqli_fetch_assoc($people_also_like)):?>
            <a href="preview.php?video=<?= $row['id_video']?>" class="movie-item-sm">
              <!-- movie-image -->
              <div href="#" class="movie-image-sm">
                <img class="poster-sm" src="<?= $row['poster']?>" alt="poster">
              </div>

              <!-- movie desc -->
              <div class="movie-desc-sm">
                <span>
                  <h5><?= $row['title']?></h5>
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
                  <span class="rating"><?= $row['rating']?></span>
                </span>
              </div>
            </a>
          <?php endwhile?>
        </div>

        <a href="#" class="btn-primary mt-2">See more</a>
      </div>
    </aside>