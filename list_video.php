<?php
    session_start();
    require 'koneksi.php';

    require './lib/cookie.php';

    // get video data
    $id_user = $user_info['id_user'];

    // pagination configuration
    $jumlahDataPerHalaman = 5;
    $resultVideoData = mysqli_query($conn, "SELECT * FROM videos  WHERE videos.id_user = $id_user");
    $jumlahData = mysqli_num_rows($resultVideoData);
    $jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
    $halamanAktif = isset($_GET['p']) ? $_GET['p'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $resultVideoData = mysqli_query($conn, "SELECT * FROM videos  WHERE videos.id_user = $id_user LIMIT $awalData, $jumlahDataPerHalaman");

    function convertDate($timestamp){
        return date('d:M:Y', strtotime($timestamp));
    }

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
  <link rel="stylesheet" href="assets/css/list_video.css">
  <link rel="stylesheet" href="assets/css/components/pop_up_add.css">
  <link rel="stylesheet" href="assets/css/components/pagination.css">
  <link rel="stylesheet" href="assets/css/components/sidebar2.css">
</head>

<body>

  <main>
    <!-- sidebar left -->
    <?php require './components/sidebar2.php'?>
    <section class="content">

      <h2>List Video</h2>

      <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Video</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>View</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($rowVideoData = mysqli_fetch_assoc($resultVideoData)) :?>
                            <tr class="row-list-video">
                                <td align="center">
                                    <input type="hidden" name="video" class="video" value="<?= $rowVideoData['link']?>">
                                    <input type="hidden" name="id_video" class="id_video" value="<?= $rowVideoData['id_video']?>">
                                    <input type="hidden" name="description" id="description" class="description" value="<?= $rowVideoData['description']?>">
                                    <input type="hidden" name="id_tmdb" id="id_tmdb" value="<?= $rowVideoData['id_tmdb']?>">
                                    <input type="hidden" name="rating" id="rating" value="<?= $rowVideoData['rating']?>">
                                    <!-- <input type="hidden" name="tags" class="tags" value="<?= $rowVideoData['tag']?>">  -->
                                    <div>
                                        <img class="thumbnail" src="<?= $rowVideoData['thumbnail']?>" width="150" alt="thumbnails">
                                        <img class="poster d-none" src="<?= $rowVideoData['poster']?>" width="150" alt="thumbnails">
                                    </div>
                                </td>
                                <td align="center" class="title-td"><?= $rowVideoData['title']?></td>
                                <td align="center"><?= convertDate($rowVideoData['timestamp'])?></td>
                                <td align="center">20</td>
                                <td align="center">
                                    <div class="actions-user">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#5f6d7a" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-5 17l1.006-4.036 3.106 3.105-4.112.931zm5.16-1.879l-3.202-3.202 5.841-5.919 3.201 3.2-5.84 5.921z"/></svg>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#5f6d7a" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>

                <?php require './components/pagintaion.php'?>
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

        $(".fileUploadVideoForm").submit(function (e) {

                //stop submit the form, we will post it manually.
                e.preventDefault();

                // Get form
                var form = $('.fileUploadVideoForm')[0];
                // console.log(form);

                // Create an FormData object 
                var data = new FormData(form);

                data.append("description", tempDesc);
                data.append("id_tmdb", $(".tmdb-id").val());
                // console.log(form);
                

                // disabled the submit button
                $(".btn-submit").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "./lib/update_video.php",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    xhr: function (){
                        let xhr = $.ajaxSettings.xhr();

                        xhr.upload.onprogress = function (e) {
                            // For uploads
                            $('.confirmation .progress').removeClass('hideProgress')

                            $(".btn-submit").css("opacity", '0.4');
                            $(".btn-submit").css("cursor", 'not-allowed');
                            $(".btn-submit").prop("disabled", true);
                            $(".btn-close").css("opacity", '0.4');
                            $(".btn-close").css("cursor", 'not-allowed');
                            $(".btn-close").prop("disabled", true);


                            if (e.lengthComputable) {
                                let percentComplete = e.loaded / e.total
                                $('.confirmation .progress-bar').css({
                                    width: percentComplete * 100 + '%'
                                });

                                $('.confirmation .progress span').html(percentComplete.toString() * 100 + '%')
                                // console.log(percentComplete);
                            }
                        };

                        return xhr
                    }
                }).done(function (data) {
                        $(".btn-submit").css("opacity", '1');
                        $(".btn-submit").css("cursor", 'pointer');
                        $(".btn-submit").prop("disabled", false);
                        $(".btn-close").css("opacity", '1');
                        $(".btn-close").css("cursor", 'pointer');
                        $(".btn-close").prop("disabled", false);

                        $('.confirmation .progress span').html('Upload completed')
                        // // $('.confirmation .progress').addClass('hideProgress')
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 1500
                        })
                        location.reload(true);
                        // console.log(data);
                        

                }).fail(function (e) {
                    // $("#result").text(e.responseText);
                    Swal.fire({
                            position: 'center',
                            icon: 'error',
                            text: 'Something wrong, try again!',
                            showConfirmButton: true,
                            timer: 1500
                    })
                    // console.log("ERROR : ", e);
                    $(".btn-submit").prop("disabled", false);
                })

        });
    </script>

</body>

</html>