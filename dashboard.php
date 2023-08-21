<?php
    
    session_start();
    require 'koneksi.php';

    require './lib/cookie.php';


    // get video data
    $id_user = $user_info['id_user'];
    $resultVideoData = mysqli_query($conn, "SELECT COUNT(title) AS video_count, SUM(love) AS love, SUM(view) AS view FROM videos  WHERE videos.id_user = $id_user");
    $rowVideoData = mysqli_fetch_assoc($resultVideoData);

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
  <link rel="stylesheet" href="./assets/css/dashboard2.css">
  <link rel="stylesheet" href="assets/css/components/pop_up_add.css">
  <link rel="stylesheet" href="assets/css/components/sidebar2.css">
</head>

<body>

  <main>
    <!-- sidebar left -->
    <?php require './components/sidebar2.php'?>
    <section class="content">

      <h2>Dashboard</h2>

      <div class="card-container">
                <div class="main">
                    <div class="banner-hero">
                        <div>
                            <h2>Hi,</h2>
                            <h2><?= $user_info['name']?></h2>
                        </div>
                        <div>
                            <span>bring out your brilliant idea today, and don't forget to be grateful for what you've got</span>
                        </div>
                    </div>
                    <div class="card">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="100" viewBox="0 0 24 24"><path d="M16 16c0 1.104-.896 2-2 2h-12c-1.104 0-2-.896-2-2v-8c0-1.104.896-2 2-2h12c1.104 0 2 .896 2 2v8zm8-10l-6 4.223v3.554l6 4.223v-12z"/></svg>
                        <span><?= $rowVideoData['video_count']?></span>
                        <span>Total Video</span>
                    </div>
                    <div class="card">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="100" viewBox="0 0 24 24"><path d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3c0-.199.02-.393.057-.581 1.474.541 2.927-.882 2.405-2.371.174-.03.354-.048.538-.048 1.657 0 3 1.344 3 3zm-2.985-7c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 12c-2.761 0-5-2.238-5-5 0-2.761 2.239-5 5-5 2.762 0 5 2.239 5 5 0 2.762-2.238 5-5 5z"/></svg>
                        <span><?= $rowVideoData['view']?></span>
                        <span>Total View</span>
                    </div>
                    <div class="card">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="70" viewBox="0 0 24 24"><path d="M5 22h-5v-12h5v12zm17.615-8.412c-.857-.115-.578-.734.031-.922.521-.16 1.354-.5 1.354-1.51 0-.672-.5-1.562-2.271-1.49-1.228.05-3.666-.198-4.979-.885.906-3.656.688-8.781-1.688-8.781-1.594 0-1.896 1.807-2.375 3.469-1.221 4.242-3.312 6.017-5.687 6.885v10.878c4.382.701 6.345 2.768 10.505 2.768 3.198 0 4.852-1.735 4.852-2.666 0-.335-.272-.573-.96-.626-.811-.062-.734-.812.031-.953 1.268-.234 1.826-.914 1.826-1.543 0-.529-.396-1.022-1.098-1.181-.837-.189-.664-.757.031-.812 1.133-.09 1.688-.764 1.688-1.41 0-.565-.424-1.109-1.26-1.221z"/></svg>
                        <span><?= $rowVideoData['love']?></span>
                        <span>Total Like</span>
                    </div>
                    <a href="#">
                        <div class="card">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="70" viewBox="0 0 24 24"><path d="M10.938 20h-10.938v-20h21v11.462c-.594-.472-1.269-.843-2-1.094v-4.368h-17v12h8.212c.136.713.384 1.386.726 2zm-3.73-4.846l.784-4.775.8 3.438c.08.352.568.392.701.052l.726-1.853.417.848c.066.139.135.229.362.229h1.002v-.728h-.763l-.695-1.465c-.13-.301-.562-.295-.681.011l-.615 1.572-.948-4.196c-.043-.192-.2-.287-.356-.287-.166 0-.333.105-.365.309l-.787 4.847-.803-2.984c-.09-.356-.592-.377-.707-.023l-.597 2.215h-.683v.716h.972c.133 0 .277-.107.314-.235l.339-1.095.863 3.435c.098.387.656.361.72-.031zm16.792 7.432l-2.831-2.832c.522-.79.831-1.735.831-2.754 0-2.761-2.238-5-5-5s-5 2.239-5 5 2.238 5 5 5c1.019 0 1.964-.309 2.755-.832l2.831 2.832 1.414-1.414zm-10-5.586c0-1.654 1.346-3 3-3s3 1.346 3 3-1.346 3-3 3-3-1.346-3-3z"/></svg>
                            <span>20</span>
                            <span>Get Analytic</span>
                        </div>
                    </a>
                </div>
                <div class="card-add">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#1e4267" width="80" viewBox="0 0 24 24"><path d="M14 9h-12c-1.104 0-2 .896-2 2v8c0 1.104.896 2 2 2h12c1.104 0 2-.896 2-2v-8c0-1.104-.896-2-2-2zm-1 4h-10v-1h10v1zm-4.757-9h2.757v2h-2.103c-.514 0-1.008.198-1.38.553l-.469.447h-3.048l2.121-2.121c.563-.563 1.326-.879 2.122-.879zm9.817 1c0 1.104-.896 2-2 2h-4.06v-4h4.06c1.104 0 2 .895 2 2zm5.94 5v10l-6-3v-4l6-3z"/></svg>
                    <div>Add Video</div>
                </div>
            </div>

      <?php require './components/pop_up_add.php'?>

    </section>
    <!-- sidebar right -->
    <?php require './components/sidebar-right2.php'?>
  </main>

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript">
      $(document).ready(function () {
          $(".js-selected-tags").select2({
              placeholder: 'Choose tags',
              tags: true,
              tokenSeparators: [',', ' ']
          });
          let lastFileVideo = '';
          let thumbnail = '';
          $('#choice-video').change(function(){
              // console.log($('#choice-video').val());
              if ($('#choice-video').val() != '' || $('#choice-video').val() != lastFileVideo) {
                  // $('.video label svg:first-child').css('display', 'block')
                  // $('.video label svg:last-child').css('display', 'none')
                  $('.video h5').css('display', 'none')
                  $('.video video').css('display', 'block')
                  let thumb_res = thumbnail == '' ? 'thumbnail.jpg' : thumbnail; 
                  $('.video video').attr('poster',`assets/uploads/thumbs/${thumb_res}`)
                  // $('.video video').attr('src',`assets/uploads/thumbs/${thumb_res}`)

                  const [file] = $('#choice-video')[0].files
                  console.log(URL.createObjectURL(file));
                  if ($('#choice-thumbnail') != '') {
                      $('.video video').attr('src', URL.createObjectURL(file))
                  }
              }
              lastFileVideo = $('#choice-video').val()
          })
          
          if ($('#choice-thumbnail').val() == '') {
              $('.preview img').css('display', 'none')
          }

          $('#choice-thumbnail').change(function(){
              $('.preview img').css('display', 'block')
              $('.preview h6').css('display', 'none')
              const [file] = $('#choice-thumbnail')[0].files
              // console.log(file);
              if ($('#choice-thumbnail') != '') {
                  $('.preview img').attr('src', URL.createObjectURL(file))
                  $('.video video').attr('poster',URL.createObjectURL(file))
              }
          })
  
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

              // disabled the submit button
              $(".btn-submit").prop("disabled", true);
              $.ajax({
                  type: "POST",
                  enctype: 'multipart/form-data',
                  url: "./lib/upload_video.php",
                  data: data,
                  processData: false,
                  contentType: false,
                  cache: false,
                  timeout: 60000,
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
                      // $('.confirmation .progress').addClass('hideProgress')
                      Swal.fire({
                          position: 'center',
                          icon: 'success',
                          text: data.message,
                          showConfirmButton: true
                      }).then((result) => {
                      /* Read more about isConfirmed, isDenied below */
                          if (result.isConfirmed) {
                              location.reload(true);
                          } else if (result.isDenied) {
                              location.reload(true);
                          }
                      })
                      // 
                      // console.log("SUCCESS : ", data);
                      

              }).fail(function (e) {
                  // $("#result").text(e.responseText);
                  console.log("ERROR : ", e);
                  location.reload(true);
                  $(".btn-submit").prop("disabled", false);
              })

          });
      })
      
  </script>
  <script src="https://unpkg.com/pell"></script>
  <script src="./assets/js/navbar/menu_setting.js"></script>
  <script src="./assets/js/navbar/pop_up_add.js"></script>
  <script src="./assets/js/navbar/logout.js"></script>

</body>

</html>