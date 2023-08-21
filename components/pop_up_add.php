<?php
require 'koneksi.php';

$getTags = mysqli_query($conn, "SELECT * FROM tags");

?>

<div class="container-pop-up invisible-pop-up">
    <div class="pop-up-add">
        <div class="imdb-form">
            <div class="container-form">
                <form id="imdb-form">
                    <input type="text" class="tmdb-id" name="id_tmdb" placeholder="Type TMDB Id Movie" required>
                </form>
            </div>
        </div>

        <form id="fileUploadVideoForm" method="post" enctype="multipart/form-data" class="fileUploadVideoForm">
            <input type="hidden" name="id_user" value="<?= $user_info['id_user']?>">
            <div class="container-form">
                <div class="left">
                    <div class="video">
                        <video width="100%" src="" poster="" controls></video>

                        <label for="choice-video">
                            <svg class="upload" xmlns="http://www.w3.org/2000/svg" fill="white" width="150" viewBox="0 0 24 24"><path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z"/></svg>
                        </label>
                        <input name="video" type="file" id="choice-video">
                        <input name="video" type="hidden" id="choice-video-hidden">
                        <h5>Drag and drop the video file you want to upload</h5>
                    </div>
                    <div class="container-thumbnail">
                        <div class="thumbnail">
                            <label for="choice-thumbnail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="40" viewBox="0 0 24 24"><path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z"/></svg>
                            </label>
                            <input name="thumbnail" type="file" id="choice-thumbnail">
                            <input name="thumbnail" type="hidden" id="choice-thumbnail-hidden">
                            <p>Tambah thumbnail</p>
                        </div>
                        <div class="preview">
                            <img src="" alt="" id="previewBackdrop">
                            <h6>Preview thumb</h6>
                        </div>
                        <div class="thumbnail">
                            <label for="choice-thumbnail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="40" viewBox="0 0 24 24"><path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z"/></svg>
                            </label>
                            <input name="thumbnail" type="file" id="choice-thumbnail">
                            <input name="poster" type="hidden" id="choice-poster-hidden">
                            <p>Tambah poster</p>
                        </div>
                        <div class="preview-poster">
                            <img src="" alt="">
                            <h6>Preview poster</h6>
                        </div>
                    </div>
                    <div class="confirmation">
                        <input type="submit" class="btn-submit" value="SAVE">
                        <button type="button" class="btn-close">CLOSE</button>
                        <div class="progress hideProgress">
                            <div class="progress-bar"></div>
                            <span>0%</span>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <input type="text" class="title" name="title" placeholder="Write yout video title" required>
                    <input type="text" class="rating" name="rating" placeholder="Rating" required>
                    <select name="tags[]" class="js-selected-tags" multiple="multiple" style="width: 104%;" required>
                        <?php while ($row = mysqli_fetch_assoc($getTags)):?>
                            <option value="<?= $row['name_tag']?>"><?= $row['name_tag']?></option>
                        <?php endwhile?>
                    </select>
                    <div id="editor" class="pell"></div>
                </div>
            </div>
        </form>
    </div>
</div>