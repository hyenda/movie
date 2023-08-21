<?php
session_start();
require 'koneksi.php';

require './lib/cookie.php'


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Account</title>

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/pell/dist/pell.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="assets/css/settings.css">
    <link rel="stylesheet" href="assets/css/components/header.css">
    <link rel="stylesheet" href="assets/css/components/sidebar.css">
    <link rel="stylesheet" href="assets/css/components/pop_up_add.css">

</head>
<body>
    
    <?php require 'components/header.php';?>
    
    <div class="container">
        <?php require './components/sidebar.php'?>

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
                            <input class="btn-submit-setting" name="btn_submit" type="submit" value="Save Setting">
                    </div>
                    <div class="right-information">
                        <div class="container-image-user">
                            <img class="image-user" src="<?= $user_info['image']?>" alt="">
                        </div>
                        <label class="btn-up-image" for="up-image">
                            Change Picture
                        </label>
                        <input type="file" name="image" class="up-image" id="up-image">
                        <input type="hidden" name="image-hidden" class="up-image-hidden" id="up-image-hidden" value="<?= $user_info['image']?>">
                    </div>
                </div>
            </form>
        </div>
        <?php require './components/pop_up_add.php'?>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/pell"></script>
    <script src="./assets/js/navbar/menu_setting.js"></script>
    <script src="./assets/js/navbar/pop_up_add.js"></script>
    <script src="./assets/js/navbar/logout.js"></script>

    <script>
        $('.up-image').change(function () {
            const [file] = $('.up-image')[0].files
            $('.image-user').attr('src', URL.createObjectURL(file))
        })

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