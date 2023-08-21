let add = document.querySelector(".add");
let btn_close = document.querySelector(".btn-close");
let container_pop_up = document.querySelector(".container-pop-up");
const pell = window.pell;
const editor = document.getElementById("editor");
let tempDesc = "";

const url = window.location.href;
let currentUrl = url.split("/").at(-1).split(".php")[0];

if (currentUrl.toLowerCase() != "dashboard") {
  add.style.display = "none";
}

$(document).ready(function () {
  $("#imdb-form").submit(function (e) {
    e.preventDefault();
    const options = {
      method: "GET",
      headers: {
        accept: "application/json",
        Authorization:
          "Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5OGI5NTY0ZjAxOGQzMTczNGVmNjYwZmQ3NWVmNGMxMCIsInN1YiI6IjVlYzI2MTI2Y2RmMmU2MDAyMjUwODQ5MCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zxY2_YSK_ngsYZXLawaltLEHO3Pgi4k1KnblEGFmEHc",
      },
    };

    const urlMovie = `https://api.themoviedb.org/3/movie/${$(".tmdb-id").val()}`; // kita akan mengambil data movie sesuai dengan id nya dari URL ini

    fetch(urlMovie, options)
      .then(async (response) => {
        // kemudian setalah mendapatkan response dari TMDB baru kita automatis isi form input  title, dll.
        response = await response.json();
        let title = response.original_title;
        let description = response.overview;
        let backdrop = `http://image.tmdb.org/t/p/w300${response.backdrop_path}`;
        let poster = `http://image.tmdb.org/t/p/w185${response.poster_path}`;
        let rating = response.vote_average;
        let tags = response.genres.map(function (genre, index) {
          genre.id = genre.name;
          genre.text = genre.name;
          delete genre.name;
          genre["selected"] = true;
          return genre;
        });

        $(".title").val(title); // disini kita auto isi form input title
        $(".rating").val(rating);
        $("#editor .pell-content").html(description);
        tempDesc = description;

        $(".js-selected-tags").select2({
          data: tags,
        });

        // backdrop
        $(".preview img").css("display", "block");
        $(".preview h6").css("display", "none");
        $(".preview img").attr("src", backdrop);
        $(".video video").attr("poster", backdrop);
        $("#choice-thumbnail-hidden").val(backdrop);

        // backdrop
        $(".preview-poster img").css("display", "block");
        $(".preview-poster h6").css("display", "none");
        $(".preview-poster img").attr("src", backdrop);
        $("#choice-poster-hidden").val(poster);
      })
      .catch((err) => console.error(err));
  });
});

pell.init({
  element: editor,
  onChange: (html) => {
    tempDesc = html;
    // console.log(tempDesc);
  },
});
// $(document).ready(function () {
add.addEventListener("click", function () {
  togglePopUp();
});

btn_close.addEventListener("click", function () {
  togglePopUp();
});

$(".card-add").click(function () {
  togglePopUp();
});

let togglePopUp = function () {
  container_pop_up.classList.toggle("invisible-pop-up");
  if (!container_pop_up.classList.contains("invisible-pop-up")) {
    $(".title").val("");
    // $('.js-selected-tags').empty()
    $(".pell-content").empty();
    $("#choice-video").val("");
    $("#choice-thumbnail").val("");
    $(".checkmark").css("display", "none");
    $(".video label svg:last-child").css("display", "block");
    $(".preview img").css("display", "none");
    $(".preview h6").css("display", "block");
    $(".preview img").attr("src", "");
    $(".confirmation .progress").addClass("hideProgress");
  }
};
// })
