<?php
session_start();
require 'koneksi.php';

require './lib/cookie.php'


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/home2.css">
  <link rel="stylesheet" href="assets/css/settings.css">
  <link rel="stylesheet" href="assets/css/components/pop_up_add.css">
  <link rel="stylesheet" href="assets/css/components/pagination.css">
  <link rel="stylesheet" href="assets/css/components/sidebar2.css">
</head>

<body>

  <main>
    <!-- sidebar left -->
    <?php require './components/sidebar2.php'?>
    <section class="content">

      <div class="content-setting">
            <h2>Account Setting</h2>
            <form method="post" class="update-user-info" action="" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?= $user_info['id_user']?>">
            <div class="content-information">
                    <div class="left-information">
                            <h3>Public Profile</h3>
                            <div class="data-row">
                                <div class="data-col">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" value="<?= $user_info['name']?>">
                                </div>
                                <div class="data-col">
                                    <label for="email">Email</label>
                                    <input type="text" disabled id="email" name="email" value="<?= $user_info['email']?>">
                                </div>
                            </div>
                            <div class="data-row">
                                <div class="data-col">
                                    <label for="locale">Location</label>
                                    <input type="text" id="locale" name="locale" value="<?= $user_info['locale']?>">
                                </div>
                                <div class="data-col">
                                    <label for="tagline">Tagline</label>
                                    <input type="text" id="tagline" name="tagline" value="<?= $user_info['tagline']?>">
                                </div>
                            </div>
                            <hr>
                            <h3>Social Profile</h3>
                            <div class="data-row">
                                <div class="data-col">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" id="instagram" name="instagram" value="<?= $user_info['instagram']?>">
                                </div>
                                <div class="data-col">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" id="facebook" name="facebook" value="<?= $user_info['facebook']?>">
                                </div>
                            </div>
                            <input class="btn-submit-setting" name="btn_submit" type="submit" style="color: white;" value="Save Setting">
                    </div>
                    <div class="right-information">
                        <div class="container-image-user">
                            <img class="image-user" src="<?= $user_info['image']?>" alt="">
                        </div>
                        <label class="btn-up-image" for="up-image" style="color: white;">
                            Change Picture
                        </label>
                        <input type="file" name="image" class="up-image" id="up-image">
                        <input type="hidden" name="image-hidden" class="up-image-hidden" id="up-image-hidden" value="<?= $user_info['image']?>">
                    </div>
                </div>
            </form>
        </div>

      <?php require './components/pop_up_add.php'?>

    </section>
    <!-- sidebar right -->
    <?php require './components/sidebar-right2.php'?>
  </main>

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pell"></script>
    <script src="./assets/js/navbar/menu_setting.js"></script>
    <script src="./assets/js/navbar/pop_up_add.js"></script>
    <script src="./assets/js/navbar/logout.js"></script>
    <script src="./assets/js/sidebar.js"></script>
    <script>

        

        $(".js-selected-tags").select2({
            placeholder: 'Choose tags',
            tags: true,
            tokenSeparators: [',', ' ']
        });

        function get_tag_user_selected(allTags, id_video) {
            $.ajax({
                type: "GET",
                url: `./lib/get_tags.php?id_video=${id_video}`,
                contentType: false,
                cache: false,
                timeout: 600000,
            }).done(data => {
                console.log(data);
                // data.data.forEach(el => {
                $('.js-selected-tags').val(data.data).trigger('change')
                // })
            }).fail(err => {
                console.log(err);
            })
        }

        $('.actions-user div:last-child').click(function(){
            let container = this.parentNode.parentNode.parentNode;
            let id_video = container.querySelector('.id_video').value
            // let title = container.querySelector('.title-td').childNodes[0].textContent
            Swal.fire({
                text: 'Do you want to delete this video?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then(result => {
                if (result.isConfirmed) {
                    // do it ajax delete the vidio
                    $.ajax({
                        url: './lib/delete_video.php?id='+id_video,
                        type: 'delete',
                    }).done(data => {
                        Swal.fire({
                            text: data.message,
                            icon: 'success'
                        })
                        console.log(data);
                    }).fail(err => {
                        // Swal.fire({
                        //     text: data.message,
                        //     icon: 'error'
                        // })
                        console.log(err);
                    })
                }
            })
        })

        $('.actions-user div:first-child').click(function(){
            let container = this.parentNode.parentNode.parentNode;
            let video = container.querySelector('.video').value
            let thumbnail = container.querySelector('.thumbnail').src
            let poster = container.querySelector('.poster').src
            let title = container.querySelector('.title-td').childNodes[0].textContent
            let description = container.querySelector('.description').value

            container_pop_up.classList.toggle('invisible-pop-up')
            // console.log(video, thumbnail, title, description);
            $('.title').val(title)
            tempDesc = description
            $('#choice-video-hidden').val(video)
            $('#choice-thumbnail-hidden').val(thumbnail)
            $('.preview img').attr('src', thumbnail)
            $('.video video').attr('src',`assets/uploads/video/${video}`)
            $('.video video').attr('poster',`assets/uploads/thumbs/${thumbnail}`)
            $('.video label .upload').css('display', 'block')
            $('.video label .upload').css('opacity', '21%')
            $('.video video').css('display', 'block')
            $('.video h5').css('display', 'none')
            $('.pell-content').html(description)
            $('.preview h6').css('display', 'none')
            $('.preview img').css('display', 'block')
            $('.preview img').attr('src', `${thumbnail}`)
            
            $('.preview-poster h6').css('display', 'none')
            $('.preview-poster img').css('display', 'block')
            $('.preview-poster img').attr('src', `${poster}`)
            
            $('.rating').val($("#rating").val())
            $('.tmdb-id').val($("#id_tmdb").val())
            $("#editor .pell-content").html($("#description").val())

            let allTags = []
            
            let h = document.querySelectorAll('.js-selected-tags option')
            h.forEach(el => {
                allTags.push(el.innerHTML)
            })
            let id_video = container.querySelector('.id_video').value
            console.log(id_video);
            // create input element for just only in update session on pop up add
            let inputVideo = document.createElement("input")
            inputVideo.type = 'hidden'
            inputVideo.value = id_video
            inputVideo.name = 'id_video'
            inputVideo.className = 'id_video_update'
            let containerFormUpload = document.querySelector('.fileUploadVideoForm') 
            containerFormUpload.appendChild(inputVideo)
            // get tag user selected
            get_tag_user_selected(allTags, id_video)
        })

        $('.fileUploadVideoForm .btn-close').click(()=> {
            let id_video_update = document.querySelector('.fileUploadVideoForm .id_video_update'); 
            id_video_update.remove()
        })

        let lastFileVideo = '';
        $('#choice-video').change(function(){
            // console.log($('#choice-video').val());
            if ($('#choice-video').val() != '' || $('#choice-video').val() != lastFileVideo) {
                // $('.video label svg:first-child').css('display', 'block')
                // $('.video label svg:last-child').css('display', 'none')
                $('.video h5').css('display', 'none')
                $('.video video').css('display', 'block')

                const [file] = $('#choice-video')[0].files
                console.log(URL.createObjectURL(file));
                if ($('#choice-thumbnail') != '') {
                    $('.video video').attr('src', URL.createObjectURL(file))
                }
                // move upload the video to filedirektory
                // move_upload_video();
            }
            lastFileVideo = $('#choice-video').val()
        })

        $('#choice-thumbnail').change(function(){
            $('.preview img').css('display', 'block')
            $('.preview h6').css('display', 'none')
            const [file] = $('#choice-thumbnail')[0].files
            // console.log(URL.createObjectURL(file));
            if ($('#choice-thumbnail') != '') {
                $('.preview img').attr('src', URL.createObjectURL(file))
            }
        })

        // function move_upload_video() {

        // }

        $(".update-user-info").submit(function (e) {
            e.preventDefault()

            // Get form
            var form = $('.update-user-info')[0];
            // console.log(form);

            // Create an FormData object 
            var data = new FormData(form);

            $(".btn-submit-setting").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "./lib/update_user.php",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 60000
                }).done(function (data) {
                        // $(".btn-submit-setting").css("opacity", '1');
                        // $(".btn-submit-setting").css("cursor", 'pointer');
                        // $(".btn-submit-setting").prop("disabled", false);
                        // // $('.confirmation .progress').addClass('hideProgress')
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 1500
                        })
                        // location.reload(true);
                        // console.log("SUCCESS : ", data);

                }).fail(function (e) {
                    // $("#result").text(e.responseText);
                    Swal.fire({
                            position: 'center',
                            icon: 'error',
                            text: 'Something wrong, check your connection!',
                            showConfirmButton: true,
                            timer: 3000
                    })
                    console.log("ERROR : ", e);
                    $(".btn-submit-setting").prop("disabled", false);
                })
        })
    </script>

</body>

</html>